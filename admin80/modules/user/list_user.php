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
            u.id, u.name, u.email, u.cmt, u.mobile, u.gioithieu, u.date_create,
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
            (SELECT COUNT(*) FROM user f4 WHERE f4.ref_by IN (
                SELECT f3.id FROM user f3 WHERE f3.ref_by IN (
                    SELECT f2.id FROM user f2 WHERE f2.ref_by IN (
                        SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
                    )
                )
            )) AS so_luong_f4,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 4) AS hoa_hong_f4,
            (SELECT COUNT(*) FROM user f5 WHERE f5.ref_by IN (
                SELECT f4.id FROM user f4 WHERE f4.ref_by IN (
                    SELECT f3.id FROM user f3 WHERE f3.ref_by IN (
                        SELECT f2.id FROM user f2 WHERE f2.ref_by IN (
                            SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
                        )
                    )
                )
            )) AS so_luong_f5,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 5) AS hoa_hong_f5,
            (SELECT COUNT(*) FROM user f6 WHERE f6.ref_by IN (
                SELECT f5.id FROM user f5 WHERE f5.ref_by IN (
                    SELECT f4.id FROM user f4 WHERE f4.ref_by IN (
                        SELECT f3.id FROM user f3 WHERE f3.ref_by IN (
                            SELECT f2.id FROM user f2 WHERE f2.ref_by IN (
                                SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
                            )
                        )
                    )
                )
            )) AS so_luong_f6,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 6) AS hoa_hong_f6,
            (SELECT COUNT(*) FROM user f7 WHERE f7.ref_by IN (
                SELECT f6.id FROM user f6 WHERE f6.ref_by IN (
                    SELECT f5.id FROM user f5 WHERE f5.ref_by IN (
                        SELECT f4.id FROM user f4 WHERE f4.ref_by IN (
                            SELECT f3.id FROM user f3 WHERE f3.ref_by IN (
                                SELECT f2.id FROM user f2 WHERE f2.ref_by IN (
                                    SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
                                )
                            )
                        )
                    )
                )
            )) AS so_luong_f7,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 7) AS hoa_hong_f7,
            (SELECT COUNT(*) FROM user f8 WHERE f8.ref_by IN (
                SELECT f7.id FROM user f7 WHERE f7.ref_by IN (
                    SELECT f6.id FROM user f6 WHERE f6.ref_by IN (
                        SELECT f5.id FROM user f5 WHERE f5.ref_by IN (
                            SELECT f4.id FROM user f4 WHERE f4.ref_by IN (
                                SELECT f3.id FROM user f3 WHERE f3.ref_by IN (
                                    SELECT f2.id FROM user f2 WHERE f2.ref_by IN (
                                        SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
                                    )
                                )
                            )
                        )
                    )
                )
            )) AS so_luong_f8,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 8) AS hoa_hong_f8,
            (SELECT COUNT(*) FROM user f9 WHERE f9.ref_by IN (
                SELECT f8.id FROM user f8 WHERE f8.ref_by IN (
                    SELECT f7.id FROM user f7 WHERE f7.ref_by IN (
                        SELECT f6.id FROM user f6 WHERE f6.ref_by IN (
                            SELECT f5.id FROM user f5 WHERE f5.ref_by IN (
                                SELECT f4.id FROM user f4 WHERE f4.ref_by IN (
                                    SELECT f3.id FROM user f3 WHERE f3.ref_by IN (
                                        SELECT f2.id FROM user f2 WHERE f2.ref_by IN (
                                            SELECT f1.id FROM user f1 WHERE f1.ref_by = u.id
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            )) AS so_luong_f9,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id AND c.level = 9) AS hoa_hong_f9,
            (SELECT IFNULL(SUM(c.amount), 0) FROM commissions c
             JOIN orders o2 ON c.order_id = o2.id AND o2.status = 'approved'
             WHERE c.user_id = u.id) AS tong_hoa_hong,
            IFNULL(uw.tong, 0) AS vi_tong,
            IFNULL(uw.kha_dung, 0) AS vi_kha_dung,
            IFNULL(uw.tieu_dung, 0) AS vi_tieu_dung,
            IFNULL(uw.tich_luy_tieu_dung, 0) AS vi_tich_luy_tieu_dung,
            IFNULL(uw.tai_tieu_dung, 0) AS vi_tai_tieu_dung,
            IFNULL(uw.thue_phi, 0) AS vi_thue_phi,
            IFNULL(cc.balance, 0) AS diem_the_tieu_dung
        FROM user u
        LEFT JOIN orders o ON u.id = o.user_id AND o.status = 'approved'
        LEFT JOIN user_wallets uw ON uw.user_id = u.id
        LEFT JOIN consumption_cards cc ON cc.user_id = u.id
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
        'ID', 'Họ tên', 'CCCD', 'Email', 'Mobile', 'Ngày tạo',
        'Doanh số bán trực tiếp',
        'Số F1', 'Hoa hồng hưởng từ F1',
        'Số F2', 'Hoa hồng hưởng từ F2',
        'Số F3', 'Hoa hồng hưởng từ F3',
        'Tổng Hoa Hồng',
        'Ví tổng', 'Ví khả dụng', 'Ví tiêu dùng', 'Ví tích lũy tiêu dùng', 'Ví tái tiêu dùng', 'Ví thuế phí',
        'Điểm thẻ tiêu dùng'
    ];

    while ($row = $res->fetch_assoc()) {
        $data[] = [
            $row['id'],
            $row['name'],
            $row['cmt'],
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
            (float)$row['vi_tong'],
            (float)$row['vi_kha_dung'],
            (float)$row['vi_tieu_dung'],
            (float)$row['vi_tich_luy_tieu_dung'],
            (float)$row['vi_tai_tieu_dung'],
            (float)$row['vi_thue_phi'],
            (float)$row['diem_the_tieu_dung'],
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
        u.id, u.name, u.email, u.mobile, u.cmt, u.gioithieu, u.date_create,
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
         WHERE c.user_id = u.id) AS tong_hoa_hong,
        IFNULL(uw.kha_dung, 0) AS vi_kha_dung,
        IFNULL(uw.tieu_dung, 0) AS vi_tieu_dung,
        IFNULL(uw.tich_luy_tieu_dung, 0) AS vi_tich_luy_tieu_dung,
        IFNULL(uw.tai_tieu_dung, 0) AS vi_tai_tieu_dung,
        IFNULL(uw.thue_phi, 0) AS vi_thue_phi,
        IFNULL(cc.balance, 0) AS diem_the_tieu_dung
    FROM user u
    LEFT JOIN orders o ON u.id = o.user_id AND o.status = 'approved'
    LEFT JOIN user_wallets uw ON uw.user_id = u.id
    LEFT JOIN consumption_cards cc ON cc.user_id = u.id
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

<div class="table-responsive" style="overflow-x:auto;">
<table class="table table-bordered table-striped" border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Ngày tạo</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Người giới thiệu</th>
        <th>Doanh số</th>
        <th>Ví khả dụng</th>
        <th>Ví tiêu dùng</th>
        <th>Ví tích lũy tiêu dùng</th>
        <th>Ví tái tiêu dùng</th>
        <th>Ví thuế phí</th>
        <th>Điểm thẻ tiêu dùng</th>

        <th>F1 / HH</th>
        <th>F2 / HH</th>
        <th>F3 / HH</th>
        <th>F4 / HH</th>
        <th>F5 / HH</th>
        <th>F6 / HH</th>
        <th>F7 / HH</th>
        <th>F8 / HH</th>
        <th>F9 / HH</th>
        <th>Tổng HH</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['date_create'] ?></td>
            <td><a href="?m=user&f=dashboard&user_id=<?= $row['id'] ?>&name=<?= htmlspecialchars($row['name']) ?>"><?= htmlspecialchars($row['name']) ?></a></td>
            <td><?= htmlspecialchars($row['email']) ?><br>Điện thoại: <?= htmlspecialchars($row['mobile']) ?><br>CCCD: <?= htmlspecialchars($row['cmt']) ?></td>
            <td><?= htmlspecialchars($row['gioithieu']) ?></td>
            <td><?= number_format($row['direct_sales'], 0, ',', '.') ?>đ</td>
            <td><?= number_format($row['vi_kha_dung'], 0, ',', '.') ?>đ</td>
            <td><?= number_format($row['vi_tieu_dung'], 0, ',', '.') ?>đ</td>
            <td><?= number_format($row['vi_tich_luy_tieu_dung'], 0, ',', '.') ?>đ</td>
            <td><?= number_format($row['vi_tai_tieu_dung'], 0, ',', '.') ?>đ</td>
            <td><?= number_format($row['vi_thue_phi'], 0, ',', '.') ?>đ</td>
            <td><strong><?= number_format($row['diem_the_tieu_dung'], 0, ',', '.') ?>đ</strong></td>

            <td><?= $row['so_luong_f1'] ?> / <?= number_format($row['hoa_hong_f1'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f2'] ?> / <?= number_format($row['hoa_hong_f2'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f3'] ?> / <?= number_format($row['hoa_hong_f3'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f4'] ?> / <?= number_format($row['hoa_hong_f4'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f5'] ?> / <?= number_format($row['hoa_hong_f5'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f6'] ?> / <?= number_format($row['hoa_hong_f6'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f7'] ?> / <?= number_format($row['hoa_hong_f7'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f8'] ?> / <?= number_format($row['hoa_hong_f8'], 0, ',', '.') ?>đ</td>
            <td><?= $row['so_luong_f9'] ?> / <?= number_format($row['hoa_hong_f9'], 0, ',', '.') ?>đ</td>
            <td><strong><?= number_format($row['tong_hoa_hong'], 0, ',', '.') ?>đ</strong></td>
        </tr>
    <?php endwhile; ?>
</table>
</div>
<!-- Phân trang -->
<div>Trang: 
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
