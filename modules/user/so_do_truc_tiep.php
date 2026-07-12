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
$MemberName = getMemberNameID($username, "name");

// ----- Đếm số thành viên ở 1 cấp F cụ thể (tổng + đã business_active) -----
function count_level_users($mysqli, $user_id, $level)
{
    $currentIds = [$user_id];
    $activeCount = 0;
    for ($i = 1; $i <= $level; $i++) {
        if (empty($currentIds)) return ['total' => 0, 'active' => 0];
        $in = implode(",", array_map('intval', $currentIds));
        $res = $mysqli->query("SELECT id, business_active FROM user WHERE ref_by IN ($in)");
        $currentIds = [];
        $activeCount = 0;
        while ($row = $res->fetch_assoc()) {
            $currentIds[] = $row['id'];
            if ((int) $row['business_active'] === 1) $activeCount++;
        }
    }
    return ['total' => count($currentIds), 'active' => $activeCount];
}

// ----- Hoa hồng + doanh số theo từng cấp F1-F8 (mục 4 BUSINESS_RULES.md, cập nhật 2026-07-10: bỏ tầng F9) -----
$level_counts = [];
$level_active_counts = [];
$level_amounts = [];
$level_sales = [];
for ($level = 1; $level <= 8; $level++) {
    $level_stat = count_level_users($mysqli, $user_id, $level);
    $level_counts[$level] = $level_stat['total'];
    $level_active_counts[$level] = $level_stat['active'];

    $stmt = $mysqli->prepare("
        SELECT SUM(c.amount) AS hoa_hong, SUM(o.amount) AS doanh_so
        FROM commissions c
        JOIN orders o ON c.order_id = o.id
        WHERE o.status = 'approved' AND c.user_id = ? AND c.level = ? AND c.type = 'direct'
    ");
    $stmt->bind_param("ii", $user_id, $level);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $level_amounts[$level] = $row['hoa_hong'] ?? 0;
    $level_sales[$level] = $row['doanh_so'] ?? 0;
}
$total_f1 = $level_counts[1] ?? 0;
$total_f1_active = $level_active_counts[1] ?? 0;
$total_f2_f9 = 0;
$total_f2_f9_active = 0;
for ($l = 2; $l <= 8; $l++) {
    $total_f2_f9 += $level_counts[$l] ?? 0;
    $total_f2_f9_active += $level_active_counts[$l] ?? 0;
}

$total_hoa_hong = array_sum($level_amounts);
$total_doanh_so = array_sum($level_sales);

// ----- Cây sơ đồ trực tiếp (toàn bộ tuyến dưới, đệ quy theo ref_by - mục 4 BUSINESS_RULES.md) -----
function getUserTree($mysqli, $user_id, $level = 1)
{
    $users = [];
    $stmt = $mysqli->prepare("SELECT id, name, email, business_active FROM user WHERE ref_by = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $stmt2 = $mysqli->prepare("SELECT IFNULL(SUM(o.amount),0) as total_sales FROM orders o WHERE o.user_id = ? AND o.status = 'approved'");
        $stmt2->bind_param("i", $row['id']);
        $stmt2->execute();
        $sales = $stmt2->get_result()->fetch_assoc()['total_sales'] ?? 0;

        $row['sales'] = $sales;
        $row['level'] = $level;
        $row['children'] = getUserTree($mysqli, $row['id'], $level + 1);

        $users[] = $row;
    }
    return $users;
}

function sumSales($tree)
{
    $sum = 0;
    foreach ($tree as $node) {
        $sum += $node['sales'];
        if (!empty($node['children'])) $sum += sumSales($node['children']);
    }
    return $sum;
}

function countUsers($tree)
{
    $count = 0;
    foreach ($tree as $node) {
        $count += 1;
        if (!empty($node['children'])) $count += countUsers($node['children']);
    }
    return $count;
}

function countActiveUsers($tree)
{
    $count = 0;
    foreach ($tree as $node) {
        if ((int) $node['business_active'] === 1) $count += 1;
        if (!empty($node['children'])) $count += countActiveUsers($node['children']);
    }
    return $count;
}

function renderTree($tree)
{
    echo "<ul class='tpud-ftree-children'>";
    foreach ($tree as $node) {
        $activeClass = ((int) $node['business_active'] === 1) ? " tpud-ftree-node-active" : "";
        $leafClass = empty($node['children']) ? " tpud-ftree-leaf" : "";
        echo "<li class=\"$leafClass\">";
        echo "<span class=\"$activeClass\">F{$node['level']} | " . htmlspecialchars($node['name']) . " (" . htmlspecialchars($node['email']) . ") - Doanh số: " . number_format($node['sales'], 0, ",", ".") . "đ</span>";
        if (!empty($node['children'])) {
            renderTree($node['children']);
        }
        echo "</li>";
    }
    echo "</ul>";
}

$direct_tree = getUserTree($mysqli, $user_id);
$direct_tree_total_sales = sumSales($direct_tree);
$direct_tree_total_users = countUsers($direct_tree);
$direct_tree_active_users = countActiveUsers($direct_tree);

// ----- Lịch sử nhận hoa hồng trực tiếp (mục 4 BUSINESS_RULES.md) - có bộ lọc theo tầng + ngày -----
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

$filter_hh_level = trim($_GET['level'] ?? '');
$filter_hh_from = trim($_GET['from'] ?? '');
$filter_hh_to = trim($_GET['to'] ?? '');

if (!ctype_digit($filter_hh_level) || (int) $filter_hh_level < 1 || (int) $filter_hh_level > 8) $filter_hh_level = '';

$hh_where = ["c.user_id = ?", "c.type = 'direct'", "o.status = 'approved'"];
$hh_params = [$user_id];
$hh_types = "i";

if ($filter_hh_level !== '') {
    $hh_where[] = "c.level = ?";
    $hh_params[] = (int) $filter_hh_level;
    $hh_types .= "i";
}
if ($filter_hh_from !== '') {
    $hh_where[] = "c.created_at >= ?";
    $hh_params[] = $filter_hh_from . " 00:00:00";
    $hh_types .= "s";
}
if ($filter_hh_to !== '') {
    $hh_where[] = "c.created_at <= ?";
    $hh_params[] = $filter_hh_to . " 23:59:59";
    $hh_types .= "s";
}

$hh_whereSql = implode(" AND ", $hh_where);
$hh_joinSql = "JOIN orders o ON c.order_id = o.id LEFT JOIN user u ON o.user_id = u.id";

$hh_limit = 20;
$hh_page = max(1, (int) ($_GET['page'] ?? 1));
$hh_offset = ($hh_page - 1) * $hh_limit;

$stmt = $mysqli->prepare("SELECT COUNT(*) c FROM commissions c $hh_joinSql WHERE $hh_whereSql");
bindParamsArray($stmt, $hh_types, $hh_params);
$stmt->execute();
$hh_total = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
$stmt->close();
$hh_total_pages = (int) ceil($hh_total / $hh_limit);

$hh_listParams = $hh_params;
$hh_listParams[] = $hh_limit;
$hh_listParams[] = $hh_offset;
$hh_listTypes = $hh_types . "ii";

$stmt = $mysqli->prepare("
    SELECT c.level, c.amount, c.created_at, u.name AS source_name
    FROM commissions c
    $hh_joinSql
    WHERE $hh_whereSql
    ORDER BY c.id DESC
    LIMIT ? OFFSET ?
");
bindParamsArray($stmt, $hh_listTypes, $hh_listParams);
$stmt->execute();
$res = $stmt->get_result();
$hh_history = [];
while ($row = $res->fetch_assoc()) $hh_history[] = $row;
$stmt->close();

// Giữ nguyên các filter đang chọn khi bấm số trang
$hh_pagination_query = $_GET;
unset($hh_pagination_query['page']);

$active_nav = 'so_do_truc_tiep';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css?v=<?php echo @filemtime(dirname(__FILE__) . '/dashboard.css'); ?>">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <div class="tpud-top">
        <div>
            <h2>Sơ đồ trực tiếp</h2>
            <div class="tpud-sub">Hoa hồng và cây hệ thống theo tuyến giới thiệu trực tiếp (F1 - F8)</div>

        </div>

    </div>


    <!-- 3 thống kê -->
    <div class="tpud-grid tpud-grid-3">
        <div class="tpud-card">
            <div class="tpud-card-label">Thành viên trực tiếp (F1)</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_f1) ?> thành viên</div>
            <div style="margin-top:6px; font-size:13px; color:#6b7280;">
                <span class="tpud-badge tpud-badge-success">Đã Active: <?= number_format($total_f1_active) ?></span>
                <span class="tpud-badge tpud-badge-muted">Chưa Active: <?= number_format($total_f1 - $total_f1_active) ?></span>
            </div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Thành viên F2 - F8</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_f2_f9) ?> thành viên</div>
            <div style="margin-top:6px; font-size:13px; color:#6b7280;">
                <span class="tpud-badge tpud-badge-success">Đã Active: <?= number_format($total_f2_f9_active) ?></span>
                <span class="tpud-badge tpud-badge-muted">Chưa Active: <?= number_format($total_f2_f9 - $total_f2_f9_active) ?></span>
            </div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Tổng hoa hồng trực tiếp</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_hoa_hong, 0) ?> VND</div>
        </div>
    </div>
    <!-- Cây sơ đồ trực tiếp -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <div class="tpud-section-head">
            <h4 style="font-size:20px; font-weight:700;">Cây sơ đồ trực tiếp</h4>
        </div>
        <?php if (empty($direct_tree)): ?>
            <div class="tpud-empty"><i class="fa fa-sitemap" aria-hidden="true"></i>Chưa có thành viên F1 nào</div>
        <?php else: ?>
            <div style="margin-bottom:10px;">
                <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=export_tree" class="tpud-btn tpud-btn-green" style="width:auto; display:inline-block; padding:6px 14px; text-decoration:none;">Export Excel</a>
                <button type="button" id="tpudFtreeToggleAll" class="tpud-btn tpud-btn-blue" style="width:auto; display:inline-block; padding:6px 14px;">Hiển thị toàn bộ</button>
            </div>
            <div class="tpud-ftree" id="tpudFtree">
                <span class="tpud-ftree-root" id="tpudFtreeRoot">
                    <?= htmlspecialchars($MemberName ?: $username) ?>
                    - <?= number_format($direct_tree_total_users) ?> thành viên
                    (Active: <?= number_format($direct_tree_active_users) ?> - Chưa Active: <?= number_format($direct_tree_total_users - $direct_tree_active_users) ?>)
                    - Doanh số: <?= number_format($direct_tree_total_sales, 0, ",", ".") ?>đ
                </span>
                <?php renderTree($direct_tree); ?>
            </div>
            <script>
                (function() {
                    function wireUp() {
                        document.getElementById("tpudFtreeRoot")?.addEventListener("click", function() {
                            document.getElementById("tpudFtree")?.classList.toggle("open");
                        });

                        document.querySelectorAll("#tpudFtree li > span").forEach(function(span) {
                            span.addEventListener("click", function(e) {
                                e.stopPropagation();
                                this.parentElement.classList.toggle("open");
                            });
                        });

                        document.getElementById("tpudFtreeToggleAll")?.addEventListener("click", function() {
                            var treeEl = document.getElementById("tpudFtree");
                            var isOpen = treeEl.classList.contains("open");
                            var lis = treeEl.querySelectorAll("li");

                            if (isOpen) {
                                treeEl.classList.remove("open");
                                lis.forEach(function(li) {
                                    li.classList.remove("open");
                                });
                                this.textContent = "Hiển thị toàn bộ";
                            } else {
                                treeEl.classList.add("open");
                                lis.forEach(function(li) {
                                    li.classList.add("open");
                                });
                                this.textContent = "Thu gọn toàn bộ";
                            }
                        });
                    }

                    if (document.readyState === "loading") {
                        document.addEventListener("DOMContentLoaded", wireUp);
                    } else {
                        wireUp();
                    }
                })();
            </script>
        <?php endif; ?>
    </div>

    <!-- Lịch sử nhận hoa hồng trực tiếp -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <h4 style="margin-bottom:10px; font-size:15px;">Lịch sử nhận hoa hồng trực tiếp</h4>

        <form method="get" style="display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end; margin-bottom:16px;">
            <input type="hidden" name="m" value="user">
            <input type="hidden" name="f" value="so_do_truc_tiep">
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Thế Hệ</label>
                <select name="level" class="form-control" style="min-width:110px;">
                    <option value="">Tất cả</option>
                    <?php for ($lv = 1; $lv <= 8; $lv++): ?>
                        <option value="<?= $lv ?>" <?= $filter_hh_level === (string) $lv ? 'selected' : '' ?>>F<?= $lv ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Từ ngày</label>
                <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($filter_hh_from) ?>">
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Đến ngày</label>
                <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($filter_hh_to) ?>">
            </div>
            <div style="display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=so_do_truc_tiep" class="btn btn-secondary">Xóa lọc</a>
            </div>
        </form>

        <?php if (empty($hh_history)): ?>
            <div class="tpud-empty">Không tìm thấy hoa hồng trực tiếp nào</div>
        <?php else: ?>
            <div style="overflow-x:auto;">
                <table class="tpud-table">
                    <thead>
                        <tr>
                            <th>Ngày Giờ</th>
                            <th>Thế Hệ</th>
                            <th>Nguồn</th>
                            <th>Hoa hồng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hh_history as $h): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($h['created_at'])) ?></td>
                                <td>F<?= (int) $h['level'] ?></td>
                                <td><?= $h['source_name'] !== null ? htmlspecialchars($h['source_name']) : '-' ?></td>
                                <td><?= number_format($h['amount'], 0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($hh_total_pages > 1): ?>
                <div style="text-align:center; padding-top:16px;">
                    <ul class="pagination justify-content-center" style="display:inline-flex; list-style:none; gap:4px; padding:0; margin:0;">
                        <?php for ($i = 1; $i <= $hh_total_pages; $i++): ?>
                            <li class="page-item <?= $i == $hh_page ? 'active' : '' ?>">
                                <a class="page-link" href="<?php echo _DOMAIN_ROOT_URL; ?>/?<?= http_build_query(array_merge($hh_pagination_query, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Hoa hồng theo cấp -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <h4 style="margin-bottom:10px; font-size:15px;">Hoa hồng Trực Tiếp 8 Thế Hệ</h4>
        <div style="overflow-x:auto;">
            <table class="tpud-table">
                <thead>
                    <tr>
                        <th>Thế Hệ</th>
                        <th>Số lượng</th>
                        <th>Doanh số</th>
                        <th>Hoa hồng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($level = 1; $level <= 8; $level++): ?>
                        <tr>
                            <td>F<?= $level ?></td>
                            <td><?= number_format($level_counts[$level] ?? 0) ?></td>
                            <td><?= number_format($level_sales[$level] ?? 0) ?></td>
                            <td><?= number_format($level_amounts[$level] ?? 0) ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Tổng</td>
                        <td><?= number_format($total_f1 + $total_f2_f9) ?></td>
                        <td><?= number_format($total_doanh_so) ?></td>
                        <td><?= number_format($total_hoa_hong) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>

<?php include_once("footer.php"); ?>