<?php
session_start();
$username = getSession("username");
if (!isset($username) || empty($username)) {
    header("Location: /");
    exit();
}
$user_id = getMemberNameID($username, "id");

$transaction_id = (int) ($_POST['transaction_id'] ?? 0);
if ($transaction_id <= 0) {
    echo "Yêu cầu không hợp lệ.";
    exit;
}

require_once dirname(__FILE__) . '/../../admin80/include/order_commission.php';

$result = processWithdrawCancel($mysqli, $transaction_id, $user_id);

if ($result['ok']) {
    echo 'success';
} else {
    echo $result['error'];
}
exit;
