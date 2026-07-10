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

// ----- Đếm số thành viên ở 1 cấp F cụ thể -----
function count_level_users($mysqli, $user_id, $level)
{
    $currentIds = [$user_id];
    for ($i = 1; $i <= $level; $i++) {
        if (empty($currentIds)) return 0;
        $in = implode(",", array_map('intval', $currentIds));
        $res = $mysqli->query("SELECT id FROM user WHERE ref_by IN ($in)");
        $currentIds = [];
        while ($row = $res->fetch_assoc()) $currentIds[] = $row['id'];
    }
    return count($currentIds);
}

// ----- Hoa hồng + doanh số theo từng cấp F1-F9 -----
$level_counts = [];
$level_amounts = [];
$level_sales = [];
for ($level = 1; $level <= 9; $level++) {
    $level_counts[$level] = count_level_users($mysqli, $user_id, $level);

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
$total_f2_f9 = 0;
for ($l = 2; $l <= 9; $l++) $total_f2_f9 += $level_counts[$l] ?? 0;

$total_hoa_hong = array_sum($level_amounts);
$total_doanh_so = array_sum($level_sales);

// ----- Cây sơ đồ trực tiếp (toàn bộ tuyến dưới, đệ quy theo ref_by - mục 4 BUSINESS_RULES.md) -----
function getUserTree($mysqli, $user_id, $level = 1)
{
    $users = [];
    $stmt = $mysqli->prepare("SELECT id, name, email FROM user WHERE ref_by = ?");
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

function renderTree($tree)
{
    echo "<ul class='tpud-ftree-children'>";
    foreach ($tree as $node) {
        echo "<li>";
        echo "<span>F{$node['level']} | " . htmlspecialchars($node['name']) . " (" . htmlspecialchars($node['email']) . ") - Doanh số: " . number_format($node['sales'], 0, ",", ".") . "đ</span>";
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

$active_nav = 'so_do_truc_tiep';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <div class="tpud-top">
        <div>
            <h2>Sơ đồ trực tiếp</h2>
            <div class="tpud-sub">Hoa hồng và cây hệ thống theo tuyến giới thiệu trực tiếp (F1 - F9)</div>

        </div>

    </div>


    <!-- 3 thống kê -->
    <div class="tpud-grid tpud-grid-3">
        <div class="tpud-card">
            <div class="tpud-card-label">Thành viên trực tiếp (F1)</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_f1) ?> thành viên</div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Thành viên F2 - F9</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_f2_f9) ?> thành viên</div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Tổng hoa hồng trực tiếp</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_hoa_hong, 0) ?> VND</div>
        </div>
    </div>
    <!-- Cây sơ đồ trực tiếp -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <div class="tpud-section-head">
            <h4 style="font-size:15px;">Cây sơ đồ trực tiếp</h4>
        </div>
        <?php if (empty($direct_tree)): ?>
            <div class="tpud-empty"><i class="fa fa-sitemap" aria-hidden="true"></i>Chưa có thành viên F1 nào</div>
        <?php else: ?>
            <div style="margin-bottom:10px;">
                <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=export_tree" class="tpud-btn tpud-btn-green" style="width:auto; display:inline-block; padding:6px 14px; text-decoration:none;">Export Excel</a>
            </div>
            <div class="tpud-ftree" id="tpudFtree">
                <span class="tpud-ftree-root" id="tpudFtreeRoot">
                    <?= htmlspecialchars($MemberName ?: $username) ?>
                    - <?= number_format($direct_tree_total_users) ?> thành viên
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
    <!-- Hoa hồng theo cấp -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <h4 style="margin-bottom:10px; font-size:15px;">Hoa hồng theo cấp (F1 - F9)</h4>
        <div style="overflow-x:auto;">
            <table class="tpud-table">
                <thead>
                    <tr>
                        <th>Tầng</th>
                        <th>Số lượng</th>
                        <th>Doanh số</th>
                        <th>Hoa hồng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($level = 1; $level <= 9; $level++): ?>
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