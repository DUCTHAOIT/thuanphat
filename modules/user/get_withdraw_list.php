<?php
$user_id = (int)($_GET['user_id'] ?? 0);
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

// Đếm tổng bản ghi
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM transactions WHERE user_id = ? AND type = 'withdraw'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$totalPages = ceil($total / $limit);

// Truy vấn dữ liệu
$stmt = $mysqli->prepare("SELECT * FROM transactions WHERE user_id = ? AND type = 'withdraw' ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bind_param("iii", $user_id, $limit, $offset);
$stmt->execute();
$res = $stmt->get_result();

ob_start();
while ($row = $res->fetch_assoc()):
    $status_label = '';
    $status_class = '';
    switch (strtolower($row['status'])) {
        case 'approved': $status_label = 'Đã chuyển khoản'; $status_class = 'text-success fw-bold'; break;
        case 'pending': $status_label = 'Chờ xác nhận'; $status_class = 'text-warning fw-bold'; break;
        case 'rejected': $status_label = 'Từ chối'; $status_class = 'text-danger fw-bold'; break;
        default: $status_label = ucfirst($row['status']); $status_class = '';
    }
    ?>
    <tr>
        <td>#<?= $row['id'] ?></td>
        <td><?= $row['created_at'] ?></td>
        <td><?= number_format($row['amount'], 0) ?> VND</td>
        <td><?= htmlspecialchars($row['bank_name']) ?></td>
        <td><?= htmlspecialchars($row['bank_account_number']) ?></td>
        <td><?= htmlspecialchars($row['bank_account_holder']) ?></td>
        <td class="<?= $status_class ?>"><?= $status_label ?></td>
        <td><?= $row['updated_at'] ?></td>
    </tr>
<?php endwhile; ?>
<?php $stmt->close();
$html = ob_get_clean();

// Tạo HTML cho phân trang
$pagination = '';
if ($totalPages > 1) {
    $pagination .= '<div style="text-align: center"><ul class="justify-content-center">';
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = $i == $page ? 'active' : '';
        $pagination .= "<li class='page-item $active'><a class='page-link' href='#' data-page='$i'>$i</a></li>";
    }
    $pagination .= '</ul></div>';
}

// Trả về dạng JSON
echo json_encode(['html' => $html, 'pagination' => $pagination]);
