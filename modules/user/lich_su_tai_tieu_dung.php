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

// Nội dung chi tiết: ref_type='commission' gộp chung 3 loại hoa hồng/thưởng (direct/spillover/rank_bonus)
// nên phải join sang commissions.type mới tách được. Các ref_type khác giữ nhãn cũ. (đồng bộ với lich_su_vi.php)
$content_label_map = [
    'direct' => 'Hoa hồng trực tiếp',
    'spillover' => 'Hoa hồng điều tầng',
    'rank_bonus' => 'Thưởng danh hiệu',
    'order' => 'Thanh toán đơn hàng',
    'withdraw' => 'Rút tiền',
    'rebuy' => 'Tái tiêu dùng',
    'refund' => 'Hoàn tiền',
    'admin_adjust' => 'Điều chỉnh',
];

function wallet_txn_content_label($ref_type, $commission_type, $content_label_map)
{
    if ($ref_type === 'commission') {
        return $content_label_map[$commission_type] ?? 'Hoa hồng';
    }
    return $content_label_map[$ref_type] ?? $ref_type;
}

// Truyền mảng params động vào bind_param (tương thích PHP 5/7, không dùng splat operator)
function bindParamsArray($stmt, $types, array $params)
{
    $refs = [];
    $refs[] = $types;
    foreach ($params as $key => $value) {
        $refs[] = &$params[$key];
    }
    call_user_func_array([$stmt, 'bind_param'], $refs);
}

// ----- Ví tái tiêu dùng: số dư hiện tại + số lần tái tiêu dùng (mục 2 BUSINESS_RULES.md) -----
$tai_tieu_dung_balance = 0;
$rebuy_count = 0;
$stmt = $mysqli->prepare("SELECT tai_tieu_dung, rebuy_count FROM user_wallets WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($res) {
    $tai_tieu_dung_balance = $res['tai_tieu_dung'];
    $rebuy_count = (int) $res['rebuy_count'];
}

