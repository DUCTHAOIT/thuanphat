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

// ----- Cây điều tầng (mục 6 BUSINESS_RULES.md) -----
// 1 CÂY CHUNG duy nhất toàn hệ thống, sơ đồ 1 ra 3, tối đa 9 tầng. Ở đây chỉ lấy nhánh cây bắt đầu từ vị trí
// của chính user đang đăng nhập (parent_id = user_id của người đó), KHÔNG lọc theo sponsor_id (ai xếp),
// vì con/cháu trong nhánh có thể do người khác (F1, F2... của user) xếp vào, không chỉ riêng user này xếp.
function getSpilloverChildren($mysqli, $parentUserId, $level = 1)
{
    if ($level > 9) return [];

    $stmt = $mysqli->prepare("
        SELECT st.user_id, u.name, u.email, st.position
        FROM spillover_tree st
        JOIN user u ON u.id = st.user_id
        WHERE st.parent_id = ?
    ");
    $stmt->bind_param("i", $parentUserId);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $byPosition = [];
    foreach ($rows as $row) {
        $row['children'] = getSpilloverChildren($mysqli, (int) $row['user_id'], $level + 1);
        $byPosition[(int) $row['position']] = $row;
    }
    return $byPosition;
}

function countSpilloverNodes($byPosition)
{
    $count = 0;
    foreach ($byPosition as $node) {
        $count += 1;
        $count += countSpilloverNodes($node['children']);
    }
    return $count;
}

// Render 1 tầng (3 vị trí): thành viên đã xếp hiện tên + đệ quy tầng con.
// Vị trí trống hiện ô trống, CÓ THỂ BẤM để mở modal xếp 1 thành viên đang chờ vào đây (data-parent/data-position).
function renderSpilloverLevel($byPosition, $parentUserId, $level)
{
    if ($level > 9) return;

    echo "<ul class='tpud-sftree-children'>";
    for ($pos = 1; $pos <= 3; $pos++) {
        if (isset($byPosition[$pos])) {
            $node = $byPosition[$pos];
            echo "<li class='tpud-sf-node'>";
            echo "<span>F{$level} | " . htmlspecialchars($node['name']) . " (" . htmlspecialchars($node['email']) . ")</span>";
            renderSpilloverLevel($node['children'], (int) $node['user_id'], $level + 1);
            echo "</li>";
        } else {
            echo "<li class='tpud-sf-empty'>";
            echo "<span class='tpud-sf-empty-slot' data-parent='{$parentUserId}' data-position='{$pos}' data-level='{$level}'>+ Ô trống - F{$level} - vị trí {$pos}</span>";
            echo "</li>";
        }
    }
    echo "</ul>";
}

$spillover_tree = getSpilloverChildren($mysqli, $user_id, 1);
$spillover_placed_count = countSpilloverNodes($spillover_tree);

$spillover_waiting_members = [];
$stmt = $mysqli->prepare("
    SELECT w.user_id, u.name, u.email, w.created_at
    FROM spillover_waiting_list w
    JOIN user u ON u.id = w.user_id
    WHERE w.sponsor_id = ? AND w.placed = 0
    ORDER BY w.created_at ASC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $spillover_waiting_members[] = $row;
$stmt->close();

// ----- Lịch sử hoa hồng điều tầng + thưởng (mục 6 BUSINESS_RULES.md) -----
// Gộp 2 nguồn: commissions (type='spillover' hoặc 'rank_bonus') và card_point_bonuses (thưởng điểm thẻ).
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
$sf_filter_type = trim($_GET['type'] ?? '');
$sf_filter_status = trim($_GET['status'] ?? '');
$sf_filter_level = trim($_GET['level'] ?? '');
$sf_filter_from = trim($_GET['from'] ?? '');
$sf_filter_to = trim($_GET['to'] ?? '');

if (!in_array($sf_filter_type, ['spillover', 'rank_bonus', 'card_point'], true)) $sf_filter_type = '';
if (!in_array($sf_filter_status, ['pending', 'released'], true)) $sf_filter_status = '';
if (!ctype_digit($sf_filter_level) || (int) $sf_filter_level < 1 || (int) $sf_filter_level > 9) $sf_filter_level = '';

$sf_unionSql = "
    SELECT order_id, level, type, amount, status, created_at
    FROM commissions WHERE user_id = ? AND type IN ('spillover','rank_bonus')
    UNION ALL
    SELECT order_id, level, 'card_point' AS type, amount, status, created_at
    FROM card_point_bonuses WHERE user_id = ?
";

$sf_where = [];
$sf_params = [$user_id, $user_id];
$sf_types = "ii";

if ($sf_filter_type !== '') {
    $sf_where[] = "t.type = ?";
    $sf_params[] = $sf_filter_type;
    $sf_types .= "s";
}
if ($sf_filter_status !== '') {
    $sf_where[] = "t.status = ?";
    $sf_params[] = $sf_filter_status;
    $sf_types .= "s";
}
if ($sf_filter_level !== '') {
    $sf_where[] = "t.level = ?";
    $sf_params[] = (int) $sf_filter_level;
    $sf_types .= "i";
}
if ($sf_filter_from !== '') {
    $sf_where[] = "t.created_at >= ?";
    $sf_params[] = $sf_filter_from . " 00:00:00";
    $sf_types .= "s";
}
if ($sf_filter_to !== '') {
    $sf_where[] = "t.created_at <= ?";
    $sf_params[] = $sf_filter_to . " 23:59:59";
    $sf_types .= "s";
}

$sf_whereSql = $sf_where ? ("WHERE " . implode(" AND ", $sf_where)) : "";

$sf_history_limit = 20;
$sf_history_page = max(1, (int) ($_GET['page'] ?? 1));
$sf_history_offset = ($sf_history_page - 1) * $sf_history_limit;

$stmt = $mysqli->prepare("SELECT COUNT(*) c FROM ($sf_unionSql) t $sf_whereSql");
bindParamsArray($stmt, $sf_types, $sf_params);
$stmt->execute();
$sf_history_total = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
$stmt->close();
$sf_history_total_pages = (int) ceil($sf_history_total / $sf_history_limit);

$sf_listParams = $sf_params;
$sf_listParams[] = $sf_history_limit;
$sf_listParams[] = $sf_history_offset;
$sf_listTypes = $sf_types . "ii";

$sf_history = [];
// Join orders + user để lấy tên thành viên đã mua hàng phát sinh ra khoản hoa hồng/thưởng này (cột "Nguồn").
$stmt = $mysqli->prepare("
    SELECT t.order_id, t.level, t.type, t.amount, t.status, t.created_at, u.name AS source_name
    FROM ($sf_unionSql) t
    LEFT JOIN orders o ON t.order_id = o.id
    LEFT JOIN user u ON o.user_id = u.id
    $sf_whereSql
    ORDER BY t.created_at DESC
    LIMIT ? OFFSET ?
");
bindParamsArray($stmt, $sf_listTypes, $sf_listParams);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $sf_history[] = $row;
$stmt->close();

// Giữ nguyên các filter đang chọn khi bấm số trang
$sf_pagination_query = $_GET;
unset($sf_pagination_query['page']);

// Tổng đã nhận / chưa nhận (toàn bộ, không giới hạn theo trang) để hiển thị hàng tổng cộng
$sf_tong_da_nhan = 0;
$sf_tong_chua_nhan = 0;
$stmt = $mysqli->prepare("
    SELECT status, SUM(amount) AS total FROM (
        SELECT status, amount FROM commissions WHERE user_id = ? AND type IN ('spillover','rank_bonus')
        UNION ALL
        SELECT status, amount FROM card_point_bonuses WHERE user_id = ?
    ) t
    GROUP BY status
");
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    if ($row['status'] === 'released') $sf_tong_da_nhan = (float) $row['total'];
    if ($row['status'] === 'pending') $sf_tong_chua_nhan = (float) $row['total'];
}
$stmt->close();

$sf_type_label = ['spillover' => 'Hoa hồng điều tầng', 'rank_bonus' => 'Thưởng danh hiệu', 'card_point' => 'Thưởng điểm thẻ tiêu dùng'];
$sf_status_label = ['pending' => 'Chưa nhận', 'released' => 'Đã nhận'];
$sf_status_class = ['pending' => 'tpud-badge-warning', 'released' => 'tpud-badge-success'];

$active_nav = 'cay_dieu_tang';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css?v=<?php echo @filemtime(dirname(__FILE__) . '/dashboard.css'); ?>">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <div class="tpud-top">
        <div>
            <h2>Cây điều tầng</h2>
            <div class="tpud-sub">Sơ đồ điều tầng và danh sách thành viên đang chờ bạn xếp vị trí</div>
        </div>
    </div>

    <div class="tpud-card" style="margin-bottom:20px;">
        <p style="font-size:14px; color:#6b7280; margin-bottom:10px;">
            Đã xếp: <strong><?= number_format($spillover_placed_count) ?></strong> thành viên
            &nbsp;|&nbsp; Đang chờ bạn xếp: <strong><?= number_format(count($spillover_waiting_members)) ?></strong> thành viên
        </p>

        <?php if (!empty($spillover_waiting_members)): ?>
            <div style="margin-bottom:14px;">
                <strong style="font-size:14px;">Danh sách chờ:</strong>
                <ul style="margin:6px 0 0; padding-left:18px; font-size:14px;">
                    <?php foreach ($spillover_waiting_members as $w): ?>
                        <li><?= htmlspecialchars($w['name']) ?> (<?= htmlspecialchars($w['email']) ?>) - chờ từ <?= date('d/m/Y', strtotime($w['created_at'])) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div style="margin-bottom:10px;">
            <button type="button" id="tpudSFtreeToggleAll" class="tpud-btn tpud-btn-blue" style="width:auto; display:inline-block; padding:6px 14px;">Hiển thị tất cả</button>
        </div>
        <div class="tpud-sftree" id="tpudSFtree">
            <span class="tpud-sftree-root" id="tpudSFtreeRoot"><?= htmlspecialchars($MemberName ?: $username) ?></span>
            <?php renderSpilloverLevel($spillover_tree, $user_id, 1); ?>
        </div>
        <script>
            (function() {
                function wireUp() {
                    document.getElementById("tpudSFtreeRoot")?.addEventListener("click", function() {
                        document.getElementById("tpudSFtree")?.classList.toggle("open");
                    });

                    document.querySelectorAll("#tpudSFtree li.tpud-sf-node > span").forEach(function(span) {
                        span.addEventListener("click", function(e) {
                            e.stopPropagation();
                            this.parentElement.classList.toggle("open");
                        });
                    });

                    document.getElementById("tpudSFtreeToggleAll")?.addEventListener("click", function() {
                        var treeEl = document.getElementById("tpudSFtree");
                        var isOpen = treeEl.classList.contains("open");
                        var nodes = treeEl.querySelectorAll("li.tpud-sf-node");

                        if (isOpen) {
                            treeEl.classList.remove("open");
                            nodes.forEach(function(li) {
                                li.classList.remove("open");
                            });
                            this.textContent = "Hiển thị tất cả";
                        } else {
                            treeEl.classList.add("open");
                            nodes.forEach(function(li) {
                                li.classList.add("open");
                            });
                            this.textContent = "Thu gọn tất cả";
                        }
                    });

                    document.querySelectorAll("#tpudSFtree .tpud-sf-empty-slot").forEach(function(slot) {
                        slot.addEventListener("click", function(e) {
                            e.stopPropagation();
                            document.getElementById("spillover_parent_id").value = this.dataset.parent;
                            document.getElementById("spillover_position").value = this.dataset.position;
                            document.getElementById("spillover-slot-label").innerText =
                                "Xếp vào: Tầng F" + this.dataset.level + " - vị trí " + this.dataset.position;
                            document.getElementById("spillover-alert").classList.add("d-none");
                            $("#spilloverPlaceModal").modal("show");
                        });
                    });

                    document.getElementById("spilloverPlaceForm")?.addEventListener("submit", function(e) {
                        e.preventDefault();
                        const alertBox = document.getElementById("spillover-alert");
                        const formData = new FormData(this);
                        fetch("/?m=user&f=xu_ly_xep_tang", {
                                method: "POST",
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.ok) {
                                    alertBox.className = "alert alert-success";
                                    alertBox.innerText = "Xếp vị trí thành công.";
                                    alertBox.classList.remove("d-none");
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 1200);
                                } else {
                                    alertBox.className = "alert alert-danger";
                                    alertBox.innerText = data.error || "Có lỗi xảy ra.";
                                    alertBox.classList.remove("d-none");
                                }
                            })
                            .catch(function() {
                                alertBox.className = "alert alert-danger";
                                alertBox.innerText = "Đã xảy ra lỗi. Vui lòng thử lại.";
                                alertBox.classList.remove("d-none");
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
    </div>

    <!-- Lịch sử hoa hồng điều tầng + thưởng -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <div class="tpud-section-head">
            <h4 style="font-size:15px;">Lịch sử hoa hồng điều tầng &amp; thưởng</h4>
        </div>

        <form method="get" style="display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end; margin-bottom:16px;">
            <input type="hidden" name="m" value="user">
            <input type="hidden" name="f" value="cay_dieu_tang">
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Loại</label>
                <select name="type" class="form-control" style="min-width:170px;">
                    <option value="">Tất cả</option>
                    <?php foreach ($sf_type_label as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $sf_filter_type === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Trạng thái</label>
                <select name="status" class="form-control" style="min-width:130px;">
                    <option value="">Tất cả</option>
                    <?php foreach ($sf_status_label as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $sf_filter_status === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Thế Hệ</label>
                <select name="level" class="form-control" style="min-width:100px;">
                    <option value="">Tất cả</option>
                    <?php for ($lv = 1; $lv <= 9; $lv++): ?>
                        <option value="<?= $lv ?>" <?= $sf_filter_level === (string) $lv ? 'selected' : '' ?>>F<?= $lv ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Từ ngày</label>
                <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($sf_filter_from) ?>">
            </div>
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Đến ngày</label>
                <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($sf_filter_to) ?>">
            </div>
            <div style="display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=cay_dieu_tang" class="btn btn-secondary">Xóa lọc</a>
            </div>
        </form>

        <?php if (empty($sf_history)): ?>
            <div class="tpud-empty">Chưa có hoa hồng/thưởng nào</div>
        <?php else: ?>
            <div style="overflow-x:auto;">
                <table class="tpud-table">
                    <thead>
                        <tr>
                            <th>Ngày giờ</th>
                            <th>Loại</th>
                            <th>Thế Hệ</th>
                            <th>Nguồn</th>
                            <th>Số tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sf_history as $h): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($h['created_at'])) ?></td>
                                <td><?= $sf_type_label[$h['type']] ?? $h['type'] ?></td>
                                <td><?= $h['level'] ? 'F' . (int) $h['level'] : '-' ?></td>
                                <td><?= $h['source_name'] !== null ? htmlspecialchars($h['source_name']) : '-' ?></td>
                                <td><?= number_format($h['amount'], 0) ?></td>
                                <td><span class="tpud-badge <?= $sf_status_class[$h['status']] ?? 'tpud-badge-muted' ?>"><?= $sf_status_label[$h['status']] ?? $h['status'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Tổng cộng (toàn bộ)</td>
                            <td colspan="2">Đã nhận: <?= number_format($sf_tong_da_nhan, 0) ?> &nbsp;|&nbsp; Chưa nhận: <?= number_format($sf_tong_chua_nhan, 0) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?php if ($sf_history_total_pages > 1): ?>
                <div style="text-align:center; padding-top:16px;">
                    <ul class="pagination justify-content-center" style="display:inline-flex; list-style:none; gap:4px; padding:0; margin:0;">
                        <?php for ($i = 1; $i <= $sf_history_total_pages; $i++): ?>
                            <li class="page-item <?= $i == $sf_history_page ? 'active' : '' ?>">
                                <a class="page-link" href="<?php echo _DOMAIN_ROOT_URL; ?>/?<?= http_build_query(array_merge($sf_pagination_query, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal xếp vị trí cây điều tầng -->
<div class="modal fade" id="spilloverPlaceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="spilloverPlaceForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xếp vị trí</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="spillover-alert" class="alert d-none" role="alert"></div>
                <p id="spillover-slot-label" style="font-size:14px; color:#6b7280;"></p>
                <input type="hidden" name="parent_id" id="spillover_parent_id">
                <input type="hidden" name="position" id="spillover_position">
                <?php if (empty($spillover_waiting_members)): ?>
                    <div class="tpud-empty">Chưa có ai trong hàng chờ.</div>
                <?php else: ?>
                    <div class="mb-2">
                        <label for="spillover_waiting_select" class="form-label">Chọn thành viên đang chờ xếp</label>
                        <select class="form-control" name="waiting_user_id" id="spillover_waiting_select" required>
                            <?php foreach ($spillover_waiting_members as $w): ?>
                                <option value="<?= (int) $w['user_id'] ?>"><?= htmlspecialchars($w['name']) ?> (<?= htmlspecialchars($w['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" <?= empty($spillover_waiting_members) ? 'disabled' : '' ?>>Xác nhận xếp</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>

<?php include_once("footer.php"); ?>