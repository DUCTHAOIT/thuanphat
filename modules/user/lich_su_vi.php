<?php
session_start();
$username = getSession("username");
if (!isset($username) || empty($username)) {
    header("Location: /");
    exit();
}
$hide_slide = true; // Trang tài khoản: hiện menu như bình thường, ẩn ảnh slideshow đầu trang
include_once("header.php");

$user_id = getMemberNameID($username, "id");

$wallet_label = ['tong' => 'Ví tổng', 'kha_dung' => 'Ví khả dụng', 'tieu_dung' => 'Ví tiêu dùng', 'tai_tieu_dung' => 'Ví tái tiêu dùng', 'thue_phi' => 'Ví thuế, phí'];
$ref_type_label = ['order' => 'Thanh toán đơn hàng', 'commission' => 'Hoa hồng', 'withdraw' => 'Rút tiền', 'rebuy' => 'Tái tiêu dùng', 'refund' => 'Hoàn tiền', 'rank_bonus' => 'Thưởng danh hiệu', 'card_bonus' => 'Thẻ tiêu dùng tuần hoàn', 'admin_adjust' => 'Điều chỉnh'];

$limit = 20;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$stmt = $mysqli->prepare("SELECT COUNT(*) c FROM wallet_transactions WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
$stmt->close();
$total_pages = (int) ceil($total / $limit);

$wallet_txns = [];
$stmt = $mysqli->prepare("SELECT wallet_type, direction, amount, ref_type, created_at FROM wallet_transactions WHERE user_id = ? ORDER BY id DESC LIMIT ? OFFSET ?");
$stmt->bind_param("iii", $user_id, $limit, $offset);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $wallet_txns[] = $row;
$stmt->close();

$active_nav = 'lich_su_vi';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <div class="tpud-top">
        <div>
            <h2>Lịch sử giao dịch ví</h2>
            <div class="tpud-sub">Toàn bộ biến động cộng/trừ các ví của bạn</div>
        </div>
    </div>

    <div class="tpud-card">
        <?php if (empty($wallet_txns)): ?>
            <div class="tpud-empty">Chưa có giao dịch nào</div>
        <?php else: ?>
            <div style="overflow-x:auto;">
                <table class="tpud-table">
                    <thead>
                        <tr>
                            <th>Ngày giờ</th>
                            <th>Loại</th>
                            <th>Ví</th>
                            <th>Số tiền</th>
                            <th>Nội dung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($wallet_txns as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                                <td><?= $t['direction'] === 'credit' ? '+' : '-' ?></td>
                                <td><?= $wallet_label[$t['wallet_type']] ?? $t['wallet_type'] ?></td>
                                <td><?= number_format($t['amount'], 0) ?></td>
                                <td><?= $ref_type_label[$t['ref_type']] ?? $t['ref_type'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 1): ?>
                <div style="text-align:center; padding-top:16px;">
                    <ul class="pagination justify-content-center" style="display:inline-flex; list-style:none; gap:4px; padding:0; margin:0;">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=lich_su_vi&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include_once("footer.php"); ?>
