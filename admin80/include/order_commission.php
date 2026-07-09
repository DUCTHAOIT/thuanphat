<?php
// Xử lý khi đơn hàng được Admin duyệt: sinh hoa hồng sơ đồ trực tiếp (9 tầng)
// và kích hoạt business_active. Ref: docs/BUSINESS_RULES.md mục 2, 3, "pending commission", mục 4.
// Toàn bộ chạy trong 1 transaction, rollback nếu lỗi (mục 9 - Transaction).

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

        activateBusinessIfEligible($mysqli, $buyerId, $order_id, $amount);
        generateDirectCommission($mysqli, $order_id, $buyerId, $amount);

        $stmt = $mysqli->prepare("UPDATE orders SET commission_generated = 1 WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        $mysqli->commit();

        sendOrderApprovedEmail($order_id, $order);
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log("processOrderApproval order_id={$order_id}: " . $e->getMessage());
    }
}

// Đơn đơn lẻ >= 5,000,000 -> kích hoạt business_active cho người mua (chỉ set 1 lần)
function activateBusinessIfEligible($mysqli, $userId, $order_id, $amount) {
    if ($amount < 5000000) return;

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
    releasePendingCommissions($mysqli, $userId);
}

// Khi kích hoạt gói 5tr lần đầu: cộng điểm thẻ tiêu dùng (mục 4 - Ví)
function creditConsumptionCard($mysqli, $userId, $amount) {
    $stmt = $mysqli->prepare("INSERT INTO consumption_cards (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + VALUES(balance)");
    $stmt->bind_param("id", $userId, $amount);
    $stmt->execute();
    $stmt->close();
}

// Khi business_active chuyển sang 1: release toàn bộ hoa hồng đang pending của người đó
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

// Chia hoa hồng sơ đồ trực tiếp 9 tầng (f1..f9 theo sys_config) trên 60% giá trị đơn hàng (quỹ chia hoa hồng)
function generateDirectCommission($mysqli, $order_id, $buyerId, $amount) {
    $commissionFund = $amount * 0.6;

    $rates = [];
    $res = $mysqli->query("SELECT name, value FROM sys_config WHERE name IN ('f1','f2','f3','f4','f5','f6','f7','f8','f9') AND lang = 'vn'");
    while ($row = $res->fetch_assoc()) {
        $rates[$row['name']] = (float)$row['value'];
    }

    $currentUserId = $buyerId;
    for ($level = 1; $level <= 9; $level++) {
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

// Cộng vào ví tổng (theo dõi) rồi tự động chia 60/20/10/10 vào 4 ví thực (mục 4)
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

// Cộng vào 1 trong các ví: tong | kha_dung | tieu_dung | thue_phi (tai_tieu_dung xử lý riêng do có trần 258tr)
function creditWallet($mysqli, $userId, $walletType, $amount, $refType, $refId) {
    if ($amount <= 0) return;

    $allowedColumns = ['tong', 'kha_dung', 'tieu_dung', 'thue_phi'];
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
// Dùng cho nghiệp vụ Rút tiền (mục 5): trừ kha_dung ngay khi user tạo yêu cầu rút.
function debitWallet($mysqli, $userId, $walletType, $amount, $refType, $refId) {
    if ($amount <= 0) return false;

    $allowedColumns = ['tong', 'kha_dung', 'tieu_dung', 'thue_phi'];
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

// Duyệt/từ chối yêu cầu rút tiền (mục 5 - Rút tiền).
// kha_dung đã bị trừ ngay lúc tạo yêu cầu (modules/user/xu_ly_rut_tien.php), nên:
// - approve: chỉ xác nhận đã chuyển khoản, không đụng ví.
// - reject: hoàn lại kha_dung đã trừ.
// Khoá dòng transactions và chỉ xử lý nếu đang pending, chống duyệt/từ chối 2 lần (mục 8).
function processWithdrawDecision($mysqli, $transactionId, $approve) {
    $mysqli->begin_transaction();
    try {
        $stmt = $mysqli->prepare("SELECT user_id, amount, type, status FROM transactions WHERE id = ? FOR UPDATE");
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
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log("processWithdrawDecision transaction_id={$transactionId}: " . $e->getMessage());
    }
}

// Ví tái tiêu dùng: tối đa 258,000,000, vượt quá không cộng tiếp (mục "quy tắc Ví tái tiêu dùng")
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
