<?php
session_start();
require_once 'classes/SimpleXLSXGen.php'; // thêm thư viện xuất Excel
// Cấu hình phân trang
$limit = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
// Lấy từ khóa tìm kiếm (nếu có)
$search = trim($_GET['search'] ?? '');
$search_like = '%' . $search . '%';

// ====== Nếu bấm nút Xuất Excel ======
if (isset($_GET['export']) && $_GET['export'] == 1) {
    $sql_export = "SELECT t.id, t.created_at, t.updated_at, u.name, u.email, u.mobile, t.products, t.amount, t.address, t.note 
                   FROM orders t
                   JOIN user u ON t.user_id = u.id
                   WHERE t.status = 'pending'";

    $params = [];
    $types = "";

    if ($search !== '') {
        $sql_export .= " AND (u.name LIKE ? OR u.mobile LIKE ? OR t.id = ?)";
        $types .= "ssi";
        $params[] = $search_like;
        $params[] = $search_like;
        $params[] = (int)$search;
    }

    if ($start_date !== '' && $end_date !== '') {
        $sql_export .= " AND DATE(t.created_at) BETWEEN ? AND ?";
        $types .= "ss";
        $params[] = $start_date;
        $params[] = $end_date;
    }

    $sql_export .= " ORDER BY t.created_at DESC";

    $stmt_exp = $mysqli->prepare($sql_export);
    if (!empty($params)) {
        $stmt_exp->bind_param($types, ...$params);
    }
    $stmt_exp->execute();
    $res_exp = $stmt_exp->get_result();

    $data = [];
    $data[] = ['ID', 'Ngày đặt', 'Ngày xác nhận', 'Tên KH', 'Email', 'SĐT', 'Đơn hàng', 'Tổng tiền (VNĐ)', 'Địa chỉ giao', 'Lời nhắn'];

    while ($row = $res_exp->fetch_assoc()) {
        $data[] = [
            $row['id'],
            $row['created_at'],
            $row['Chưa xác nhận'],
            $row['name'],
            $row['email'],
            $row['mobile'],
            $row['products'],
            number_format($row['amount'], 0),
            $row['address'],
            $row['note']
        ];
    }

    $xlsx = Shuchkin\SimpleXLSXGen::fromArray($data);
    $xlsx->downloadAs('donhang_choduyet.xlsx');
    exit;
}
// ====== Kết thúc phần xuất Excel ======

// Xử lý hành động duyệt / từ chối đơn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['order_id'])) {
    $order_id = (int) $_POST['order_id'];
    $action = $_POST['action'] === 'approve' ? 'approved' : 'rejected';

    $stmt = $mysqli->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $action, $order_id);
    $stmt->execute();
    $stmt->close();

    require_once dirname(__FILE__) . '/../../include/order_commission.php';
    if ($action === 'approved') {
        processOrderApproval($mysqli, $order_id);
    } else {
        processOrderRejection($mysqli, $order_id);
    }

    header("Location: ?m=order&page=$page&search=" . urlencode($search));
    exit;
}



include_once("header.php");
global $db;
// Đếm tổng đơn cần duyệt (tách khỏi JOIN)
$count_sql = "SELECT COUNT(*) as total FROM orders t 
              WHERE t.status = 'pending'";
$params = [];
$types = "";

/*if ($search !== '') {
    $count_sql .= " AND (t.id = ?)";
    $params[] = $search;
    $types .= "i";
}*/
if ($search !== '') {
    $count_sql .= " AND (t.id = ?)";
    $params[] = $search;
    $types .= "i";
}

if ($start_date !== '' && $end_date !== '') {
    $count_sql .= " AND DATE(t.created_at) BETWEEN ? AND ?";
    $params[] = $start_date;
    $params[] = $end_date;
    $types .= "ss";
}


$count_stmt = $mysqli->prepare($count_sql);
if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$total_rows = $count_stmt->get_result()->fetch_assoc()['total'];
$count_stmt->close();

$total_pages = ceil($total_rows / $limit);

// Truy vấn lấy đơn hàng
$sql = "SELECT t.*, u.name, u.email, u.mobile 
        FROM orders t 
        JOIN user u ON t.user_id = u.id 
        WHERE t.status = 'pending'";

$types = "";
$params = [];

if ($search !== '') {
    $sql .= " AND (u.name LIKE ? OR u.mobile LIKE ? OR t.id = ?)";
    $types .= "ssi";
    $params[] = $search_like;
    $params[] = $search_like;
    $params[] = (int) $search;
}

if ($start_date !== '' && $end_date !== '') {
    $sql .= " AND DATE(t.created_at) BETWEEN ? AND ?";
    $types .= "ss";
    $params[] = $start_date;
    $params[] = $end_date;
}

$sql .= " ORDER BY t.created_at DESC LIMIT ? OFFSET ?";
$types .= "ii";
$params[] = $limit;
$params[] = $offset;

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container py-4">
    <h3 class="mb-4">Đơn hàng đang chờ xác nhận</h3>

    <form class="mb-3" method="get">
        <input type="hidden" name="m" value="order">
        <div class="form-row">
        <table>
            <tr>
                <td><input type="text" name="search" class="form-control" placeholder="Tìm theo tên, SĐT hoặc ID" value="<?= htmlspecialchars($search) ?>"></td>
                <td><input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>"></td>
                <td><input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>"></td>
                <td><button class="btn btn-primary btn-block" type="submit">Tìm kiếm</button></td>
                <td>
                    <a href="?m=order&export=1&search=<?= urlencode($search) ?>&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>"
                       class="btn btn-success btn-block">Xuất Excel</a>
                </td>
            </tr>
        </table>

        </div>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Thời gian</th>
                <th>Khách hàng</th>
                <th>Đơn hàng</th>
                <th>Tổng tiền</th>
                <th>Chứng từ</th>
                <th>Địa chỉ giao</th>
                <th>Lời nhắn</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <?= htmlspecialchars($row['name']) ?><br>
                        <?= htmlspecialchars($row['email']) ?><br>
                        <?= htmlspecialchars($row['mobile']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['products']) ?></td>
                    <td><strong><?= number_format($row['amount'], 0) ?> VND</strong></td>
                    <td><img src="../images/order/<?= $row['img']; ?>" style="width: 200px"></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['note']) ?></td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Duyệt</button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Từ chối</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Phân trang -->
        <nav>
            <ul class="pagination">
                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                    <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?m=order&page=<?= $p ?>&search=<?= urlencode($search) ?>&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>">

                        <?= $p ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php else: ?>
        <p>Không có đơn hàng nào chờ xác nhận.</p>
    <?php endif; ?>
</div>

<?php include_once("footer.php"); ?>
