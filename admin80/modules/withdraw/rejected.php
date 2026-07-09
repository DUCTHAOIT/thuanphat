<?php
session_start();
require_once 'classes/SimpleXLSXGen.php'; // thêm thư viện xuất Excel


// Lấy ngày lọc
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Nếu bấm xuất Excel
if (isset($_GET['export']) && $_GET['export'] == '1') {
    $sql = "SELECT t.created_at, t.updated_at, u.name, u.email, u.mobile, t.amount, 
                   t.bank_account_holder, t.bank_account_number, t.bank_name, t.note
            FROM transactions t
            JOIN user u ON t.user_id = u.id
            WHERE t.type = 'withdraw' AND t.status = 'rejected'";

    $params = [];
    $types = "";

    if ($start_date && $end_date) {
        $sql .= " AND DATE(t.created_at) BETWEEN ? AND ?";
        $types .= "ss";
        $params[] = $start_date;
        $params[] = $end_date;
    }

    $sql .= " ORDER BY t.created_at DESC";

    $stmt = $mysqli->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    $data[] = ['Thời gian yêu cầu', 'Thời gian từ chối', 'Người dùng', 'Email', 'SĐT', 'Số tiền', 'Chủ TK', 'Số TK', 'Ngân hàng', 'Lời nhắn'];

    while ($row = $res->fetch_assoc()) {
        $data[] = [
            $row['created_at'],
            $row['updated_at'],
            $row['name'],
            $row['email'],
            $row['mobile'],
            $row['amount'],
            $row['bank_account_holder'],
            $row['bank_account_number'],
            $row['bank_name'],
            $row['note']
        ];
    }

    $xlsx = Shuchkin\SimpleXLSXGen::fromArray($data);
    $xlsx->downloadAs('yeu_cau_rut_tien_tu_choi.xlsx');
    exit;
}

include_once("header.php");
global $db;
// Lấy danh sách yêu cầu rút tiền chờ duyệt
$sql = "SELECT t.*, u.name, u.email, u.mobile
        FROM transactions t
        JOIN user u ON t.user_id = u.id
        WHERE t.type = 'withdraw' AND t.status = 'rejected'";

$params = [];
$types = "";

if ($start_date && $end_date) {
    $sql .= " AND DATE(t.created_at) BETWEEN ? AND ?";
    $types .= "ss";
    $params[] = $start_date;
    $params[] = $end_date;
}

$sql .= " ORDER BY t.created_at DESC";

$stmt = $mysqli->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container py-4">
    <h3 class="mb-4">Yêu cầu rút tiền bị từ chối</h3>
    <form method="get" class="mb-3">
        <input type="hidden" name="m" value="withdraw">
        <input type="hidden" name="f" value="rejected">
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control" style="width:auto;">
            <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control" style="width:auto;">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="?m=withdraw&f=rejected&export=1&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>" class="btn btn-success">Xuất Excel</a>
        </div>
    </form>
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Thời gian duyệt</th>
                <th>Người dùng</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Số tiền</th>
                <th>Chủ tk</th>
                <th>Số TK</th>
                <th>Ngân Hàng</th>
                <th>Lời nhắn</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['updated_at'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['mobile']) ?></td>
                    <td><strong><?= number_format($row['amount'], 0) ?> VND</strong></td>
                    <td><?= htmlspecialchars($row['bank_account_holder']) ?></td>
                    <td><?= htmlspecialchars($row['bank_account_number']) ?></td>
                    <td><?= htmlspecialchars($row['bank_name']) ?></td>


                    <td><?= htmlspecialchars($row['note']) ?></td>

                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có yêu cầu rút tiền nào bị từ chối.</p>
    <?php endif; ?>
</div>
<?php
include_once("footer.php");
?>
