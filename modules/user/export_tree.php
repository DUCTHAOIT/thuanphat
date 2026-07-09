<?php
session_start();
require_once __DIR__ . '/SimpleXLSXGen.php';

$username = getSession("username");
if (!isset($username) || empty($username)) {
    header("Location: /");
    exit();
}

// --- Các hàm xử lý cây ---
function getUserTree($mysqli, $user_id, $level = 1) {
    $users = [];
    $stmt = $mysqli->prepare("SELECT id, name, mobile, email FROM user WHERE ref_by = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        // Doanh số của user
        $stmt2 = $mysqli->prepare("
            SELECT IFNULL(SUM(o.amount),0) as total_sales
            FROM orders o
            WHERE o.user_id = ? AND o.status = 'approved'
        ");
        $stmt2->bind_param("i", $row['id']);
        $stmt2->execute();
        $sales = $stmt2->get_result()->fetch_assoc()['total_sales'] ?? 0;

        $row['sales'] = $sales;
        $row['level'] = $level;
        $row['children'] = getUserTree($mysqli, $row['id'], $level + 1);

        $users[] = $row;
    }
    return $users;
}

function flattenTree($tree, &$result) {
    foreach ($tree as $node) {
        $result[] = [
            "F{$node['level']}",
            $node['name'],
            $node['mobile'],
            $node['email'],
            number_format($node['sales'], 0, ",", ".")
        ];
        if (!empty($node['children'])) {
            flattenTree($node['children'], $result);
        }
    }
}

// Chỉ export cây của chính user đang đăng nhập (không nhận user_id từ $_GET để tránh xem cây của người khác)
$user_id = (int) getMemberNameID($username, "id");
$tree = getUserTree($mysqli, $user_id);

// Chuẩn bị dữ liệu xuất
$data = [];
$data[] = ['Cấp F', 'Tên', 'Điện thoại', 'Email', 'Doanh số']; // header
flattenTree($tree, $data);

// Xuất ra Excel
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($data);
$xlsx->downloadAs('cay_he_thong_"'.$user_id.'".xlsx');
exit;
