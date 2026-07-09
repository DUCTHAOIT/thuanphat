<?php
include_once("header.php");
$limit = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Base query
$search_sql = "";
$params = [];
$types = "";

if ($search !== '') {
    $search_sql = " WHERE u.name LIKE ? OR u.email LIKE ? OR u.mobile LIKE ? ";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "sss";
}

// Count total for pagination
$count_sql = "SELECT COUNT(*) FROM user u $search_sql";
$stmt = $mysqli->prepare($count_sql);
if (!empty($params)) $stmt->bind_param($types, ...$params);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

// Main data query
$sql = "
    SELECT 
        u.id, u.name, u.email, u.mobile, u.gioithieu, u.date_create,

        -- Doanh số bán trực tiếp
        IFNULL(SUM(o.amount), 0) AS direct_sales,

        -- Hoa hồng trực tiếp (level 0)
        (
            SELECT IFNULL(SUM(c.amount), 0) 
            FROM commissions c
            JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
            WHERE c.user_id = u.id AND c.level = 0
        ) AS hoa_hong_truc_tiep,

        -- Số lượng F1
        (SELECT COUNT(*) FROM user f1 WHERE f1.ref_by = u.id) AS so_luong_f1,

        -- Hoa hồng từ F1 (level 1)
        (
            SELECT IFNULL(SUM(c.amount), 0)
            FROM commissions c
            JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
            WHERE c.user_id = u.id AND c.level = 1
        ) AS hoa_hong_f1,

        -- Số lượng F2
        (
            SELECT COUNT(*) 
            FROM user f2 
            WHERE f2.ref_by IN (
                SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
            )
        ) AS so_luong_f2,

        -- Hoa hồng từ F2 (level 2)
        (
            SELECT IFNULL(SUM(c.amount), 0)
            FROM commissions c
            JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
            WHERE c.user_id = u.id AND c.level = 2
        ) AS hoa_hong_f2,

        -- Số lượng F3
        (
            SELECT COUNT(*) 
            FROM user f3 
            WHERE f3.ref_by IN (
                SELECT f2.id 
                FROM user f2 
                WHERE f2.ref_by IN (
                    SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
                )
            )
        ) AS so_luong_f3,

        -- Hoa hồng từ F3 (level 3)
        (
            SELECT IFNULL(SUM(c.amount), 0)
            FROM commissions c
            JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
            WHERE c.user_id = u.id AND c.level = 3
        ) AS hoa_hong_f3,

        -- Tổng cộng hoa hồng (tất cả level)
        (
            SELECT IFNULL(SUM(c.amount), 0)
            FROM commissions c
            JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
            WHERE c.user_id = u.id
        ) AS tong_hoa_hong

    FROM user u
    LEFT JOIN orders o 
        ON u.id = o.user_id 
        AND o.status = 'approved'
    $search_sql
    GROUP BY u.id
    ORDER BY u.date_create DESC
    LIMIT ? OFFSET ?
";


$params[] = $limit;
$params[] = $offset;
$types .= "ii";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Giao diện HTML -->
<form method="get">
    <input type="hidden" name="m" value="user">
    <input type="hidden" name="f" value="list_user">
    <input type="text" name="search" placeholder="Tìm kiếm theo tên, email, mobile" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Tìm kiếm</button>
</form>
<a href="?m=user&f=export_users">📥 Xuất Excel</a>
<table class="table table-bordered table-striped" border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Người giới thiệu</th>
        <th>Ngày tạo</th>
        <th>Đã mua</th>

        <th>F1 / HH</th>
        <th>F2 / HH</th>
        <th>F3 / HH</th>
        <th>Tổng HH</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?><br><?= htmlspecialchars($row['mobile']) ?></td>
            <td><?= htmlspecialchars($row['gioithieu']) ?></td>
            <td><?= $row['date_create'] ?></td>
            <td><?= number_format($row['direct_sales'], 0, ',', '.') ?>đ</td>

            <td><?= $row['so_luong_f1'] ?> / <?= number_format($row['hoa_hong_f1'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f2'] ?> / <?= number_format($row['hoa_hong_f2'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f3'] ?> / <?= number_format($row['hoa_hong_f3'], 0, ',', '.') ?>đ</td>
            <td><strong><?= number_format($row['tong_hoa_hong'], 0, ',', '.') ?>đ</strong></td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- Phân trang -->
<div>
    <?php
    $total_pages = ceil($total / $limit);
    for ($i = 1; $i <= $total_pages; $i++):
        $link = "?m=user&f=list_user&page=$i";
        if ($search !== '') $link .= '&search=' . urlencode($search);
        ?>
        <a href="<?= $link ?>" <?= $i === $page ? 'style="font-weight:bold"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php include_once("footer.php"); ?>
