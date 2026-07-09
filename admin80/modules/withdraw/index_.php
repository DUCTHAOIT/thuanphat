<?php
session_start();
require_once 'classes/SimpleXLSXGen.php'; // thêm thư viện xuất Excel
require_once dirname(__FILE__) . '/../../include/order_commission.php';


// Lấy ngày lọc
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Duyệt/từ chối yêu cầu rút tiền. Reject sẽ hoàn lại kha_dung đã trừ lúc tạo yêu cầu (mục 5 BUSINESS_RULES.md)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['transaction_id'])) {
    $transaction_id = (int) $_POST['transaction_id'];
    processWithdrawDecision($mysqli, $transaction_id, $_POST['action'] === 'approve');
}

// Nếu bấm xuất Excel
if (isset($_GET['export']) && $_GET['export'] == '1') {
    $sql = "SELECT t.created_at, u.name, u.email, u.mobile, t.amount, 
                   t.bank_account_holder, t.bank_account_number, t.bank_name, t.note
            FROM transactions t
            JOIN user u ON t.user_id = u.id
            WHERE t.type = 'withdraw' AND t.status = 'pending'";

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
    $data[] = ['Thời gian yêu cầu', 'Người dùng', 'Email', 'SĐT', 'Số tiền', 'Chủ TK', 'Số TK', 'Ngân hàng', 'Lời nhắn'];

    while ($row = $res->fetch_assoc()) {
        $data[] = [
            $row['created_at'],
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
    $xlsx->downloadAs('yeu_cau_rut_tien.xlsx');
    exit;
}
include_once("header.php");
global $db;
// Lấy danh sách yêu cầu rút tiền chờ duyệt
$sql = "SELECT t.*, u.name, u.email, u.mobile, u.id as uid
        FROM transactions t
        JOIN user u ON t.user_id = u.id
        WHERE t.type = 'withdraw' AND t.status = 'pending'";

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
    <h3 class="mb-4">Yêu cầu rút tiền đang chờ duyệt</h3>

    <form method="get" class="mb-3">
        <input type="hidden" name="m" value="withdraw">
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control" style="width:auto;">
            <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control" style="width:auto;">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="?m=withdraw&export=1&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>" class="btn btn-success">Xuất Excel</a>
        </div>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Thời gian yêu cầu</th>
                <th>Người dùng</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Số tiền</th>
                <th>Chủ tk</th>
                <th>Số TK</th>
                <th>Ngân Hàng</th>
                <th>Lời nhắn</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['created_at'] ?></td>
                    <td><a href="?m=user&f=dashboard&user_id=<?= $row['uid'] ?>&name=<?= $row['name'] ?>"> <?= htmlspecialchars($row['name']) ?></a></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['mobile']) ?></td>
                    <td><strong><?= number_format($row['amount'], 0) ?> VND</strong></td>
                    <td><?= htmlspecialchars($row['bank_account_holder']) ?></td>
                    <td><?= htmlspecialchars($row['bank_account_number']) ?></td>
                    <td><?= htmlspecialchars($row['bank_name']) ?></td>
                    <td><?= htmlspecialchars($row['note']) ?></td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="transaction_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Duyệt</button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Từ chối</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có yêu cầu rút tiền nào chờ duyệt.</p>
    <?php endif; ?>
</div>

<?php include_once("footer.php"); ?>
