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
            echo "<span class='tpud-sf-empty-slot' data-parent='{$parentUserId}' data-position='{$pos}' data-level='{$level}'>+ Ô trống - Tầng F{$level} - vị trí {$pos}</span>";
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

$active_nav = 'cay_dieu_tang';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <div class="tpud-top">
        <div>
            <h2>Cây điều tầng</h2>
            <div class="tpud-sub">Sơ đồ lấp tầng (1 ra 3) và danh sách thành viên đang chờ bạn xếp vị trí</div>
        </div>
    </div>

    <div class="tpud-card" style="margin-bottom:20px;">
        <p style="font-size:13px; color:#6b7280; margin-bottom:10px;">
            Đã xếp: <strong><?= number_format($spillover_placed_count) ?></strong> thành viên
            &nbsp;|&nbsp; Đang chờ bạn xếp: <strong><?= number_format(count($spillover_waiting_members)) ?></strong> người
        </p>

        <?php if (!empty($spillover_waiting_members)): ?>
            <div style="margin-bottom:14px;">
                <strong style="font-size:13px;">Danh sách chờ xếp tầng:</strong>
                <ul style="margin:6px 0 0; padding-left:18px; font-size:13px;">
                    <?php foreach ($spillover_waiting_members as $w): ?>
                        <li><?= htmlspecialchars($w['name']) ?> (<?= htmlspecialchars($w['email']) ?>) - chờ từ <?= date('d/m/Y', strtotime($w['created_at'])) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

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
                <p id="spillover-slot-label" style="font-size:13px; color:#6b7280;"></p>
                <input type="hidden" name="parent_id" id="spillover_parent_id">
                <input type="hidden" name="position" id="spillover_position">
                <?php if (empty($spillover_waiting_members)): ?>
                    <div class="tpud-empty">Chưa có ai đang chờ bạn xếp tầng.</div>
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
