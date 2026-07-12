<?php
// AJAX: trả về 3 vị trí con (1 ra 3) của 1 node trong cây điều tầng (spillover_tree), dùng chung cho:
// - Cây xem toàn hệ thống / xem theo thành viên (admin80/modules/sodo/dieu_tang.php, mode 'view')
// - Modal xếp vị trí thay sponsor (mode 'assign', JS tự đánh dấu ô trống có thể bấm)
// parent_id = user_id thật (chính sponsor cho tầng 1, hoặc user_id đã có trong cây cho tầng sâu hơn) -
// giống hệt cách modules/user/cay_dieu_tang.php truy vấn (parent_id = user_id của vị trí cha).
session_start();
header('Content-Type: application/json');

$parent_id = (int) ($_GET['parent_id'] ?? 0);

$occupied = [];
if ($parent_id > 0) {
    $stmt = $mysqli->prepare("SELECT st.position, st.user_id, u.name, u.email FROM spillover_tree st JOIN user u ON u.id = st.user_id WHERE st.parent_id = ?");
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $occupied[(int) $row['position']] = $row;
    $stmt->close();
}

$out = [];
for ($pos = 1; $pos <= 3; $pos++) {
    if (isset($occupied[$pos])) {
        $node = $occupied[$pos];
        $childUserId = (int) $node['user_id'];

        $stmt = $mysqli->prepare("SELECT 1 FROM spillover_tree WHERE parent_id = ? LIMIT 1");
        $stmt->bind_param("i", $childUserId);
        $stmt->execute();
        $hasChildren = (bool) $stmt->get_result()->fetch_row();
        $stmt->close();

        $out[] = [
            'occupied' => true,
            'position' => $pos,
            'user_id' => $childUserId,
            'name' => $node['name'],
            'email' => $node['email'],
            'has_children' => $hasChildren,
        ];
    } else {
        $out[] = [
            'occupied' => false,
            'position' => $pos,
            'parent_id' => $parent_id,
        ];
    }
}

echo json_encode($out);
