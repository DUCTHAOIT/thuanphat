<?php
// AJAX: trả về danh sách F1 trực tiếp của 1 user (lazy-load cây trực tiếp, admin80/modules/sodo/truc_tiep.php).
// parent_id = 0 (sentinel, không phải user_id thật) => trả về các thành viên không có người giới thiệu
// (ref_by IS NULL), tức "F1 của Root" theo mô tả nghiệp vụ.
session_start();
header('Content-Type: application/json');

$parent_id = (int) ($_GET['parent_id'] ?? 0);

if ($parent_id > 0) {
    $stmt = $mysqli->prepare("SELECT id, name, email, business_active FROM user WHERE ref_by = ? ORDER BY id");
    $stmt->bind_param("i", $parent_id);
} else {
    $stmt = $mysqli->prepare("SELECT id, name, email, business_active FROM user WHERE ref_by IS NULL ORDER BY id");
}
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$out = [];
foreach ($rows as $row) {
    $id = (int) $row['id'];

    $stmt = $mysqli->prepare("SELECT 1 FROM user WHERE ref_by = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $hasChildren = (bool) $stmt->get_result()->fetch_row();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT IFNULL(SUM(amount),0) AS total FROM orders WHERE user_id = ? AND status = 'approved'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $sales = (float) ($stmt->get_result()->fetch_assoc()['total'] ?? 0);
    $stmt->close();

    $out[] = [
        'id' => $id,
        'name' => $row['name'],
        'email' => $row['email'],
        'business_active' => (int) $row['business_active'],
        'sales' => $sales,
        'has_children' => $hasChildren,
    ];
}

echo json_encode($out);
