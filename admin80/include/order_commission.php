<?php
// Xử lý khi đơn hàng được Admin duyệt: sinh hoa hồng sơ đồ trực tiếp (9 tầng)
// và kích hoạt business_active + commission_active. Ref: docs/BUSINESS_RULES.md mục 3 (Mua hàng), mục 4
// (Hoa hồng trực tiếp), mục 5 (pending/release theo commission_active, cập nhật 2026-07-11), mục 2 (Ví).
// Toàn bộ chạy trong 1 transaction, rollback nếu lỗi (mục 8.2 - Transaction).

// ----- Thông báo Telegram (mục 12 BUSINESS_RULES.md) -----
// Cùng 1 bot nhưng tách 2 nhóm nhận theo loại sự kiện: nhóm đơn hàng (đơn mới/đơn duyệt) và nhóm rút tiền
// (yêu cầu rút tiền mới/hủy rút tiền). Bot token/chat_id fix cứng theo yêu cầu admin, không qua sys_config.
// File này đã được require_once từ cả 2 phía (storefront: modules/basket/order.php,
// modules/user/xu_ly_rut_tien.php, modules/user/huy_rut_tien.php; admin: admin80/modules/order/index.php,
// approve.php) nên là nơi dùng chung phù hợp.
if (!defined('TELEGRAM_BOT_TOKEN')) define('TELEGRAM_BOT_TOKEN', '8092627569:AAG0AUsX69FiJDIZaWqPz_Gyi_8bCdR_dZY');
if (!defined('TELEGRAM_CHAT_ID_ORDER')) define('TELEGRAM_CHAT_ID_ORDER', '-1004389598472');
if (!defined('TELEGRAM_CHAT_ID_WITHDRAW')) define('TELEGRAM_CHAT_ID_WITHDRAW', '-1003863677517');

// Gửi 1 tin nhắn Telegram tới $chatId cho bot đã cấu hình. Best-effort: lỗi mạng/Telegram không được làm
// gián đoạn luồng nghiệp vụ chính (đơn hàng, ví, rút tiền) - chỉ ghi log nếu thất bại, không throw ra ngoài.
function sendTelegramNotify($message, $chatId) {
    try {
        $url = 'https://api.telegram.org/bot' . TELEGRAM_BOT_TOKEN . '/sendMessage';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_exec($ch);
        if (curl_errno($ch)) {
            error_log("sendTelegramNotify curl error: " . curl_error($ch));
        }
        curl_close($ch);
    } catch (Throwable $e) {
        error_log("sendTelegramNotify: " . $e->getMessage());
    }
}

function processOrderApproval($mysqli, $order_id) {
    $mysqli->begin_transaction();
    try {
        $stmt = $mysqli->prepare("SELECT user_id, amount, name, email, mobile, address, note, products, commission_generated FROM orders WHERE id = ? FOR UPDATE");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        // Đơn không tồn tại hoặc đã sinh hoa hồng rồi thì bỏ qua (chống sinh 2 lần)
        if (!$order || (int)$order['commission_generated'] === 1) {
            $mysqli->commit();
            return;
        }

        $buyerId = (int)$order['user_id'];
        $amount = (float)$order['amount'];

        activateBusinessIfEligible($mysqli, $buyerId, $order_id);
        activateCommissionIfEligible($mysqli, $buyerId, $order_id);
        generateDirectCommission($mysqli, $order_id, $buyerId);
        generateBackfillSpilloverCommissionIfEligible($mysqli, $order_id, $buyerId);

        $stmt = $mysqli->prepare("UPDATE orders SET commission_generated = 1 WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        $mysqli->commit();

        sendOrderApprovedEmail($order_id, $order);
        sendTelegramNotify(
            "✅ <b>Đơn hàng #{$order_id} đã được duyệt</b>\n" .
            "Khách hàng: " . htmlspecialchars($order['name']) . "\n" .
            "SĐT: " . htmlspecialchars($order['mobile']) . "\n" .
            "Tổng tiền: " . number_format($amount, 0, ',', '.') . "đ",
            TELEGRAM_CHAT_ID_ORDER
        );
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log("processOrderApproval order_id={$order_id}: " . $e->getMessage());
    }
}

// Xử lý khi đơn hàng bị Admin từ chối: đơn từ chối không sinh hoa hồng (mục 3 BUSINESS_RULES.md - hoa hồng
// chỉ sinh khi duyệt). Điểm thẻ/ví đã trừ lúc khách đặt đơn (mục 3 - Quy tắc thanh toán đơn hàng, cập nhật
// 2026-07-11) thì được hoàn lại, giống cơ chế hoàn tiền khi từ chối rút tiền (mục 7).
function processOrderRejection($mysqli, $order_id) {
    $mysqli->begin_transaction();
    try {
        $stmt = $mysqli->prepare("SELECT name, mobile, amount, user_id FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$order) {
            $mysqli->commit();
            return;
        }

        refundOrderPaymentIfAny($mysqli, $order_id, (int) $order['user_id']);

        $mysqli->commit();
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log("processOrderRejection order_id={$order_id}: " . $e->getMessage());
        return;
    }

    sendTelegramNotify(
        "⛔ <b>Đơn hàng #{$order_id} đã bị từ chối</b>\n" .
        "Khách hàng: " . htmlspecialchars($order['name']) . "\n" .
        "SĐT: " . htmlspecialchars($order['mobile']) . "\n" .
        "Tổng tiền: " . number_format((float) $order['amount'], 0, ',', '.') . "đ",
        TELEGRAM_CHAT_ID_ORDER
    );
}

// Hoàn lại điểm thẻ tiêu dùng + ví tiêu dùng + ví khả dụng đã trừ lúc đặt đơn (order_payments, mục 3) khi
// đơn bị admin từ chối. Không hoàn cash_amount (tiền mặt/chuyển khoản QR, không qua ví hệ thống). Khoá dòng
// order_payments và chỉ hoàn nếu refunded_at còn NULL, chống hoàn 2 lần nếu bị từ chối nhiều lần (mục 8.1).
// Bỏ qua nếu đơn không có order_payments (đơn không dùng điểm thẻ/ví nào, hoặc đơn tạo trước khi luồng này
// được triển khai).
function refundOrderPaymentIfAny($mysqli, $order_id, $userId) {
    $stmt = $mysqli->prepare("SELECT id, card_amount, tich_luy_amount, tieu_dung_amount, kha_dung_amount FROM order_payments WHERE order_id = ? AND refunded_at IS NULL FOR UPDATE");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $payment = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$payment) return;

    $cardAmount = (float) $payment['card_amount'];
    $tichLuyAmount = (float) $payment['tich_luy_amount'];
    $tieuDungAmount = (float) $payment['tieu_dung_amount'];
    $khaDungAmount = (float) $payment['kha_dung_amount'];

    if ($cardAmount > 0) creditConsumptionCard($mysqli, $userId, $cardAmount);
    if ($tichLuyAmount > 0) creditWallet($mysqli, $userId, 'tich_luy_tieu_dung', $tichLuyAmount, 'refund', $order_id);
    if ($tieuDungAmount > 0) creditWallet($mysqli, $userId, 'tieu_dung', $tieuDungAmount, 'refund', $order_id);
    if ($khaDungAmount > 0) creditWallet($mysqli, $userId, 'kha_dung', $khaDungAmount, 'refund', $order_id);

    $upd = $mysqli->prepare("UPDATE order_payments SET refunded_at = NOW() WHERE id = ?");
    $upd->bind_param("i", $payment['id']);
    $upd->execute();
    $upd->close();
}

