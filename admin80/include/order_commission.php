<?php
// Xử lý khi đơn hàng được Admin duyệt: sinh hoa hồng sơ đồ trực tiếp (9 tầng)
// và kích hoạt business_active. Ref: docs/BUSINESS_RULES.md mục 3 (Mua hàng), mục 4 (Hoa hồng trực tiếp),
// mục 5 (pending/release theo business_active), mục 2 (Ví).
// Toàn bộ chạy trong 1 transaction, rollback nếu lỗi (mục 8.2 - Transaction).

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

// Đơn có chứa sản phẩm combo kích hoạt -> kích hoạt business_active cho người mua (chỉ set 1 lần)
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
    releasePendingCommissions($mysqli, $userId);
    addToSpilloverWaitingList($mysqli, $userId);
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

// Khi business_active chuyển sang 1: thêm vào danh sách chờ xếp tầng, người giới thiệu trực tiếp (ref_by)
// có quyền xếp vào cây lấp tầng chung (mục 6 - Sơ đồ lấp tầng). Chỉ chạy 1 lần vì activateBusinessIfEligible
// đã chặn chạy lại (business_active chỉ set 1 lần).
function addToSpilloverWaitingList($mysqli, $userId) {
    $stmt = $mysqli->prepare("SELECT ref_by FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $refBy = $stmt->get_result()->fetch_assoc()['ref_by'] ?? null;
    $stmt->close();

    if (!$refBy) return;

    $stmt = $mysqli->prepare("INSERT INTO spillover_waiting_list (user_id, sponsor_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $refBy);
    $stmt->execute();
    $stmt->close();
}

// Khi kích hoạt gói 5tr lần đầu: cộng điểm thẻ tiêu dùng (mục 2 - Ví)
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
// Dùng cho nghiệp vụ Rút tiền (mục 7): trừ kha_dung ngay khi user tạo yêu cầu rút.
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

// Duyệt/từ chối yêu cầu rút tiền (mục 7 - Rút tiền).
// kha_dung đã bị trừ ngay lúc tạo yêu cầu (modules/user/xu_ly_rut_tien.php), nên:
// - approve: chỉ xác nhận đã chuyển khoản, không đụng ví.
// - reject: hoàn lại kha_dung đã trừ.
// Khoá dòng transactions và chỉ xử lý nếu đang pending, chống duyệt/từ chối 2 lần (mục 8.1).
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

        // Quỹ hoa hồng lấp tầng = 60% đơn hàng kích hoạt gói 5tr của chính người vừa được xếp
        // (mục 6 - dùng chung quỹ chia hoa hồng với hoa hồng trực tiếp, không trừ lẫn nhau)
        $stmt = $mysqli->prepare("SELECT id, amount FROM orders WHERE user_id = ? AND is_activation_package = 1 AND status = 'approved' ORDER BY id ASC LIMIT 1");
        $stmt->bind_param("i", $waitingUserId);
        $stmt->execute();
        $activationOrder = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($activationOrder) {
            $fund = (float) $activationOrder['amount'] * 0.6;
            generateSpilloverCommission($mysqli, (int) $activationOrder['id'], $waitingUserId, $fund);
        }

        $mysqli->commit();
        return ['ok' => true];
    } catch (Throwable $e) {
        $mysqli->rollback();
        error_log("placeSpilloverMember waitingUserId={$waitingUserId} sponsor={$sponsorUserId}: " . $e->getMessage());
        return ['ok' => false, 'error' => 'Lỗi hệ thống, vui lòng thử lại.'];
    }
}

// Chia hoa hồng cây lấp tầng 9 tầng (mặc định 3%/tầng, đọc sys_config.spillover_f1..f9 nếu có) đi lên theo
// spillover_tree.parent_id (KHÔNG phải ref_by) bắt đầu từ vị trí vừa được xếp.
function generateSpilloverCommission($mysqli, $order_id, $placedUserId, $fundAmount) {
    $rates = [];
    $res = $mysqli->query("SELECT name, value FROM sys_config WHERE name IN ('spillover_f1','spillover_f2','spillover_f3','spillover_f4','spillover_f5','spillover_f6','spillover_f7','spillover_f8','spillover_f9') AND lang = 'vn'");
    while ($row = $res->fetch_assoc()) {
        $rates[$row['name']] = (float) $row['value'];
    }

    $currentUserId = $placedUserId;
    for ($level = 1; $level <= 9; $level++) {
        $stmt = $mysqli->prepare("SELECT parent_id FROM spillover_tree WHERE user_id = ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $node = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$node || !$node['parent_id']) break;

        $parentId = (int) $node['parent_id'];
        $rate = isset($rates['spillover_f' . $level]) ? $rates['spillover_f' . $level] : 0.03;
        $commissionAmount = round($fundAmount * $rate, 2);

        if ($commissionAmount > 0) {
            creditSpilloverCommission($mysqli, $order_id, $parentId, $level, $commissionAmount);
        }

        $currentUserId = $parentId;
    }
}

// Sinh 1 dòng hoa hồng cây lấp tầng cho 1 người ở 1 tầng. Khác với hoa hồng trực tiếp: nếu người nhận
// business_active = 0 thì lưu pending, không cộng ví; = 1 thì released, cộng ví ngay (mục 5).
function creditSpilloverCommission($mysqli, $order_id, $userId, $level, $amount) {
    $stmt = $mysqli->prepare("SELECT business_active FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $isActive = (int) ($stmt->get_result()->fetch_assoc()['business_active'] ?? 0) === 1;
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
