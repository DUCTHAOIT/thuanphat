<?php
// AJAX: tìm thành viên theo tên / email / SĐT / ID, dùng chung cho ô tìm kiếm dạng sổ xuống (dropdown) của
// cả 2 trang admin80/modules/sodo/truc_tiep.php và dieu_tang.php.
session_start();
header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    echo json_encode([]);
    exit();
}

$like = '%' . $q . '%';
$idExact = ctype_digit($q) ? (int) $q : 0;

$stmt = $mysqli->prepare("SELECT id, name, email, mobile FROM user WHERE name LIKE ? OR email LIKE ? OR mobile LIKE ? OR id = ? ORDER BY id DESC LIMIT 15");
$stmt->bind_param("sssi", $like, $like, $like, $idExact);
$stmt->execute();
$res = $stmt->get_result();

$out = [];
while ($row = $res->fetch_assoc()) $out[] = $row;
$stmt->close();

echo json_encode($out);