// ----- Tổng đã nhận: cộng dồn toàn bộ các khoản credit vào ví tái tiêu dùng từ trước đến nay -----
// (khác với số dư hiện tại vì ví này bị reset về 0 sau mỗi lần tái tiêu dùng)
$tai_tieu_dung_tong_da_nhan = 0;
$stmt = $mysqli->prepare("SELECT SUM(amount) AS total FROM wallet_transactions WHERE user_id = ? AND wallet_type = 'tai_tieu_dung' AND direction = 'credit'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($res) $tai_tieu_dung_tong_da_nhan = (float) ($res['total'] ?? 0);

// ----- Bộ lọc -----
$filter_direction = trim($_GET['direction'] ?? '');
$filter_from = trim($_GET['from'] ?? '');
$filter_to = trim($_GET['to'] ?? '');

if (!in_array($filter_direction, ['credit', 'debit'], true)) $filter_direction = '';

$where = ["wt.user_id = ?", "wt.wallet_type = 'tai_tieu_dung'"];
$params = [$user_id];
$types = "i";

if ($filter_direction !== '') {
    $where[] = "wt.direction = ?";
    $params[] = $filter_direction;
    $types .= "s";
}
if ($filter_from !== '') {
    $where[] = "wt.created_at >= ?";
    $params[] = $filter_from . " 00:00:00";
    $types .= "s";
}
if ($filter_to !== '') {
    $where[] = "wt.created_at <= ?";
    $params[] = $filter_to . " 23:59:59";
    $types .= "s";
}

$whereSql = implode(" AND ", $where);
$joinSql = "LEFT JOIN commissions c ON wt.ref_type = 'commission' AND wt.ref_id = c.id";

$limit = 20;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$stmt = $mysqli->prepare("SELECT COUNT(*) c FROM wallet_transactions wt $joinSql WHERE $whereSql");
bindParamsArray($stmt, $types, $params);
$stmt->execute();
$total = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
$stmt->close();
$total_pages = (int) ceil($total / $limit);

$listParams = $params;
$listParams[] = $limit;
$listParams[] = $offset;
$listTypes = $types . "ii";

$stmt = $mysqli->prepare("
    SELECT wt.direction, wt.amount, wt.balance_after, wt.ref_type, wt.created_at, c.type AS commission_type
    FROM wallet_transactions wt
    $joinSql
    WHERE $whereSql
    ORDER BY wt.id DESC
    LIMIT ? OFFSET ?
");
bindParamsArray($stmt, $listTypes, $listParams);
$stmt->execute();
$res = $stmt->get_result();
$tai_tieu_dung_txns = [];
while ($row = $res->fetch_assoc()) $tai_tieu_dung_txns[] = $row;
$stmt->close();

// Giữ nguyên các filter đang chọn khi bấm số trang
$pagination_query = $_GET;
unset($pagination_query['page']);

$active_nav = 'lich_su_tai_tieu_dung';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css?v=<?php echo @filemtime(dirname(__FILE__) . '/dashboard.css'); ?>">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <div class="tpud-top">
        <div>
            <h2>Lịch sử tái tiêu dùng</h2>
            <div class="tpud-sub">Tự động tái tiêu dùng khi đạt 5.000.000đ, tối đa 258.000.000đ</div>
        </div>
    </div>

    <!-- 3 thống kê -->
    <div class="tpud-grid tpud-grid-3">
        <div class="tpud-card">
            <div class="tpud-card-label">Số lần tái tiêu dùng</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($rebuy_count) ?> lần</div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Số dư hiện tại</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($tai_tieu_dung_balance, 0) ?> <small>VND</small></div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Tổng đã nhận</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($tai_tieu_dung_tong_da_nhan, 0) ?> <small>VND</small></div>
        </div>
    </div>

    <div class="tpud-card" style="margin-bottom:20px;">
        <form method="get" style="display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end;">
            <input type="hidden" name="m" value="user">
            <input type="hidden" name="f" value="lich_su_tai_tieu_dung">
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Tăng/Giảm</label>
                <select name="direction" class="form-control" style="min-width:110px;">
                    <option value="">Tất cả</option>
                    <option value="credit" <?= $filter_direction === 'credit' ? 'selected' : '' ?>>Tăng</option>
                    <option value="debit" <?= $filter_direction === 'debit' ? 'selected' : '' ?>>Giảm</option>
                </select>
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Từ ngày</label>
                <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($filter_from) ?>">
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Đến ngày</label>
                <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($filter_to) ?>">
            </div>
            <div style="display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=lich_su_tai_tieu_dung" class="btn btn-secondary">Xóa lọc</a>
            </div>
        </form>
    </div>

    <div class="tpud-card">
        <?php if (empty($tai_tieu_dung_txns)): ?>
            <div class="tpud-empty">Không tìm thấy giao dịch nào</div>
        <?php else: ?>
            <div style="overflow-x:auto;">
                <table class="tpud-table">
                    <thead>
                        <tr>
                            <th>Ngày giờ</th>
                            <th>Loại</th>
                            <th>Số tiền</th>
                            <th>Số dư sau GD</th>
                            <th>Nội dung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tai_tieu_dung_txns as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                                <td>
                                    <?php if ($t['direction'] === 'credit'): ?>
                                        <span class="tpud-badge tpud-badge-success">Tăng</span>
                                    <?php else: ?>
                                        <span class="tpud-badge tpud-badge-danger">Giảm</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($t['amount'], 0) ?></td>
                                <td><?= number_format($t['balance_after'], 0) ?></td>
                                <td><?= wallet_txn_content_label($t['ref_type'], $t['commission_type'], $content_label_map) ?></td>
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
                                <a class="page-link" href="<?php echo _DOMAIN_ROOT_URL; ?>/?<?= http_build_query(array_merge($pagination_query, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include_once("footer.php"); ?>
