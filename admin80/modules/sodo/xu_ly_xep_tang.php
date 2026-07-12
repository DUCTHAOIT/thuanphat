<?php
// Admin xếp vị trí THAY sponsor cho 1 thành viên đang trong hàng chờ (mục 6 BUSINESS_RULES.md).
// Sponsor thật được tra lại từ spillover_waiting_list (KHÔNG tin sponsor_id gửi từ client), rồi tái dùng
// nguyên hàm placeSpilloverMember() đã có (giống hệt luồng modules/user/xu_ly_xep_tang.php của chính
// sponsor tự thao tác) - giữ đúng ràng buộc "chỉ được xếp trong tầm với của sponsor", không đổi hàm này.
session_start();
header('Content-Type: application/json');

$waiting_user_id = (int) ($_POST['waiting_user_id'] ?? 0);
$parent_id = (int) ($_POST['parent_id'] ?? 0);
$position = (int) ($_POST['position'] ?? 0);

if ($waiting_user_id <= 0 || $parent_id <= 0 || $position <= 0) {
    echo json_encode(['ok' => false, 'error' => 'Thiếu thông tin xếp vị trí.']);
    exit();
}

$stmt = $mysqli->prepare("SELECT sponsor_id FROM spillover_waiting_list WHERE user_id = ? AND placed = 0");
$stmt->bind_param("i", $waiting_user_id);
$stmt->execute();
$waiting = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$waiting) {
    echo json_encode(['ok' => false, 'error' => 'Thành viên này không có trong danh sách chờ.']);
    exit();
}

require_once dirname(__FILE__) . '/../../include/order_commission.php';

$result = placeSpilloverMember($mysqli, (int) $waiting['sponsor_id'], $waiting_user_id, $parent_id, $position);

echo json_encode($result);
