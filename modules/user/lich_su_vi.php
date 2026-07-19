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

$wallet_label = ['tong' => 'Ví tổng', 'kha_dung' => 'Ví khả dụng', 'tieu_dung' => 'Ví tiêu dùng', 'tich_luy_tieu_dung' => 'Ví tích lũy tiêu dùng', 'tai_tieu_dung' => 'Ví tái tiêu dùng', 'thue_phi' => 'Ví thuế, phí'];

// Nội dung chi tiết: ref_type='commission' gộp chung 3 loại hoa hồng/thưởng (direct/spillover/rank_bonus)
// nên phải join sang commissions.type mới tách được. Các ref_type khác giữ nhãn cũ.
$content_label_map = [
    'direct' => 'Hoa hồng trực tiếp',
    'spillover' => 'Hoa hồng điều tầng',
    'rank_bonus' => 'Thưởng danh hiệu',
    'order' => 'Thanh toán đơn hàng',
    'withdraw' => 'Rút tiền',
    'rebuy' => 'Tái tiêu dùng',
    'refund' => 'Hoàn tiền',
    'admin_adjust' => 'Điều chỉnh',
    'accumulated_consumption' => 'Tích lũy tiêu dùng',
];

function wallet_txn_content_label($ref_type, $commission_type, $content_label_map)
{
    if ($ref_type === 'commission') {
        return $content_label_map[$commission_type] ?? 'Hoa hồng';
    }
    return $content_label_map[$ref_type] ?? $ref_type;
}

// Ví tổng chỉ để theo dõi (mục 2 BUSINESS_RULES.md), không cho lọc riêng.
// Loại giao dịch: bỏ Hoàn tiền, Điều chỉnh khỏi bộ lọc theo yêu cầu.
$wallet_filter_options = $wallet_label;
unset($wallet_filter_options['tong']);

$content_filter_options = $content_label_map;
unset($content_filter_options['refund'], $content_filter_options['admin_adjust']);

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

// ----- Bộ lọc -----
$filter_wallet_type = trim($_GET['wallet_type'] ?? '');
$filter_content = trim($_GET['content'] ?? '');
$filter_direction = trim($_GET['direction'] ?? '');
$filter_from = trim($_GET['from'] ?? '');
$filter_to = trim($_GET['to'] ?? '');

if (!array_key_exists($filter_wallet_type, $wallet_filter_options)) $filter_wallet_type = '';
if (!array_key_exists($filter_content, $content_filter_options)) $filter_content = '';
if (!in_array($filter_direction, ['credit', 'debit'], true)) $filter_direction = '';

// Ví tổng chỉ để theo dõi (mục 2 BUSINESS_RULES.md) - không thống kê/tìm kiếm ở trang này, dù không chọn lọc gì.
$where = ["wt.user_id = ?", "wt.wallet_type != 'tong'"];
$params = [$user_id];
$types = "i";

if ($filter_wallet_type !== '') {
    $where[] = "wt.wallet_type = ?";
    $params[] = $filter_wallet_type;
    $types .= "s";
}
if ($filter_direction !== '') {
    $where[] = "wt.direction = ?";
    $params[] = $filter_direction;
    $types .= "s";
}
if ($filter_content !== '') {
    if (in_array($filter_content, ['direct', 'spillover', 'rank_bonus'], true)) {
        $where[] = "wt.ref_type = 'commission' AND c.type = ?";
        $params[] = $filter_content;
        $types .= "s";
    } else {
        $where[] = "wt.ref_type = ?";
        $params[] = $filter_content;
        $types .= "s";
    }
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
// Join thêm orders + user để lấy tầng (F mấy) và thành viên nào mua hàng sinh ra khoản hoa hồng
// (commissions.level chỉ có ở direct/spillover; commissions.order_id -> orders.user_id là người mua).
$joinSql = "
    LEFT JOIN commissions c ON wt.ref_type = 'commission' AND wt.ref_id = c.id
    LEFT JOIN orders o ON c.order_id = o.id
    LEFT JOIN user u ON o.user_id = u.id
";

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
    SELECT wt.wallet_type, wt.direction, wt.amount, wt.ref_type, wt.created_at, c.type AS commission_type,
           c.level AS commission_level, u.name AS source_name
    FROM wallet_transactions wt
    $joinSql
    WHERE $whereSql
    ORDER BY wt.id DESC
    LIMIT ? OFFSET ?
");
bindParamsArray($stmt, $listTypes, $listParams);
$stmt->execute();
$res = $stmt->get_result();
$wallet_txns = [];
while ($row = $res->fetch_assoc()) $wallet_txns[] = $row;
$stmt->close();

// Giữ nguyên các filter đang chọn khi bấm số trang
$pagination_query = $_GET;
unset($pagination_query['page']);

$active_nav = 'lich_su_vi';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css?v=<?php echo @filemtime(dirname(__FILE__) . '/dashboard.css'); ?>">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <div class="tpud-top">
        <div>
            <h2>Lịch sử giao dịch ví</h2>
            <div class="tpud-sub">Toàn bộ biến động cộng/trừ các ví của bạn</div>
        </div>
    </div>

    <div class="tpud-card" style="margin-bottom:20px;">
        <form method="get" style="display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end;">
            <input type="hidden" name="m" value="user">
            <input type="hidden" name="f" value="lich_su_vi">
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Ví</label>
                <select name="wallet_type" class="form-control" style="min-width:150px;">
                    <option value="">Tất cả</option>
                    <?php foreach ($wallet_filter_options as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $filter_wallet_type === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Loại giao dịch</label>
                <select name="content" class="form-control" style="min-width:170px;">
                    <option value="">Tất cả</option>
                    <?php foreach ($content_filter_options as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $filter_content === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
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
                <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=lich_su_vi" class="btn btn-secondary">Xóa lọc</a>
            </div>
        </form>
    </div>

    <div class="tpud-card">
        <?php if (empty($wallet_txns)): ?>
            <div class="tpud-empty">Không tìm thấy giao dịch nào</div>
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
                            <th>Tầng</th>
                            <th>Từ thành viên</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($wallet_txns as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                                <td>
                                    <?php if ($t['direction'] === 'credit'): ?>
                                        <span class="tpud-badge tpud-badge-success">Tăng</span>
                                    <?php else: ?>
                                        <span class="tpud-badge tpud-badge-danger">Giảm</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $wallet_label[$t['wallet_type']] ?? $t['wallet_type'] ?></td>
                                <td><?= number_format($t['amount'], 0) ?></td>
                                <td><?= wallet_txn_content_label($t['ref_type'], $t['commission_type'], $content_label_map) ?></td>
                                <td><?= $t['commission_level'] !== null ? 'F' . (int) $t['commission_level'] : '-' ?></td>
                                <td><?= $t['source_name'] !== null ? htmlspecialchars($t['source_name']) : '-' ?></td>
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
