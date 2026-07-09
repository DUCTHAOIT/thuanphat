<?php
// Kiểm tra nếu có tham số user_id truyền vào
if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    http_response_code(400);
    echo "<div class='text-danger'>Thiếu hoặc sai ID người dùng.</div>";
    exit;
}

$user_id = (int) $_GET['user_id'];

// Chuẩn bị truy vấn
$stmt = $mysqli->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<div class='text-warning'>Không tìm thấy người dùng.</div>";
    exit;
}

$user = $result->fetch_assoc();

// Hiển thị thông tin
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tr><th>ID</th><td><?= htmlspecialchars($user['id']) ?></td></tr>
        <tr><th>Ngày đăng ký</th><td><?= htmlspecialchars($user['date_create']) ?></td></tr>
        <tr><th>Họ tên</th><td><?= htmlspecialchars($user['name']) ?></td></tr>
        <tr><th>CCCD</th><td><?= htmlspecialchars($user['cmt']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
        <tr><th>Số điện thoại</th><td><?= htmlspecialchars($user['mobile']) ?></td></tr>
        <tr><th>Giới tính</th><td><?= htmlspecialchars($user['sex']) ?></td></tr>
        <tr><th>Ngày sinh</th><td><?= htmlspecialchars($user['sinhngay']) ?></td></tr>

        <tr><th>Địa chỉ</th><td><?= htmlspecialchars($user['address']) ?></td></tr>


        <tr><th>Số tài khoản</th><td><?= htmlspecialchars($user['tknh']) ?></td></tr>
        <tr><th>Tên chủ tài khoản</th><td><?= htmlspecialchars($user['tenchutknh']) ?></td></tr>
        <tr><th>Ngân hàng</th><td><?= htmlspecialchars($user['nganhangtknh']) ?></td></tr>
        <tr>
            <th>Ảnh đại diện</th>
            <td>
                <?php if (!empty($user['avata'])): ?>
                    <img src="/modules/avatar/images/<?= htmlspecialchars($user['avata']) ?>" alt="Avata" style="max-height: 100px;">
                <?php else: ?>
                    Không có
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Ảnh CCCD</th>
            <td>
                <?php if (!empty($user['img'])): ?>
                    <img src="/images/user/<?= htmlspecialchars($user['img']) ?>" alt="Avata" style="max-height: 100px;">
                <?php else: ?>
                    Không có
                <?php endif; ?>

                <?php if (!empty($user['img1'])): ?>
                    <img src="/images/user/<?= htmlspecialchars($user['img1']) ?>" alt="Avata" style="max-height: 100px;">
                <?php else: ?>
                    Không có
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>
<?php
$stmt->close();
?>
