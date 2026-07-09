<?php
session_start();
require_once dirname(__FILE__) . '/../../include/order_commission.php';
include_once("header.php");
global $db;
/*
// Kiểm tra nếu không phải admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}*/

// Duyệt/từ chối yêu cầu rút tiền. Reject sẽ hoàn lại kha_dung đã trừ lúc tạo yêu cầu (mục 5 BUSINESS_RULES.md)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['transaction_id'])) {
    $transaction_id = (int) $_POST['transaction_id'];
    processWithdrawDecision($mysqli, $transaction_id, $_POST['action'] === 'approve');
}

// Lấy danh sách yêu cầu rút tiền chờ duyệt
$sql="SELECT t.id, t.user_id, t.amount, t.created_at, u.name, u.email, u.mobile
    FROM transactions t
    JOIN user u ON t.user_id = u.id
    WHERE t.type = 'withdraw' AND t.status = 'pending'
    ORDER BY t.created_at DESC";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<body class="container py-4">
<h3 class="mb-4">Yêu cầu rút tiền đang chờ duyệt</h3>

<?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Người dùng</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Số tiền</th>
            <th>Thời gian yêu cầu</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><strong><?= number_format($row['amount'], 0) ?> VND</strong></td>
                <td><?= $row['created_at'] ?></td>
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
</body>
<?php
include_once("footer.php");
?>