// Đơn có chứa sản phẩm combo kích hoạt -> kích hoạt business_active cho người mua (chỉ set 1 lần).
// Việc thêm vào spillover_waiting_list do trigger DB `trg_user_business_active_waitlist` đảm nhận (bắt
// được cả trường hợp business_active bị sửa tay trực tiếp trong database, xem migration
// database/migration_2026-07-11_commission_active.sql), không còn gọi trực tiếp từ đây.
function activateBusinessIfEligible($mysqli, $userId, $order_id) {
    if (!orderContainsActivationCombo($mysqli, $order_id)) return;

    $stmt = $mysqli->prepare("SELECT business_active FROM user WHERE id = ? FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user || (int)$user['business_active'] === 1) return;

    $upd = $mysqli->prepare("UPDATE user SET business_active = 1 WHERE id = ?");
    $upd->bind_param("i", $userId);
    $upd->execute();
    $upd->close();

    $ordUpd = $mysqli->prepare("UPDATE orders SET is_activation_package = 1 WHERE id = ?");
    $ordUpd->bind_param("i", $order_id);
    $ordUpd->execute();
    $ordUpd->close();

    creditConsumptionCard($mysqli, $userId, 5000000);
}

// Đơn có chứa sản phẩm combo kích hoạt -> kích hoạt commission_active cho người mua (chỉ set 1 lần).
// Tách riêng khỏi activateBusinessIfEligible (mục 5 BUSINESS_RULES.md, cập nhật 2026-07-11) để xử lý đúng
// trường hợp đặc biệt: business_active đã được set tay = 1 trước đó (chưa mua combo thật) nhưng
// commission_active vẫn = 0 -> guard của activateBusinessIfEligible chặn chạy lại nên phải kiểm tra
// commission_active độc lập ở đây, không phụ thuộc business_active đã set trước đó hay chưa.
// Khi commission_active chuyển sang 1: release toàn bộ hoa hồng cây điều tầng + thưởng danh hiệu (chung
// bảng commissions) + thưởng điểm thẻ tiêu dùng + thưởng tiêu dùng tuần hoàn đang pending, cộng ví 1 lần.
function activateCommissionIfEligible($mysqli, $userId, $order_id) {
    if (!orderContainsActivationCombo($mysqli, $order_id)) return;

    $stmt = $mysqli->prepare("SELECT commission_active FROM user WHERE id = ? FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user || (int)$user['commission_active'] === 1) return;

    $upd = $mysqli->prepare("UPDATE user SET commission_active = 1 WHERE id = ?");
    $upd->bind_param("i", $userId);
    $upd->execute();
    $upd->close();

    releasePendingCommissions($mysqli, $userId);
    releasePendingAccumulatedConsumptionBonuses($mysqli, $userId);
    releasePendingRecurringConsumptionBonuses($mysqli, $userId);
}

// Đơn hàng có chứa ít nhất 1 sản phẩm được admin đánh dấu "combo kích hoạt" hay không
// (sys_product.is_activation_combo, quản lý tại admin80/modules/activation_combo). Mục 3 BUSINESS_RULES.md:
// kích hoạt business_active theo đúng sản phẩm mua, không còn tính theo tổng tiền đơn hàng.
function orderContainsActivationCombo($mysqli, $order_id) {
    $stmt = $mysqli->prepare("
        SELECT COUNT(*) c
        FROM order_items oi
        JOIN sys_product p ON p.id = oi.product_id
        WHERE oi.order_id = ? AND p.is_activation_combo = 1
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $count = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
    $stmt->close();
    return $count > 0;
}

// Khi kích hoạt gói 5tr lần đầu: cộng điểm thẻ tiêu dùng (mục 2 - Ví)
function creditConsumptionCard($mysqli, $userId, $amount) {
    $stmt = $mysqli->prepare("INSERT INTO consumption_cards (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + VALUES(balance)");
    $stmt->bind_param("id", $userId, $amount);
    $stmt->execute();
    $stmt->close();
}

// Trừ điểm thẻ tiêu dùng để thanh toán đơn hàng (mục 3 BUSINESS_RULES.md, cập nhật 2026-07-11): trừ tối đa
// $maxAmount nhưng không vượt quá số dư hiện có - không báo lỗi nếu thiếu, chỉ trừ được bao nhiêu hay bấy
// nhiêu (phần còn thiếu sẽ do các nguồn thanh toán tiếp theo đảm nhận). Trả về số tiền thực trừ được.
function debitConsumptionCardUpTo($mysqli, $userId, $maxAmount) {
    if ($maxAmount <= 0) return 0;

    $stmt = $mysqli->prepare("SELECT balance FROM consumption_cards WHERE user_id = ? FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $current = (float) ($stmt->get_result()->fetch_assoc()['balance'] ?? 0);
    $stmt->close();

    $actual = min($maxAmount, $current);
    if ($actual <= 0) return 0;

    $stmt = $mysqli->prepare("UPDATE consumption_cards SET balance = balance - ? WHERE user_id = ?");
    $stmt->bind_param("di", $actual, $userId);
    $stmt->execute();
    $stmt->close();

    return $actual;
}

// Khi commission_active chuyển sang 1 (cập nhật 2026-07-11): release toàn bộ hoa hồng đang pending của
// người đó (hoa hồng cây điều tầng + thưởng danh hiệu, chung bảng commissions).
function releasePendingCommissions($mysqli, $userId) {
    $stmt = $mysqli->prepare("SELECT id, amount FROM commissions WHERE user_id = ? AND status = 'pending' FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $pendingList = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    foreach ($pendingList as $pending) {
        $upd = $mysqli->prepare("UPDATE commissions SET status = 'released', released_at = NOW() WHERE id = ?");
        $upd->bind_param("i", $pending['id']);
        $upd->execute();
        $upd->close();

        creditWalletFromCommission($mysqli, $userId, (float)$pending['amount'], (int)$pending['id']);
    }
}

// Khi commission_active chuyển sang 1 (mục 5, cập nhật 2026-07-13): release toàn bộ Tích lũy tiêu dùng đang
// pending của người đó, cộng thẳng vào user_wallets.tich_luy_tieu_dung (ví riêng, khác điểm thẻ tiêu dùng -
// consumption_cards.balance - giữ nguyên không đổi).
function releasePendingAccumulatedConsumptionBonuses($mysqli, $userId) {
    $stmt = $mysqli->prepare("SELECT id, amount FROM accumulated_consumption_bonuses WHERE user_id = ? AND status = 'pending' FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $pendingList = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    foreach ($pendingList as $pending) {
        $upd = $mysqli->prepare("UPDATE accumulated_consumption_bonuses SET status = 'released', released_at = NOW() WHERE id = ?");
        $upd->bind_param("i", $pending['id']);
        $upd->execute();
        $upd->close();

        creditWallet($mysqli, $userId, 'tich_luy_tieu_dung', (float)$pending['amount'], 'accumulated_consumption', (int)$pending['id']);
    }
}

// Khi commission_active chuyển sang 1 (mục 5, mục 6, cập nhật 2026-07-11): release toàn bộ thưởng tiêu
// dùng tuần hoàn đang pending của người đó, cộng thẳng vào ví tiêu dùng (user_wallets.tieu_dung) qua
// creditWallet() có sẵn.
function releasePendingRecurringConsumptionBonuses($mysqli, $userId) {
    $stmt = $mysqli->prepare("SELECT id, amount FROM recurring_consumption_bonuses WHERE user_id = ? AND status = 'pending' FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $pendingList = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    foreach ($pendingList as $pending) {
        $upd = $mysqli->prepare("UPDATE recurring_consumption_bonuses SET status = 'released', released_at = NOW() WHERE id = ?");
        $upd->bind_param("i", $pending['id']);
        $upd->execute();
        $upd->close();

        creditWallet($mysqli, $userId, 'tieu_dung', (float)$pending['amount'], 'card_bonus', (int)$pending['id']);
    }
}

// Tính "quỹ chia hoa hồng" của 1 đơn hàng (mục 3 BUSINESS_RULES.md, cập nhật 2026-07-11): dùng chung cho cả
// hoa hồng trực tiếp (mục 4) và hoa hồng cây lấp tầng + thưởng (mục 6), độc lập, không trừ lẫn nhau.
// Trước đó công thức là 60% giá trị đơn hàng (cố định cho mọi đơn); nay thay bằng tổng "hoa hồng sản phẩm"
// (sys_product.commission_amount, số tiền VND admin tự nhập cố định cho từng sản phẩm) theo từng dòng
// order_items, rồi trừ đi phần đã thanh toán bằng điểm thẻ tiêu dùng (order_payments.card_amount - luồng
// trừ điểm thẻ khi tạo đơn hiện chưa code nên cột này luôn = 0 cho tới khi luồng đó được triển khai, không
// ảnh hưởng tới đơn hàng hiện tại). Sản phẩm chưa được admin nhập commission_amount coi như đóng góp 0đ.
// "Quỹ công ty" (mục 3) = giá trị đơn hàng - tổng hoa hồng sản phẩm, không bị ảnh hưởng bởi điểm thẻ đã
// dùng - không cần tính/lưu ở đây vì không dùng cho nghiệp vụ nào khác.
// (cập nhật 2026-07-13: Tích lũy tiêu dùng - order_payments.tich_luy_amount - cũng trừ khỏi quỹ chia hoa
// hồng giống điểm thẻ tiêu dùng, xem mục 6 BUSINESS_RULES.md.)
function calculateCommissionFund($mysqli, $order_id) {
    $stmt = $mysqli->prepare("
        SELECT COALESCE(SUM(oi.quantity * p.commission_amount), 0) AS total
        FROM order_items oi
        JOIN sys_product p ON p.id = oi.product_id
        WHERE oi.order_id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $productCommissionSum = (float) ($stmt->get_result()->fetch_assoc()['total'] ?? 0);
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT card_amount, tich_luy_amount FROM order_payments WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $payment = $stmt->get_result()->fetch_assoc();
    $cardAmount = (float) ($payment['card_amount'] ?? 0);
    $tichLuyAmount = (float) ($payment['tich_luy_amount'] ?? 0);
    $stmt->close();

    return max(0, $productCommissionSum - $cardAmount - $tichLuyAmount);
}

// Chia hoa hồng sơ đồ trực tiếp 8 tầng (f1..f8 theo sys_config) trên quỹ chia hoa hồng (mục 3, cập nhật
// 2026-07-11). F1 = 16%, F2..F8 mỗi tầng 2% = tổng 30% (mục 4 BUSINESS_RULES.md, cập nhật 2026-07-10: bỏ
// tầng F9).
function generateDirectCommission($mysqli, $order_id, $buyerId) {
    $commissionFund = calculateCommissionFund($mysqli, $order_id);

    // Quỹ vận hành: 10% quỹ chia hoa hồng của MỌI đơn đã duyệt (mục 3 BUSINESS_RULES.md), chia đều 5 quỹ con
    creditOperatingFund($mysqli, $order_id, 'direct_commission', $commissionFund * 0.10);

    $rates = [];
    $res = $mysqli->query("SELECT name, value FROM sys_config WHERE name IN ('f1','f2','f3','f4','f5','f6','f7','f8') AND lang = 'vn'");
    while ($row = $res->fetch_assoc()) {
        $rates[$row['name']] = (float)$row['value'];
    }

    $currentUserId = $buyerId;
    for ($level = 1; $level <= 8; $level++) {
        $stmt = $mysqli->prepare("SELECT ref_by FROM user WHERE id = ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $current = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$current || !$current['ref_by']) break;

        $uplineId = (int)$current['ref_by'];
        $rate = isset($rates['f' . $level]) ? $rates['f' . $level] : 0;
        $commissionAmount = round($commissionFund * $rate, 2);

        if ($commissionAmount > 0) {
            creditDirectCommission($mysqli, $order_id, $uplineId, $level, $commissionAmount);
        }

        $currentUserId = $uplineId;
    }
}

// Sinh 1 dòng hoa hồng cho 1 người ở 1 tầng. Hoa hồng cây trực tiếp LUÔN released và cộng ví ngay,
// bất kể business_active của người nhận (khác với hoa hồng cây lấp tầng/thưởng - xem BUSINESS_RULES.md).
function creditDirectCommission($mysqli, $order_id, $userId, $level, $amount) {
    $status = 'released';
    $releasedAt = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("INSERT INTO commissions (order_id, user_id, level, type, amount, status, released_at) VALUES (?, ?, ?, 'direct', ?, ?, ?)");
    $stmt->bind_param("iiidss", $order_id, $userId, $level, $amount, $status, $releasedAt);
    $stmt->execute();
    $commissionId = $mysqli->insert_id;
    $stmt->close();

    creditWalletFromCommission($mysqli, $userId, $amount, $commissionId);
}

// Quỹ vận hành (mục 3 BUSINESS_RULES.md): $amount đổ vào tự động chia đều 20% cho mỗi quỹ trong 5 quỹ con.
// $source: 'direct_commission' (10% quỹ chia hoa hồng mỗi đơn) | 'rebuy' (phần còn lại của quỹ hoa hồng
// Rebuy sau khi chia 3 khoản, mục 6 - Giao dịch tái tiêu dùng tự động). $rebuy_id: truyền khi $source =
// 'rebuy', $order_id để null trong trường hợp đó (giao dịch Rebuy không có đơn hàng gốc). Chỉ ghi log vào
// admin_fund_transactions - quỹ này chỉ hiển thị trên admin, không có thao tác cộng/trừ ví nào khác đi kèm.
// (cập nhật 2026-07-15: 'card_bonus' không còn đổ vào đây - xem creditCompanyCardFund()).
function creditOperatingFund($mysqli, $order_id, $source, $amount, $rebuy_id = null) {
    if ($amount <= 0) return;

    $fundCodes = ['thi_truong_leader', 'van_phong', 'dao_tao', 'it_van_hanh', 'du_phong'];
    $perFundAmount = round($amount * 0.20, 2);
    if ($perFundAmount <= 0) return;

    foreach ($fundCodes as $fundCode) {
        $stmt = $mysqli->prepare("INSERT INTO admin_fund_transactions (fund_code, source, order_id, rebuy_id, amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiid", $fundCode, $source, $order_id, $rebuy_id, $perFundAmount);
        $stmt->execute();
        $stmt->close();
    }
}

// Quỹ tiêu dùng tuần hoàn công ty (bổ sung 2026-07-15, mục 6 BUSINESS_RULES.md): nhận 30% còn lại của
// thưởng tiêu dùng tuần hoàn (trước đó chung với quỹ vận hành, source='card_bonus'), chia đều 3 phần bằng
// nhau (mỗi phần = 10% quỹ chia hoa hồng gốc, cộng lại đúng bằng 30% $amount truyền vào):
// cp_nen_tang (chi phí nền tảng - nhân sự, IT) | bdh_leader (Ban điều hành & Leader) | du_phong_the (quỹ dự
// phòng riêng của khoản này, KHÔNG gộp chung số dư với du_phong của quỹ vận hành). Chỉ ghi log vào
// admin_fund_transactions, không có thao tác cộng/trừ ví nào khác đi kèm (giống creditOperatingFund()).
function creditCompanyCardFund($mysqli, $order_id, $amount) {
    if ($amount <= 0) return;

    $fundCodes = ['cp_nen_tang', 'bdh_leader', 'du_phong_the'];
    $perFundAmount = round($amount / 3, 2);
    if ($perFundAmount <= 0) return;

    foreach ($fundCodes as $fundCode) {
        $stmt = $mysqli->prepare("INSERT INTO admin_fund_transactions (fund_code, source, order_id, amount) VALUES (?, 'card_bonus', ?, ?)");
        $stmt->bind_param("sid", $fundCode, $order_id, $perFundAmount);
        $stmt->execute();
        $stmt->close();
    }
}

// Cộng vào ví tổng (theo dõi) rồi tự động chia 60/20/10/10 vào 4 ví thực (mục 2)
function creditWalletFromCommission($mysqli, $userId, $amount, $commissionId) {
    creditWallet($mysqli, $userId, 'tong', $amount, 'commission', $commissionId);

    $khaDung = round($amount * 0.6, 2);
    $tieuDung = round($amount * 0.2, 2);
    $taiTieuDung = round($amount * 0.1, 2);
    $thuePhi = round($amount - $khaDung - $tieuDung - $taiTieuDung, 2); // phần dư làm tròn dồn vào thuế phí

    creditWallet($mysqli, $userId, 'kha_dung', $khaDung, 'commission', $commissionId);
    creditWallet($mysqli, $userId, 'tieu_dung', $tieuDung, 'commission', $commissionId);
    creditTaiTieuDungCapped($mysqli, $userId, $taiTieuDung, 'commission', $commissionId);
    creditWallet($mysqli, $userId, 'thue_phi', $thuePhi, 'commission', $commissionId);
}

function ensureWalletRow($mysqli, $userId) {
    $stmt = $mysqli->prepare("INSERT IGNORE INTO user_wallets (user_id) VALUES (?)");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// Cộng vào 1 trong các ví: tong | kha_dung | tieu_dung | thue_phi | tich_luy_tieu_dung (tai_tieu_dung xử lý
// riêng do có trần 258tr)
function creditWallet($mysqli, $userId, $walletType, $amount, $refType, $refId) {
    if ($amount <= 0) return;

    $allowedColumns = ['tong', 'kha_dung', 'tieu_dung', 'thue_phi', 'tich_luy_tieu_dung'];
    if (!in_array($walletType, $allowedColumns, true)) return;

    ensureWalletRow($mysqli, $userId);

    $stmt = $mysqli->prepare("UPDATE user_wallets SET `$walletType` = `$walletType` + ? WHERE user_id = ?");
    $stmt->bind_param("di", $amount, $userId);
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT `$walletType` FROM user_wallets WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $balanceAfter = (float)$stmt->get_result()->fetch_assoc()[$walletType];
    $stmt->close();

    $stmt = $mysqli->prepare("INSERT INTO wallet_transactions (user_id, wallet_type, direction, amount, balance_after, ref_type, ref_id) VALUES (?, ?, 'credit', ?, ?, ?, ?)");
    $stmt->bind_param("isddsi", $userId, $walletType, $amount, $balanceAfter, $refType, $refId);
    $stmt->execute();
    $stmt->close();
}

// Trừ 1 trong các ví: tong | kha_dung | tieu_dung | thue_phi. Trả về false nếu không đủ số dư (không trừ).
// Dùng cho nghiệp vụ Rút tiền (mục 7): trừ kha_dung ngay khi user tạo yêu cầu rút.
function debitWallet($mysqli, $userId, $walletType, $amount, $refType, $refId) {
    if ($amount <= 0) return false;

    $allowedColumns = ['tong', 'kha_dung', 'tieu_dung', 'tai_tieu_dung', 'thue_phi'];
    if (!in_array($walletType, $allowedColumns, true)) return false;

    ensureWalletRow($mysqli, $userId);

    $stmt = $mysqli->prepare("SELECT `$walletType` FROM user_wallets WHERE user_id = ? FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $current = (float)$stmt->get_result()->fetch_assoc()[$walletType];
    $stmt->close();

    if ($current < $amount) return false;

    $stmt = $mysqli->prepare("UPDATE user_wallets SET `$walletType` = `$walletType` - ? WHERE user_id = ?");
    $stmt->bind_param("di", $amount, $userId);
    $stmt->execute();
    $stmt->close();

    $balanceAfter = $current - $amount;

    $stmt = $mysqli->prepare("INSERT INTO wallet_transactions (user_id, wallet_type, direction, amount, balance_after, ref_type, ref_id) VALUES (?, ?, 'debit', ?, ?, ?, ?)");
    $stmt->bind_param("isddsi", $userId, $walletType, $amount, $balanceAfter, $refType, $refId);
    $stmt->execute();
    $stmt->close();

    return true;
}

// Trừ 1 trong các ví (kha_dung | tieu_dung | tich_luy_tieu_dung) để thanh toán đơn hàng (mục 3
// BUSINESS_RULES.md, cập nhật 2026-07-13): trừ tối đa $maxAmount nhưng không vượt quá số dư hiện có - không
// báo lỗi nếu thiếu, chỉ trừ được bao nhiêu hay bấy nhiêu (phần còn thiếu do nguồn tiếp theo trong thứ tự ưu
// tiên đảm nhận). Trả về số tiền thực trừ được, khác debitWallet() (đòi hỏi đủ số dư mới trừ, dùng cho rút tiền).
function debitWalletUpTo($mysqli, $userId, $walletType, $maxAmount, $refType, $refId) {
    if ($maxAmount <= 0) return 0;

    $allowedColumns = ['kha_dung', 'tieu_dung', 'tich_luy_tieu_dung'];
    if (!in_array($walletType, $allowedColumns, true)) return 0;

    ensureWalletRow($mysqli, $userId);

    $stmt = $mysqli->prepare("SELECT `$walletType` FROM user_wallets WHERE user_id = ? FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $current = (float) $stmt->get_result()->fetch_assoc()[$walletType];
    $stmt->close();

    $actual = min($maxAmount, $current);
    if ($actual <= 0) return 0;

    $stmt = $mysqli->prepare("UPDATE user_wallets SET `$walletType` = `$walletType` - ? WHERE user_id = ?");
    $stmt->bind_param("di", $actual, $userId);
    $stmt->execute();
    $stmt->close();

    $balanceAfter = $current - $actual;

    $stmt = $mysqli->prepare("INSERT INTO wallet_transactions (user_id, wallet_type, direction, amount, balance_after, ref_type, ref_id) VALUES (?, ?, 'debit', ?, ?, ?, ?)");
    $stmt->bind_param("isddsi", $userId, $walletType, $actual, $balanceAfter, $refType, $refId);
    $stmt->execute();
    $stmt->close();

    return $actual;
}

// Duyệt/từ chối yêu cầu rút tiền (mục 7 - Rút tiền).
// kha_dung đã bị trừ ngay lúc tạo yêu cầu (modules/user/xu_ly_rut_tien.php), nên:
// - approve: chỉ xác nhận đã chuyển khoản, không đụng ví.
// - reject: hoàn lại kha_dung đã trừ.
// Khoá dòng transactions và chỉ xử lý nếu đang pending, chống duyệt/từ chối 2 lần (mục 8.1).
function processWithdrawDecision($mysqli, $transactionId, $approve) {
    $mysqli->begin_transaction();
    try {
        $stmt = $mysqli->prepare("SELECT user_id, amount, type, status, bank_account_holder FROM transactions WHERE id = ? FOR UPDATE");
        $stmt->bind_param("i", $transactionId);
        $stmt->execute();
        $tx = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$tx || $tx['type'] !== 'withdraw' || $tx['status'] !== 'pending') {
            $mysqli->commit();
            return;
        }

        $newStatus = $approve ? 'approved' : 'rejected';
        $upd = $mysqli->prepare("UPDATE transactions SET status = ?, updated_at = NOW() WHERE id = ?");
        $upd->bind_param("si", $newStatus, $transactionId);
        $upd->execute();
        $upd->close();

        if (!$approve) {
            creditWallet($mysqli, (int)$tx['user_id'], 'kha_dung', (float)$tx['amount'], 'refund', $transactionId);
        }

        $mysqli->commit();

        $label = $approve ? '✅ đã DUYỆT' : '⛔ đã TỪ CHỐI';
        sendTelegramNotify(
            "{$label} <b>yêu cầu rút tiền #{$transactionId}</b>\n" .
            "Thành viên: " . htmlspecialchars($tx['bank_account_holder']) . " (ID " . (int)$tx['user_id'] . ")\n" .
            "Số tiền: " . number_format((float)$tx['amount'], 0, ',', '.') . "đ",
            TELEGRAM_CHAT_ID_WITHDRAW
        );
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log("processWithdrawDecision transaction_id={$transactionId}: " . $e->getMessage());
    }
}

// User tự hủy yêu cầu rút tiền của CHÍNH MÌNH khi còn đang pending (mục 7 - Rút tiền). Khác
// processWithdrawDecision (admin duyệt/từ chối bất kỳ yêu cầu nào): hàm này bắt buộc kiểm tra $userId khớp
// chủ yêu cầu, tránh hủy giúp người khác. Hoàn lại kha_dung đã trừ lúc tạo yêu cầu, giống nhánh từ chối.
// Khoá dòng transactions và chỉ xử lý nếu đang pending, chống hủy 2 lần (mục 8.1).
// Trả về ['ok'=>true] hoặc ['ok'=>false,'error'=>...].
function processWithdrawCancel($mysqli, $transactionId, $userId) {
    $mysqli->begin_transaction();
    try {
        $stmt = $mysqli->prepare("SELECT user_id, amount, type, status, bank_account_holder FROM transactions WHERE id = ? FOR UPDATE");
        $stmt->bind_param("i", $transactionId);
        $stmt->execute();
        $tx = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$tx || (int) $tx['user_id'] !== (int) $userId || $tx['type'] !== 'withdraw') {
            $mysqli->rollback();
            return ['ok' => false, 'error' => 'Không tìm thấy yêu cầu rút tiền này.'];
        }

        if ($tx['status'] !== 'pending') {
            $mysqli->rollback();
            return ['ok' => false, 'error' => 'Yêu cầu này đã được xử lý, không thể hủy.'];
        }

        $upd = $mysqli->prepare("UPDATE transactions SET status = 'cancelled', updated_at = NOW() WHERE id = ?");
        $upd->bind_param("i", $transactionId);
        $upd->execute();
        $upd->close();

        creditWallet($mysqli, $userId, 'kha_dung', (float) $tx['amount'], 'refund', $transactionId);

        $mysqli->commit();

        sendTelegramNotify(
            "❌ <b>Yêu cầu rút tiền #{$transactionId} đã bị huỷ bởi thành viên</b>\n" .
            "Thành viên: " . htmlspecialchars($tx['bank_account_holder']) . " (ID {$userId})\n" .
            "Số tiền: " . number_format((float) $tx['amount'], 0, ',', '.') . "đ",
            TELEGRAM_CHAT_ID_WITHDRAW
        );

        return ['ok' => true, 'amount' => (float) $tx['amount']];
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log("processWithdrawCancel transaction_id={$transactionId} user_id={$userId}: " . $e->getMessage());
        return ['ok' => false, 'error' => 'Lỗi hệ thống, vui lòng thử lại.'];
    }
}

// ----- Sơ đồ lấp tầng: xếp vị trí + hoa hồng (mục 6 BUSINESS_RULES.md) -----
// Cây chung duy nhất toàn hệ thống, spillover_tree.parent_id trỏ tới user_id của vị trí cha trong cây,
// KHÔNG phải sponsor_id. Kiểm tra targetParentId có thuộc "tầm với" của sponsor: chính sponsor, hoặc bất kỳ
// hậu duệ nào trong nhánh cây bắt đầu từ sponsor (đi lên bằng parent_id tới khi gặp sponsor hoặc hết cây).
function isWithinSpilloverSubtree($mysqli, $sponsorUserId, $targetParentId) {
    if ((int) $targetParentId === (int) $sponsorUserId) return true;

    $currentId = (int) $targetParentId;
    for ($i = 0; $i < 9; $i++) {
        $stmt = $mysqli->prepare("SELECT parent_id FROM spillover_tree WHERE user_id = ?");
        $stmt->bind_param("i", $currentId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$row) return false;
        if ((int) $row['parent_id'] === (int) $sponsorUserId) return true;
        if (!$row['parent_id']) return false;

        $currentId = (int) $row['parent_id'];
    }
    return false;
}

// Đặt 1 thành viên đang chờ (waiting list) vào 1 vị trí trống trong cây của sponsor.
// $targetParentId: user_id của vị trí cha muốn đặt vào (chính sponsorUserId cho tầng 1, hoặc user_id của
// 1 người đã có trong cây của sponsor cho tầng sâu hơn). $targetPosition: 1/2/3.
// Trả về ['ok'=>true] hoặc ['ok'=>false,'error'=>...].
function placeSpilloverMember($mysqli, $sponsorUserId, $waitingUserId, $targetParentId, $targetPosition) {
    $targetPosition = (int) $targetPosition;
    if (!in_array($targetPosition, [1, 2, 3], true)) {
        return ['ok' => false, 'error' => 'Vị trí không hợp lệ.'];
    }

    $mysqli->begin_transaction();
    try {
        // Chỉ được xếp thành viên đang chờ CHÍNH sponsor này xếp (mục 6 - chỉ người giới thiệu trực tiếp có quyền xếp)
        $stmt = $mysqli->prepare("SELECT id FROM spillover_waiting_list WHERE user_id = ? AND sponsor_id = ? AND placed = 0 FOR UPDATE");
        $stmt->bind_param("ii", $waitingUserId, $sponsorUserId);
        $stmt->execute();
        $waiting = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$waiting) {
            $mysqli->rollback();
            return ['ok' => false, 'error' => 'Thành viên này không có trong danh sách chờ bạn xếp.'];
        }

        if (!isWithinSpilloverSubtree($mysqli, $sponsorUserId, $targetParentId)) {
            $mysqli->rollback();
            return ['ok' => false, 'error' => 'Vị trí này không thuộc cây của bạn.'];
        }

        if ((int) $targetParentId === (int) $sponsorUserId) {
            $parentLevel = 0;
        } else {
            $stmt = $mysqli->prepare("SELECT level FROM spillover_tree WHERE user_id = ? FOR UPDATE");
            $stmt->bind_param("i", $targetParentId);
            $stmt->execute();
            $parentRow = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $parentLevel = (int) ($parentRow['level'] ?? 0);
        }

        $newLevel = $parentLevel + 1;
        if ($newLevel > 9) {
            $mysqli->rollback();
            return ['ok' => false, 'error' => 'Cây đã đạt tối đa 9 tầng, không thể xếp thêm ở vị trí này.'];
        }

        $stmt = $mysqli->prepare("SELECT id FROM spillover_tree WHERE parent_id = ? AND position = ? FOR UPDATE");
        $stmt->bind_param("ii", $targetParentId, $targetPosition);
        $stmt->execute();
        $occupied = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($occupied) {
            $mysqli->rollback();
            return ['ok' => false, 'error' => 'Vị trí này vừa có người xếp, vui lòng chọn ô trống khác.'];
        }

        $stmt = $mysqli->prepare("INSERT INTO spillover_tree (user_id, parent_id, sponsor_id, level, position, placed_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiiii", $waitingUserId, $targetParentId, $sponsorUserId, $newLevel, $targetPosition);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("UPDATE spillover_waiting_list SET placed = 1 WHERE id = ?");
        $stmt->bind_param("i", $waiting['id']);
        $stmt->execute();
        $stmt->close();

        // Quỹ hoa hồng lấp tầng = quỹ chia hoa hồng (mục 3, cập nhật 2026-07-11 - calculateCommissionFund())
        // của đơn hàng kích hoạt gói 5tr của chính người vừa được xếp (mục 6 - dùng chung quỹ chia hoa hồng
        // với hoa hồng trực tiếp, không trừ lẫn nhau)
        $stmt = $mysqli->prepare("SELECT id FROM orders WHERE user_id = ? AND is_activation_package = 1 AND status = 'approved' ORDER BY id ASC LIMIT 1");
        $stmt->bind_param("i", $waitingUserId);
        $stmt->execute();
        $activationOrder = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($activationOrder) {
            $fund = calculateCommissionFund($mysqli, (int) $activationOrder['id']);
            generateSpilloverCommission($mysqli, (int) $activationOrder['id'], $waitingUserId, $fund);
            generateAccumulatedConsumptionBonus($mysqli, (int) $activationOrder['id'], $waitingUserId, $fund);
            generateRecurringConsumptionBonus($mysqli, (int) $activationOrder['id'], $waitingUserId, $fund);
            checkAndAwardRankBonuses($mysqli, (int) $activationOrder['id'], $waitingUserId, $fund);

            // Đánh dấu đã tính hoa hồng điều tầng cho vị trí này (chống generateBackfillSpilloverCommissionIfEligible
            // tính lại lần 2 nếu người này còn mua thêm đơn combo khác sau này - xem hàm đó bên dưới).
            $stmt = $mysqli->prepare("UPDATE spillover_tree SET commission_order_id = ? WHERE user_id = ?");
            $stmt->bind_param("ii", $activationOrder['id'], $waitingUserId);
            $stmt->execute();
            $stmt->close();
        }

        $mysqli->commit();
        return ['ok' => true];
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log("placeSpilloverMember waitingUserId={$waitingUserId} sponsor={$sponsorUserId}: " . $e->getMessage());
        return ['ok' => false, 'error' => 'Lỗi hệ thống, vui lòng thử lại.'];
    }
}

// Tính bù hoa hồng điều tầng + 3 loại thưởng (mục 6 BUSINESS_RULES.md) cho 1 người ĐÃ có sẵn vị trí trong
// spillover_tree nhưng CHƯA từng được tính (trường hợp business_active bị sửa tay = 1 trước khi có đơn
// kích hoạt thật -> lúc xếp cây trong placeSpilloverMember() không tìm thấy đơn nào nên bỏ qua toàn bộ,
// không phải pending mà không sinh ra gì cả). Gọi từ processOrderApproval() ngay sau khi 1 đơn kích hoạt
// thật được duyệt, để tuyến trên trong cây điều tầng không bị mất hoa hồng vĩnh viễn.
// Cột spillover_tree.commission_order_id (database/migration_2026-07-12_spillover_commission_backfill.sql)
// chống tính 2 lần cho cùng 1 vị trí (mục 8.1) - khoá dòng bằng FOR UPDATE trước khi kiểm tra.
function generateBackfillSpilloverCommissionIfEligible($mysqli, $order_id, $buyerId) {
    if (!orderContainsActivationCombo($mysqli, $order_id)) return;

    $stmt = $mysqli->prepare("SELECT id, commission_order_id FROM spillover_tree WHERE user_id = ? FOR UPDATE");
    $stmt->bind_param("i", $buyerId);
    $stmt->execute();
    $node = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Chưa được xếp vào cây điều tầng -> không có gì để tính bù. placeSpilloverMember() sẽ tự tính đúng
    // lúc họ được xếp sau này (khi đó đơn kích hoạt này đã tồn tại, sẽ được tìm thấy bình thường).
    if (!$node) return;

    // Đã tính rồi (lúc xếp cây, hoặc đã tính bù từ 1 đơn trước đó) -> không tính lại (mục 8.1)
    if ($node['commission_order_id'] !== null) return;

    $fund = calculateCommissionFund($mysqli, $order_id);

    generateSpilloverCommission($mysqli, $order_id, $buyerId, $fund);
    generateAccumulatedConsumptionBonus($mysqli, $order_id, $buyerId, $fund);
    generateRecurringConsumptionBonus($mysqli, $order_id, $buyerId, $fund);
    checkAndAwardRankBonuses($mysqli, $order_id, $buyerId, $fund);

    $upd = $mysqli->prepare("UPDATE spillover_tree SET commission_order_id = ? WHERE user_id = ?");
    $upd->bind_param("ii", $order_id, $buyerId);
    $upd->execute();
    $upd->close();
}

// Chia hoa hồng cây lấp tầng 8 tầng (F1..F8), đọc sys_config.spillover_f1..f8 (mặc định F1=16%,
// F2..F8=2%/tầng nếu chưa cấu hình) đi lên theo spillover_tree.parent_id (KHÔNG phải ref_by) bắt đầu
// từ vị trí vừa được xếp (mục 6 BUSINESS_RULES.md: 8 tầng, F1 16%, F2-F8 mỗi tầng 2%, tổng 30%).
function generateSpilloverCommission($mysqli, $order_id, $placedUserId, $fundAmount) {
    $defaultRates = [1 => 0.16, 2 => 0.02, 3 => 0.02, 4 => 0.02, 5 => 0.02, 6 => 0.02, 7 => 0.02, 8 => 0.02];

    $rates = [];
    $res = $mysqli->query("SELECT name, value FROM sys_config WHERE name IN ('spillover_f1','spillover_f2','spillover_f3','spillover_f4','spillover_f5','spillover_f6','spillover_f7','spillover_f8') AND lang = 'vn'");
    while ($row = $res->fetch_assoc()) {
        $rates[$row['name']] = (float) $row['value'];
    }

    $currentUserId = $placedUserId;
    for ($level = 1; $level <= 8; $level++) {
        $stmt = $mysqli->prepare("SELECT parent_id FROM spillover_tree WHERE user_id = ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $node = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$node || !$node['parent_id']) break;

        $parentId = (int) $node['parent_id'];
        $rate = isset($rates['spillover_f' . $level]) ? $rates['spillover_f' . $level] : $defaultRates[$level];
        $commissionAmount = round($fundAmount * $rate, 2);

        if ($commissionAmount > 0) {
            creditSpilloverCommission($mysqli, $order_id, $parentId, $level, $commissionAmount);
        }

        $currentUserId = $parentId;
    }
}

// Sinh 1 dòng hoa hồng cây lấp tầng cho 1 người ở 1 tầng. Khác với hoa hồng trực tiếp: nếu người nhận
// commission_active = 0 thì lưu pending, không cộng ví; = 1 thì released, cộng ví ngay (mục 5, cập nhật
// 2026-07-11: đổi điều kiện từ business_active sang commission_active).
function creditSpilloverCommission($mysqli, $order_id, $userId, $level, $amount) {
    $stmt = $mysqli->prepare("SELECT commission_active FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $isActive = (int) ($stmt->get_result()->fetch_assoc()['commission_active'] ?? 0) === 1;
    $stmt->close();

    $status = $isActive ? 'released' : 'pending';
    $releasedAt = $isActive ? date('Y-m-d H:i:s') : null;

    $stmt = $mysqli->prepare("INSERT INTO commissions (order_id, user_id, level, type, amount, status, released_at) VALUES (?, ?, ?, 'spillover', ?, ?, ?)");
    $stmt->bind_param("iiidss", $order_id, $userId, $level, $amount, $status, $releasedAt);
    $stmt->execute();
    $commissionId = $mysqli->insert_id;
    $stmt->close();

    if ($isActive) {
        creditWalletFromCommission($mysqli, $userId, $amount, $commissionId);
    }
}

// ----- Tích lũy tiêu dùng (mục 6 BUSINESS_RULES.md, cập nhật 2026-07-13 - đổi tên từ "thưởng điểm thẻ tiêu
// dùng", đổi cách chia và nơi lưu, giữ nguyên tỉ lệ 10% + thời điểm phát sinh) -----
// Trích 10% quỹ chia hoa hồng của đơn kích hoạt, chia ĐỀU cho TOÀN BỘ thành viên business_active = 1 trong
// hệ thống, TRỪ chính người vừa được xếp vào cây (nguồn phát sinh quỹ này). Khác cơ chế cũ (đi lên 8 tầng
// spillover_tree, cộng vào consumption_cards.balance) - nay không phụ thuộc vị trí trong cây, cộng vào ví
// riêng user_wallets.tich_luy_tieu_dung. Không có ai đủ điều kiện (chỉ 1 mình người vừa kích hoạt là
// business_active) thì bỏ qua, không dồn cho lần phát sinh khác.
function generateAccumulatedConsumptionBonus($mysqli, $order_id, $placedUserId, $fundAmount) {
    $totalAmount = $fundAmount * 0.10;
    if ($totalAmount <= 0) return;

    $stmt = $mysqli->prepare("SELECT id FROM user WHERE business_active = 1 AND id != ?");
    $stmt->bind_param("i", $placedUserId);
    $stmt->execute();
    $recipientIds = array_map(function ($row) { return (int) $row['id']; }, $stmt->get_result()->fetch_all(MYSQLI_ASSOC));
    $stmt->close();

    if (empty($recipientIds)) return;

    $perMemberAmount = round($totalAmount / count($recipientIds), 2);
    if ($perMemberAmount <= 0) return;

    foreach ($recipientIds as $recipientId) {
        creditAccumulatedConsumptionBonus($mysqli, $order_id, $recipientId, $perMemberAmount);
    }
}

// Sinh 1 dòng Tích lũy tiêu dùng cho 1 người nhận. Nếu người nhận commission_active = 0 thì lưu pending,
// chưa cộng ví; = 1 thì released, cộng thẳng vào user_wallets.tich_luy_tieu_dung ngay (mục 5).
function creditAccumulatedConsumptionBonus($mysqli, $order_id, $userId, $amount) {
    $stmt = $mysqli->prepare("SELECT commission_active FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $isActive = (int) ($stmt->get_result()->fetch_assoc()['commission_active'] ?? 0) === 1;
    $stmt->close();

    $status = $isActive ? 'released' : 'pending';
    $releasedAt = $isActive ? date('Y-m-d H:i:s') : null;

    $stmt = $mysqli->prepare("INSERT INTO accumulated_consumption_bonuses (order_id, user_id, amount, status, released_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iidss", $order_id, $userId, $amount, $status, $releasedAt);
    $stmt->execute();
    $bonusId = $mysqli->insert_id;
    $stmt->close();

    if ($isActive) {
        creditWallet($mysqli, $userId, 'tich_luy_tieu_dung', $amount, 'accumulated_consumption', $bonusId);
    }
}

// ----- Thưởng tiêu dùng tuần hoàn (mục 6 BUSINESS_RULES.md) -----
// Trích 16% quỹ chia hoa hồng của đơn kích hoạt. 70% chia đều 8 tầng đi lên theo spillover_tree.parent_id
// (giống hoa hồng lấp tầng/thưởng điểm thẻ) - chỉ ancestor ĐÃ đạt ít nhất 1 danh hiệu (có dòng trong
// user_ranks) mới nhận, tầng nào ancestor chưa có danh hiệu thì bỏ qua (giống "tầng không có thành viên
// thì không chia"). 30% còn lại chuyển vào Quỹ tiêu dùng tuần hoàn công ty (cập nhật 2026-07-15, xem
// creditCompanyCardFund()) - trước đó chung với quỹ vận hành mục 3.
function generateRecurringConsumptionBonus($mysqli, $order_id, $placedUserId, $fundAmount) {
    $recurringAmount = $fundAmount * 0.16;

    creditCompanyCardFund($mysqli, $order_id, $recurringAmount * 0.30);

    $perLevelAmount = round($recurringAmount * 0.70 / 8, 2);
    if ($perLevelAmount <= 0) return;

    $currentUserId = $placedUserId;
    for ($level = 1; $level <= 8; $level++) {
        $stmt = $mysqli->prepare("SELECT parent_id FROM spillover_tree WHERE user_id = ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $node = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$node || !$node['parent_id']) break;

        $parentId = (int) $node['parent_id'];
        creditRecurringConsumptionBonus($mysqli, $order_id, $parentId, $level, $perLevelAmount);

        $currentUserId = $parentId;
    }
}

// Sinh 1 dòng thưởng tiêu dùng tuần hoàn cho 1 người ở 1 tầng. Bỏ qua hoàn toàn (không tạo dòng) nếu
// người nhận chưa đạt danh hiệu nào (mục 6). Nếu đã đạt danh hiệu: commission_active = 0 thì lưu pending,
// chưa cộng ví; = 1 thì released, cộng thẳng vào ví tiêu dùng ngay (mục 5, cập nhật 2026-07-11: đổi điều
// kiện từ business_active sang commission_active).
function creditRecurringConsumptionBonus($mysqli, $order_id, $userId, $level, $amount) {
    $stmt = $mysqli->prepare("SELECT id FROM user_ranks WHERE user_id = ? LIMIT 1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $hasRank = (bool) $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$hasRank) return;

    $stmt = $mysqli->prepare("SELECT commission_active FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $isActive = (int) ($stmt->get_result()->fetch_assoc()['commission_active'] ?? 0) === 1;
    $stmt->close();

    $status = $isActive ? 'released' : 'pending';
    $releasedAt = $isActive ? date('Y-m-d H:i:s') : null;

    $stmt = $mysqli->prepare("INSERT INTO recurring_consumption_bonuses (order_id, user_id, level, amount, status, released_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiidss", $order_id, $userId, $level, $amount, $status, $releasedAt);
    $stmt->execute();
    $bonusId = $mysqli->insert_id;
    $stmt->close();

    if ($isActive) {
        creditWallet($mysqli, $userId, 'tieu_dung', $amount, 'card_bonus', $bonusId);
    }
}

// ----- Thưởng danh hiệu (mục 6 BUSINESS_RULES.md) -----
// Sau khi 1 thành viên được xếp vào cây, kiểm tra từng ancestor đi lên (spillover_tree.parent_id): nếu
// khoảng cách tới ancestor đó đúng bằng required_level của 1 danh hiệu, và ancestor VỪA lấp đầy đúng tầng
// đó (đủ 3^tầng thành viên) và đủ số F1 trực tiếp (user.ref_by) thì trao danh hiệu (chỉ 1 lần/người/hạng).
function checkAndAwardRankBonuses($mysqli, $order_id, $placedUserId, $fundAmount) {
    $ranksByLevel = [];
    $res = $mysqli->query("SELECT code, name, required_level, required_members, required_f1, bonus_percent FROM ranks");
    while ($row = $res->fetch_assoc()) {
        $ranksByLevel[(int) $row['required_level']] = $row;
    }
    if (empty($ranksByLevel)) return;

    $currentUserId = $placedUserId;
    for ($depth = 1; $depth <= 9; $depth++) {
        $stmt = $mysqli->prepare("SELECT parent_id FROM spillover_tree WHERE user_id = ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $node = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$node || !$node['parent_id']) break;

        $ancestorId = (int) $node['parent_id'];

        if (isset($ranksByLevel[$depth])) {
            awardRankIfEligible($mysqli, $order_id, $ancestorId, $ranksByLevel[$depth], $fundAmount);
        }

        $currentUserId = $ancestorId;
    }
}

// Kiểm tra 1 ancestor có đủ điều kiện 1 danh hiệu cụ thể chưa, nếu đủ và chưa từng đạt thì trao thưởng.
function awardRankIfEligible($mysqli, $order_id, $ancestorId, $rank, $fundAmount) {
    $stmt = $mysqli->prepare("SELECT id FROM user_ranks WHERE user_id = ? AND rank_code = ?");
    $stmt->bind_param("is", $ancestorId, $rank['code']);
    $stmt->execute();
    $already = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($already) return;

    $memberCount = countExactGeneration($mysqli, $ancestorId, (int) $rank['required_level']);
    if ($memberCount < (int) $rank['required_members']) return;

    $stmt = $mysqli->prepare("SELECT COUNT(*) c FROM user WHERE ref_by = ?");
    $stmt->bind_param("i", $ancestorId);
    $stmt->execute();
    $f1Count = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
    $stmt->close();
    if ($f1Count < (int) $rank['required_f1']) return;

    // INSERT IGNORE + UNIQUE(user_id, rank_code) chống trao trùng 1 danh hiệu 2 lần (mục 8.1)
    $insertedRank = $mysqli->prepare("INSERT IGNORE INTO user_ranks (user_id, rank_code) VALUES (?, ?)");
    $insertedRank->bind_param("is", $ancestorId, $rank['code']);
    $insertedRank->execute();
    $isNew = $insertedRank->affected_rows > 0;
    $insertedRank->close();
    if (!$isNew) return;

    $bonusAmount = round($fundAmount * (float) $rank['bonus_percent'], 2);
    creditRankBonus($mysqli, $order_id, $ancestorId, $bonusAmount);
}

// Đếm chính xác số thành viên ở ĐÚNG tầng thứ $depth tính từ $ancestorId (BFS theo spillover_tree.parent_id)
function countExactGeneration($mysqli, $ancestorId, $depth) {
    $currentLevelIds = [$ancestorId];
    for ($i = 0; $i < $depth; $i++) {
        if (empty($currentLevelIds)) return 0;
        $in = implode(",", array_map('intval', $currentLevelIds));
        $res = $mysqli->query("SELECT user_id FROM spillover_tree WHERE parent_id IN ($in)");
        $next = [];
        while ($row = $res->fetch_assoc()) $next[] = $row['user_id'];
        $currentLevelIds = $next;
    }
    return count($currentLevelIds);
}

// Sinh 1 dòng thưởng danh hiệu, dùng chung bảng commissions (type='rank_bonus') để tận dụng sẵn luật
// pending/release theo commission_active qua releasePendingCommissions() hiện có (mục 5, cập nhật
// 2026-07-11: đổi điều kiện từ business_active sang commission_active). Cộng ví tổng rồi tự động chia
// 60/20/10/10 vào 4 ví thực, đúng "Quy tắc chia ví tổng" áp dụng cho thưởng danh hiệu (mục 2).
function creditRankBonus($mysqli, $order_id, $userId, $amount) {
    if ($amount <= 0) return;

    $stmt = $mysqli->prepare("SELECT commission_active FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $isActive = (int) ($stmt->get_result()->fetch_assoc()['commission_active'] ?? 0) === 1;
    $stmt->close();

    $status = $isActive ? 'released' : 'pending';
    $releasedAt = $isActive ? date('Y-m-d H:i:s') : null;

    $stmt = $mysqli->prepare("INSERT INTO commissions (order_id, user_id, type, amount, status, released_at) VALUES (?, ?, 'rank_bonus', ?, ?, ?)");
    $stmt->bind_param("iidss", $order_id, $userId, $amount, $status, $releasedAt);
    $stmt->execute();
    $commissionId = $mysqli->insert_id;
    $stmt->close();

    if ($isActive) {
        creditWalletFromCommission($mysqli, $userId, $amount, $commissionId);
    }
}

// Ví tái tiêu dùng: tối đa 258,000,000, vượt quá không cộng tiếp (mục 2 - Ví)
function creditTaiTieuDungCapped($mysqli, $userId, $amount, $refType, $refId) {
    if ($amount <= 0) return;
    $cap = 258000000;

    ensureWalletRow($mysqli, $userId);

    $stmt = $mysqli->prepare("SELECT tai_tieu_dung FROM user_wallets WHERE user_id = ? FOR UPDATE");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $current = (float)$stmt->get_result()->fetch_assoc()['tai_tieu_dung'];
    $stmt->close();

    $allowed = min($amount, $cap - $current);
    if ($allowed <= 0) return;

    $stmt = $mysqli->prepare("UPDATE user_wallets SET tai_tieu_dung = tai_tieu_dung + ? WHERE user_id = ?");
    $stmt->bind_param("di", $allowed, $userId);
    $stmt->execute();
    $stmt->close();

    $balanceAfter = $current + $allowed;

    $stmt = $mysqli->prepare("INSERT INTO wallet_transactions (user_id, wallet_type, direction, amount, balance_after, ref_type, ref_id) VALUES (?, 'tai_tieu_dung', 'credit', ?, ?, ?, ?)");
    $stmt->bind_param("iddsi", $userId, $allowed, $balanceAfter, $refType, $refId);
    $stmt->execute();
    $stmt->close();

    processRebuyIfEligible($mysqli, $userId);
}

// ----- Giao dịch tái tiêu dùng tự động (Rebuy) (mục 2, mục 6 - "Giao dịch tái tiêu dùng tự động" trong
// BUSINESS_RULES.md) -----
// Khi ví tái tiêu dùng của 1 thành viên đạt/vượt 5,000,000đ: tự động trừ đúng 5,000,000đ (giữ phần dư nếu
// có, không reset về 0), 5,000,000đ đó chính là quỹ hoa hồng của giao dịch Rebuy, chia 3 khoản rồi lặp lại
// nếu phần dư vẫn còn đủ 5,000,000đ. Được gọi từ creditTaiTieuDungCapped() ngay sau khi cộng ví, nên luôn
// chạy trong transaction đang mở của caller (processOrderApproval / placeSpilloverMember / 1 Rebuy khác -
// mục 8.2), rollback cùng nhau nếu có lỗi.
function processRebuyIfEligible($mysqli, $userId) {
    $rebuyAmount = 5000000;

    // Giới hạn số vòng lặp để phòng lỗi phát sinh gây lặp bất thường (trần ví 258tr / 5tr ~ tối đa 52 vòng
    // trong thực tế, 100 chỉ là ngưỡng an toàn kỹ thuật, không phải quy tắc nghiệp vụ).
    for ($i = 0; $i < 100; $i++) {
        $stmt = $mysqli->prepare("SELECT tai_tieu_dung FROM user_wallets WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $balance = (float) ($stmt->get_result()->fetch_assoc()['tai_tieu_dung'] ?? 0);
        $stmt->close();

        if ($balance < $rebuyAmount) break;
        if (!executeRebuy($mysqli, $userId, $rebuyAmount)) break;
    }
}

// Thực hiện 1 giao dịch Rebuy: trừ 5tr khỏi ví tái tiêu dùng, chia 3 khoản (trực tiếp/điều tầng/danh hiệu),
// phần còn lại vào quỹ vận hành. Trả về false nếu trừ ví thất bại (không đủ số dư - phòng race condition dù
// đã kiểm tra trước ở processRebuyIfEligible).
function executeRebuy($mysqli, $userId, $rebuyAmount) {
    $stmt = $mysqli->prepare("INSERT INTO rebuy_transactions (user_id, amount) VALUES (?, ?)");
    $stmt->bind_param("id", $userId, $rebuyAmount);
    $stmt->execute();
    $rebuyId = $mysqli->insert_id;
    $stmt->close();

    if (!debitWallet($mysqli, $userId, 'tai_tieu_dung', $rebuyAmount, 'rebuy', $rebuyId)) {
        return false;
    }

    $stmt = $mysqli->prepare("UPDATE user_wallets SET rebuy_count = rebuy_count + 1 WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();

    $distributed = 0;
    $distributed += generateRebuyDirectCommission($mysqli, $rebuyId, $userId, $rebuyAmount);
    $distributed += generateRebuySpilloverCommission($mysqli, $rebuyId, $userId, $rebuyAmount);
    $distributed += generateRebuyRankBonus($mysqli, $rebuyId, $userId, $rebuyAmount);

    $remaining = round($rebuyAmount - $distributed, 2);
    if ($remaining > 0) {
        creditOperatingFund($mysqli, null, 'rebuy', $remaining, $rebuyId);
    }

    return true;
}

// Hoa hồng trực tiếp của giao dịch Rebuy: theo user.ref_by, dùng chung tỉ lệ sys_config.f1..f8 với hoa hồng
// sơ đồ trực tiếp (mục 4: F1 16%, F2-F8 mỗi tầng 2%, tổng 30%). Luôn released, cộng ví ngay, không phân biệt
// business_active (giống mục 4, khác hoa hồng điều tầng bên dưới). Trả về tổng đã chia.
function generateRebuyDirectCommission($mysqli, $rebuyId, $userId, $fundAmount) {
    $rates = [];
    $res = $mysqli->query("SELECT name, value FROM sys_config WHERE name IN ('f1','f2','f3','f4','f5','f6','f7','f8') AND lang = 'vn'");
    while ($row = $res->fetch_assoc()) {
        $rates[$row['name']] = (float) $row['value'];
    }

    $distributed = 0;
    $currentUserId = $userId;
    for ($level = 1; $level <= 8; $level++) {
        $stmt = $mysqli->prepare("SELECT ref_by FROM user WHERE id = ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $current = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$current || !$current['ref_by']) break;

        $uplineId = (int) $current['ref_by'];
        $rate = isset($rates['f' . $level]) ? $rates['f' . $level] : 0;
        $amount = round($fundAmount * $rate, 2);

        if ($amount > 0) {
            creditRebuyDirectCommission($mysqli, $rebuyId, $uplineId, $level, $amount);
            $distributed += $amount;
        }

        $currentUserId = $uplineId;
    }
    return $distributed;
}

function creditRebuyDirectCommission($mysqli, $rebuyId, $userId, $level, $amount) {
    $status = 'released';
    $releasedAt = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("INSERT INTO commissions (rebuy_id, user_id, level, type, amount, status, released_at) VALUES (?, ?, ?, 'direct', ?, ?, ?)");
    $stmt->bind_param("iiidss", $rebuyId, $userId, $level, $amount, $status, $releasedAt);
    $stmt->execute();
    $commissionId = $mysqli->insert_id;
    $stmt->close();

    creditWalletFromCommission($mysqli, $userId, $amount, $commissionId);
}

// Hoa hồng điều tầng của giao dịch Rebuy: theo spillover_tree.parent_id, dùng chung tỉ lệ
// sys_config.spillover_f1..f8 với hoa hồng cây lấp tầng (mục 6: đồng đều 3%/tầng, tổng 24%, cập nhật
// 2026-07-11). Áp dụng pending/release theo commission_active (mục 5, cập nhật 2026-07-11), giống
// creditSpilloverCommission. Trả về tổng đã chia (tính cả phần đang pending vì đã trừ khỏi quỹ Rebuy).
function generateRebuySpilloverCommission($mysqli, $rebuyId, $userId, $fundAmount) {
    $defaultRate = 0.03;
    $rates = [];
    $res = $mysqli->query("SELECT name, value FROM sys_config WHERE name IN ('spillover_f1','spillover_f2','spillover_f3','spillover_f4','spillover_f5','spillover_f6','spillover_f7','spillover_f8') AND lang = 'vn'");
    while ($row = $res->fetch_assoc()) {
        $rates[$row['name']] = (float) $row['value'];
    }

    $distributed = 0;
    $currentUserId = $userId;
    for ($level = 1; $level <= 8; $level++) {
        $stmt = $mysqli->prepare("SELECT parent_id FROM spillover_tree WHERE user_id = ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $node = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$node || !$node['parent_id']) break;

        $parentId = (int) $node['parent_id'];
        $rate = isset($rates['spillover_f' . $level]) ? $rates['spillover_f' . $level] : $defaultRate;
        $amount = round($fundAmount * $rate, 2);

        if ($amount > 0) {
            creditRebuySpilloverCommission($mysqli, $rebuyId, $parentId, $level, $amount);
            $distributed += $amount;
        }

        $currentUserId = $parentId;
    }
    return $distributed;
}

// Sinh 1 dòng hoa hồng điều tầng của Rebuy cho 1 người ở 1 tầng. Nếu người nhận commission_active = 0 thì
// lưu pending, chưa cộng ví; = 1 thì released, cộng ví ngay (mục 5, cập nhật 2026-07-11: đổi điều kiện từ
// business_active sang commission_active).
function creditRebuySpilloverCommission($mysqli, $rebuyId, $userId, $level, $amount) {
    $stmt = $mysqli->prepare("SELECT commission_active FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $isActive = (int) ($stmt->get_result()->fetch_assoc()['commission_active'] ?? 0) === 1;
    $stmt->close();

    $status = $isActive ? 'released' : 'pending';
    $releasedAt = $isActive ? date('Y-m-d H:i:s') : null;

    $stmt = $mysqli->prepare("INSERT INTO commissions (rebuy_id, user_id, level, type, amount, status, released_at) VALUES (?, ?, ?, 'spillover', ?, ?, ?)");
    $stmt->bind_param("iiidss", $rebuyId, $userId, $level, $amount, $status, $releasedAt);
    $stmt->execute();
    $commissionId = $mysqli->insert_id;
    $stmt->close();

    if ($isActive) {
        creditWalletFromCommission($mysqli, $userId, $amount, $commissionId);
    }
}

// Thưởng danh hiệu của giao dịch Rebuy: trả cho ancestor ĐÃ đạt danh hiệu tương ứng ở đúng tầng
// required_level (khác checkAndAwardRankBonuses ở trên - hàm đó chỉ trao 1 lần lúc MỚI đạt danh hiệu). Mỗi
// lần Rebuy của bất kỳ hậu duệ nào cũng trả thưởng cho ancestor đang giữ danh hiệu đó (mục 6 - Giao dịch
// tái tiêu dùng tự động). Áp dụng pending/release theo commission_active (mục 5, cập nhật 2026-07-11).
// Danh hiệu nào chưa ai đạt ở đúng tầng thì bỏ qua, không dồn cho tầng khác. Trả về tổng đã chia.
function generateRebuyRankBonus($mysqli, $rebuyId, $userId, $fundAmount) {
    $ranksByLevel = [];
    $res = $mysqli->query("SELECT code, required_level, bonus_percent FROM ranks");
    while ($row = $res->fetch_assoc()) {
        $ranksByLevel[(int) $row['required_level']] = $row;
    }
    if (empty($ranksByLevel)) return 0;

    $distributed = 0;
    $currentUserId = $userId;
    for ($depth = 1; $depth <= 9; $depth++) {
        $stmt = $mysqli->prepare("SELECT parent_id FROM spillover_tree WHERE user_id = ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $node = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$node || !$node['parent_id']) break;

        $ancestorId = (int) $node['parent_id'];

        if (isset($ranksByLevel[$depth])) {
            $rank = $ranksByLevel[$depth];

            $stmt = $mysqli->prepare("SELECT id FROM user_ranks WHERE user_id = ? AND rank_code = ?");
            $stmt->bind_param("is", $ancestorId, $rank['code']);
            $stmt->execute();
            $hasRank = (bool) $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($hasRank) {
                $amount = round($fundAmount * (float) $rank['bonus_percent'], 2);
                if ($amount > 0) {
                    creditRebuyRankBonus($mysqli, $rebuyId, $ancestorId, $amount);
                    $distributed += $amount;
                }
            }
        }

        $currentUserId = $ancestorId;
    }
    return $distributed;
}

// Sinh 1 dòng thưởng danh hiệu của Rebuy, dùng chung bảng commissions (type='rank_bonus') để tận dụng sẵn
// luật pending/release theo commission_active qua releasePendingCommissions() hiện có (mục 5, cập nhật
// 2026-07-11: đổi điều kiện từ business_active sang commission_active).
function creditRebuyRankBonus($mysqli, $rebuyId, $userId, $amount) {
    if ($amount <= 0) return;

    $stmt = $mysqli->prepare("SELECT commission_active FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $isActive = (int) ($stmt->get_result()->fetch_assoc()['commission_active'] ?? 0) === 1;
    $stmt->close();

    $status = $isActive ? 'released' : 'pending';
    $releasedAt = $isActive ? date('Y-m-d H:i:s') : null;

    $stmt = $mysqli->prepare("INSERT INTO commissions (rebuy_id, user_id, type, amount, status, released_at) VALUES (?, ?, 'rank_bonus', ?, ?, ?)");
    $stmt->bind_param("iidss", $rebuyId, $userId, $amount, $status, $releasedAt);
    $stmt->execute();
    $commissionId = $mysqli->insert_id;
    $stmt->close();

    if ($isActive) {
        creditWalletFromCommission($mysqli, $userId, $amount, $commissionId);
    }
}

// Gửi email báo khách hàng khi đơn được admin duyệt (tái sử dụng sendMailer() có sẵn của dự án)
function sendOrderApprovedEmail($order_id, $order) {
    if (empty($order['email'])) return;

    $projectRoot = dirname(__FILE__) . '/../..';
    require_once $projectRoot . '/phpmailer/class.smtp.php';
    require_once $projectRoot . '/phpmailer/class.phpmailer.php';
    require_once $projectRoot . '/phpmailer/config.php';

    $subject = "Đơn hàng #{$order_id} đã được xác nhận";

    $HTML = "<br><b>Thông tin vận chuyển:</b>";
    $HTML .= "<br>Họ tên: " . htmlspecialchars($order['name']);
    $HTML .= "<br>Điện thoại: " . htmlspecialchars($order['mobile']);
    $HTML .= "<br>Địa chỉ: " . htmlspecialchars($order['address']);
    $HTML .= "<br>Lưu ý: " . htmlspecialchars($order['note']);
    $HTML .= "<br><br><b>Thông tin đơn hàng #{$order_id} (đã được duyệt):</b>";
    $HTML .= "<br>" . nl2br(htmlspecialchars($order['products']));
    $HTML .= "<br>Tổng Tiền: " . number_format($order['amount'], 0, ',', '.') . "đ";

    try {
        sendMailer($subject, $HTML, $order['name'], $order['email'], '', $order['email'], $order['name']);
    } catch (Throwable $e) {
        error_log("sendOrderApprovedEmail order_id={$order_id}: " . $e->getMessage());
    }
}
