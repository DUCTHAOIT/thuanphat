<?php
require_once 'classes/SimpleXLSXGen.php'; // thêm thư viện xuất Excel

$limit = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$search_sql = " WHERE 1=1 ";
$params = [];
$types = "";

// Search theo từ khóa
if ($search !== '') {
    $search_sql .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.mobile LIKE ?) ";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "sss";
}

// Search theo ngày
if ($start_date !== '') {
    $search_sql .= " AND u.date_create >= ? ";
    $params[] = $start_date . " 00:00:00";
    $types .= "s";
}
if ($end_date !== '') {
    $search_sql .= " AND u.date_create <= ? ";
    $params[] = $end_date . " 23:59:59";
    $types .= "s";
}

// Xuất Excel
if (isset($_GET['export']) && $_GET['export'] == 1) {
    $sql_export = "
        SELECT 
            u.id, u.name, u.email, u.mobile, u.gioithieu, u.date_create,
            IFNULL(SUM(o.amount), 0) AS direct_sales,
            (SELECT COUNT(*) FROM user f1 WHERE f1.ref_by = u.id) AS so_luong_f1,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 1) AS hoa_hong_f1,
            (SELECT COUNT(*) FROM user f2 WHERE f2.ref_by IN (SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id)) AS so_luong_f2,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 2) AS hoa_hong_f2,
            (SELECT COUNT(*) FROM user f3 WHERE f3.ref_by IN (
                SELECT f2.id FROM user f2 WHERE f2.ref_by IN (
                    SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
                )
            )) AS so_luong_f3,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 3) AS hoa_hong_f3,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id) AS tong_hoa_hong
        FROM user u
        LEFT JOIN orders o ON u.id = o.user_id AND o.status = 'approved'
        $search_sql
        GROUP BY u.id
        ORDER BY u.date_create DESC
    ";

    $stmt = $mysqli->prepare($sql_export);
    if (!empty($params)) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    $data[] = [
        'ID', 'Họ tên', 'Email', 'Mobile', 'Ngày tạo',
        'Doanh số bán trực tiếp',
        'Số F1', 'Hoa hồng hưởng từ F1',
        'Số F2', 'Hoa hồng hưởng từ F2',
        'Số F3', 'Hoa hồng hưởng từ F3',
        'Tổng Hoa Hồng'
    ];

    while ($row = $res->fetch_assoc()) {
        $data[] = [
            $row['id'],
            $row['name'],
            $row['email'],
            $row['mobile'],
            $row['date_create'],
            (float)$row['direct_sales'],
            (int)$row['so_luong_f1'],
            (float)$row['hoa_hong_f1'],
            (int)$row['so_luong_f2'],
            (float)$row['hoa_hong_f2'],
            (int)$row['so_luong_f3'],
            (float)$row['hoa_hong_f3'],
            (float)$row['tong_hoa_hong'],
        ];
    }

    $xlsx = Shuchkin\SimpleXLSXGen::fromArray($data);
    $xlsx->downloadAs('user_report.xlsx');
    exit;
}
include_once("header.php");
// Đếm tổng số bản ghi
$count_sql = "SELECT COUNT(*) FROM user u $search_sql";
$stmt = $mysqli->prepare($count_sql);
if (!empty($params)) $stmt->bind_param($types, ...$params);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

// Lấy dữ liệu phân trang
$sql = "
    SELECT 
        u.id, u.name, u.email, u.mobile, u.gioithieu, u.date_create,
        IFNULL(SUM(o.amount), 0) AS direct_sales,
        (SELECT COUNT(*) FROM user f1 WHERE f1.ref_by = u.id) AS so_luong_f1,
        (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
         JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
         WHERE c.user_id = u.id AND c.level = 1) AS hoa_hong_f1,
        (SELECT COUNT(*) FROM user f2 WHERE f2.ref_by IN (SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id)) AS so_luong_f2,
        (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
         JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
         WHERE c.user_id = u.id AND c.level = 2) AS hoa_hong_f2,
        (SELECT COUNT(*) FROM user f3 WHERE f3.ref_by IN (
            SELECT f2.id FROM user f2 WHERE f2.ref_by IN (
                SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
            )
        )) AS so_luong_f3,
        (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
         JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
         WHERE c.user_id = u.id AND c.level = 3) AS hoa_hong_f3,
        (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
         JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
         WHERE c.user_id = u.id) AS tong_hoa_hong
    FROM user u
    LEFT JOIN orders o ON u.id = o.user_id AND o.status = 'approved'
    $search_sql
    GROUP BY u.id
    ORDER BY u.date_create DESC
    LIMIT ? OFFSET ?
";
$params2 = $params;
$types2 = $types . "ii";
$params2[] = $limit;
$params2[] = $offset;

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types2, ...$params2);
$stmt->execute();
$result = $stmt->get_result();
?>

<form method="get">
    <input type="hidden" name="m" value="user">
    <input type="hidden" name="f" value="list_user">
    <input type="text" name="search" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($search) ?>">
    <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
    <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
    <button type="submit">Tìm kiếm</button>
    <button type="submit" name="export" value="1">📥 Xuất Excel</button>
</form>

<table class="table table-bordered table-striped" border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Người giới thiệu</th>
        <th>Ngày tạo</th>
        <th>Doanh số</th>
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
        $link = "?m=user&f=list_user&page=$i&search=" . urlencode($search) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date);
        if ($search !== '') $link .= '&search=' . urlencode($search);
        ?>
        <a href="<?= $link ?>" <?= $i === $page ? 'style="font-weight:bold"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php
include_once("footer.php");
?>
