<?php
session_start();
include_once("header.php");
global $db;
/*
// Kiểm tra nếu không phải admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}*/

// Duyệt yêu cầu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['transaction_id'])) {
    $transaction_id = (int) $_POST['transaction_id'];
    $action = $_POST['action'] === 'approve' ? 'approved' : 'rejected';

    $stmt = $mysqli->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $action, $transaction_id);
    $stmt->execute();
    $stmt->close();
}

// Lấy danh sách yêu cầu rút tiền chờ duyệt
$sql="SELECT t.*, u.name, u.email, u.mobile
    FROM orders t
    JOIN user u ON t.user_id = u.id
    WHERE t.status = 'pending'
    ORDER BY t.created_at DESC";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container py-4">
<h3 class="mb-4">Đơn hàng mới đang chờ xác nhận</h3>

<?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
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
    <p>Không có đơn hàng nào chờ xác nhận.</p>
<?php endif; ?>
</div>
<?php
include_once("footer.php");
?>
