<?php
session_start();
header('Content-Type: application/json');

$username = getSession("username");
if (!isset($username) || empty($username)) {
    echo json_encode(['ok' => false, 'error' => 'Vui lòng đăng nhập lại.']);
    exit();
}
$sponsor_id = (int) getMemberNameID($username, "id");

$waiting_user_id = (int) ($_POST['waiting_user_id'] ?? 0);
$parent_id = (int) ($_POST['parent_id'] ?? 0);
$position = (int) ($_POST['position'] ?? 0);

if ($waiting_user_id <= 0 || $parent_id <= 0 || $position <= 0) {
    echo json_encode(['ok' => false, 'error' => 'Thiếu thông tin xếp vị trí.']);
    exit();
}

require_once dirname(__FILE__) . '/../../admin80/include/order_commission.php';

$result = placeSpilloverMember($mysqli, $sponsor_id, $waiting_user_id, $parent_id, $position);

echo json_encode($result);
