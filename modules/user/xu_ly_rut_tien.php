<?php
session_start(); // Bắt buộc nếu bạn dùng $_SESSION
$username=getSession("username");
if (!isset($username) || empty($username)) {
    header("Location: /"); // Chuyển hướng về trang chủ
    exit();
}
$user_id = getMemberNameID($username, "id");

// Lấy dữ liệu từ form POST
$amount = intval($_POST['amount']);
$bank_name = trim($_POST['bank_name']);
$bank_account_number = trim($_POST['bank_account_number']);
$bank_account_holder = trim($_POST['bank_account_holder']);
$note = trim($_POST['note']);

// Giả sử $user_id và $amount đã được gán giá trị từ trước
$amount = (float) $_POST['amount'];

if ($amount <= 0) {
    echo "Số tiền rút không hợp lệ.";
    exit;
}

// Rút tối thiểu 100.000đ/lần (mục 7 BUSINESS_RULES.md, bổ sung 2026-07-15)
if ($amount < 100000) {
    echo "Số tiền rút tối thiểu là 100.000đ.";
    exit;
}

require_once dirname(__FILE__) . '/../../admin80/include/order_commission.php';

// Tạo yêu cầu rút + trừ ngay ví khả dụng (kha_dung) trong 1 transaction (mục 7, mục 8.2 BUSINESS_RULES.md)
$mysqli->begin_transaction();
try {
    // Khoá dòng ví để lấy số dư thật, tránh 2 yêu cầu rút cùng lúc trừ vượt quá số dư
    $stmt = $mysqli->prepare("SELECT kha_dung FROM user_wallets WHERE user_id = ? FOR UPDATE");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $walletRow = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $current_balance = $walletRow ? (float)$walletRow['kha_dung'] : 0;

    if ($amount > $current_balance) {
        $mysqli->rollback();
        echo "Số tiền rút không hợp lệ hoặc vượt quá số dư khả dụng hiện tại: " . number_format($current_balance, 0) . " VND.";
        exit;
    }

    $stmt = $mysqli->prepare("
        INSERT INTO transactions (user_id, type, amount, bank_name, bank_account_number, bank_account_holder, note, created_at)
        VALUES (?, 'withdraw', ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("idssss", $user_id, $amount, $bank_name, $bank_account_number, $bank_account_holder, $note);
    $stmt->execute();
    $transaction_id = $mysqli->insert_id;
    $stmt->close();

    $debited = debitWallet($mysqli, $user_id, 'kha_dung', $amount, 'withdraw', $transaction_id);
    if (!$debited) {
        $mysqli->rollback();
        echo "Số tiền rút không hợp lệ hoặc vượt quá số dư khả dụng hiện tại: " . number_format($current_balance, 0) . " VND.";
        exit;
    }

    $mysqli->commit();

    sendTelegramNotify(
        "💸 <b>Yêu cầu rút tiền mới #{$transaction_id}</b>\n" .
        "Thành viên: " . htmlspecialchars($bank_account_holder) . " (ID {$user_id})\n" .
        "Số tiền: " . number_format($amount, 0, ',', '.') . "đ\n" .
        "Ngân hàng: " . htmlspecialchars($bank_name) . " - " . htmlspecialchars($bank_account_number),
        TELEGRAM_CHAT_ID_WITHDRAW
    );

    echo 'success';
    exit;
} catch (Throwable $e) {
    $mysqli->rollback();
    error_log("xu_ly_rut_tien user_id={$user_id}: " . $e->getMessage());
    echo "Lỗi khi xử lý yêu cầu. Vui lòng thử lại.";
    exit;
}
?>
