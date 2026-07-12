<?php
// Trang admin: Quản lý sơ đồ cây điều tầng (toàn hệ thống) - mục 6 BUSINESS_RULES.md.
// - Xem cây điều tầng toàn hệ thống (từ vị trí gốc thật - spillover_tree.parent_id IS NULL) hoặc xem
//   nhánh riêng của 1 thành viên tìm được (giống trang cá nhân modules/user/cay_dieu_tang.php).
// - Danh sách toàn bộ hàng chờ (spillover_waiting_list, không lọc theo sponsor) + cho admin xếp vị trí
//   THAY sponsor thật của từng người chờ (vẫn giới hạn trong tầm với đúng sponsor đó - xem
//   admin80/modules/sodo/xu_ly_xep_tang.php và placeSpilloverMember() trong include/order_commission.php,
//   không đổi ràng buộc nghiệp vụ "chỉ người giới thiệu trực tiếp mới có quyền xếp vị trí").
session_start();

$user_id = (int) ($_GET['user_id'] ?? 0);

$root_user = null;
if ($user_id > 0) {
    $stmt = $mysqli->prepare("SELECT id, name, email FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $root_user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Vị trí gốc thật của cây chung: placeSpilloverMember() luôn lưu parent_id = chính user_id của sponsor cho
// tầng 1 (không có dòng parent_id NULL nào - "vị trí gốc" trong mục 11.2 BUSINESS_RULES.md chỉ là mô tả lý
// thuyết, không khớp cách code hiện tại lưu dữ liệu). Nên "gốc" thực tế là những sponsor đã xếp người khác
// (xuất hiện ở cột parent_id) nhưng bản thân họ chưa từng bị ai xếp (không xuất hiện ở cột user_id).
$system_roots = [];
if (!$root_user) {
    $res = $mysqli->query("
        SELECT DISTINCT st.parent_id AS user_id, u.name, u.email
        FROM spillover_tree st
        JOIN user u ON u.id = st.parent_id
        WHERE st.parent_id NOT IN (SELECT user_id FROM spillover_tree)
        ORDER BY st.parent_id
    ");
    while ($row = $res->fetch_assoc()) $system_roots[] = $row;
}

// Danh sách toàn bộ hàng chờ (toàn hệ thống, không lọc theo sponsor)
$waiting_list = [];
$res = $mysqli->query("
    SELECT w.user_id, u.name, u.email, w.sponsor_id, sp.name AS sponsor_name, sp.email AS sponsor_email, w.created_at
    FROM spillover_waiting_list w
    JOIN user u ON u.id = w.user_id
    JOIN user sp ON sp.id = w.sponsor_id
    WHERE w.placed = 0
    ORDER BY w.created_at ASC
");
while ($row = $res->fetch_assoc()) $waiting_list[] = $row;

include_once("header.php");
?>
<div class="container-fluid py-4">
    <h3 class="mb-4">Quản lý sơ đồ cây điều tầng</h3>

    <div class="card mb-3">
        <div class="card-body">
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <div class="sodo-search-wrap" style="position:relative; width:340px;">
                    <input type="text" id="sodoSearchInput" class="form-control" placeholder="Tìm theo tên / email / SĐT / ID thành viên" autocomplete="off">
                    <div id="sodoSearchDropdown" class="sodo-search-dropdown"></div>
                </div>
                <?php if ($user_id > 0): ?>
                    <a href="?m=sodo&f=dieu_tang" class="btn btn-secondary">Xem toàn hệ thống</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-3">
                <?php if ($root_user): ?>
                    Cây điều tầng của: <?= htmlspecialchars($root_user['name']) ?> (<?= htmlspecialchars($root_user['email']) ?>)
                <?php else: ?>
                    Cây điều tầng toàn hệ thống
                <?php endif; ?>
            </h5>

            <?php if (!$root_user && empty($system_roots)): ?>
                <p class="mb-0">Chưa có thành viên nào được xếp vào cây điều tầng.</p>
            <?php else: ?>
                <div id="sodoSfTree" class="sodo-sf-tree"></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Danh sách hàng chờ xếp tầng (toàn hệ thống)</h5>
            <?php if (empty($waiting_list)): ?>
                <p class="mb-0">Không có ai đang chờ xếp vị trí.</p>
            <?php else: ?>
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr><th>Thành viên chờ</th><th>Người giới thiệu (sponsor)</th><th>Chờ từ</th><th></th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($waiting_list as $w): ?>
                            <tr>
                                <td><?= htmlspecialchars($w['name']) ?><br><small><?= htmlspecialchars($w['email']) ?></small></td>
                                <td><?= htmlspecialchars($w['sponsor_name']) ?><br><small><?= htmlspecialchars($w['sponsor_email']) ?></small></td>
                                <td><?= date('d/m/Y H:i', strtotime($w['created_at'])) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary sodo-assign-btn"
                                        data-waiting-user-id="<?= (int) $w['user_id'] ?>"
                                        data-waiting-name="<?= htmlspecialchars($w['name']) ?>"
                                        data-sponsor-id="<?= (int) $w['sponsor_id'] ?>"
                                        data-sponsor-name="<?= htmlspecialchars($w['sponsor_name']) ?>">Xếp vị trí</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal xếp vị trí thay sponsor -->
<div class="modal fade" id="sodoAssignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sodoAssignTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="sodoAssignAlert" class="alert d-none" role="alert"></div>
                <p class="text-muted">Bấm vào 1 vị trí trống (trong tầm với của sponsor) để xếp thành viên vào đó.</p>
                <div id="sodoAssignTree" class="sodo-sf-tree"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
    .sodo-sf-tree ul { list-style: none; margin: 0; padding-left: 22px; }
    .sodo-sf-tree > ul { padding-left: 0; }
    .sodo-sf-tree li { margin: 4px 0; }
    .sodo-sf-tree .sodo-node { cursor: pointer; padding: 3px 8px; border-radius: 4px; display: inline-block; }
    .sodo-sf-tree .sodo-node:hover { background: #f0f0f0; }
    .sodo-sf-tree .sodo-empty { padding: 3px 8px; border-radius: 4px; display: inline-block; color: #9ca3af; border: 1px dashed #d1d5db; }
    .sodo-sf-tree .sodo-empty.sodo-clickable { cursor: pointer; color: #2563eb; border-color: #2563eb; }
    .sodo-sf-tree .sodo-empty.sodo-clickable:hover { background: #eff6ff; }
    .sodo-sf-tree .sodo-toggle { display: inline-block; width: 16px; text-align: center; color: #6b7280; }
    .sodo-sf-tree .sodo-children { display: none; }
    .sodo-sf-tree > .sodo-children { display: block; }
    .sodo-sf-tree li.open > .sodo-children { display: block; }

    .sodo-search-dropdown { position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; background: #fff; border: 1px solid #d1d5db; border-top: none; border-radius: 0 0 6px 6px; max-height: 320px; overflow-y: auto; display: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .sodo-search-dropdown.show { display: block; }
    .sodo-search-dropdown a { display: block; padding: 8px 12px; text-decoration: none; color: #111; border-bottom: 1px solid #f0f0f0; }
    .sodo-search-dropdown a:last-child { border-bottom: none; }
    .sodo-search-dropdown a:hover { background: #eff6ff; }
    .sodo-search-dropdown a small { color: #6b7280; display: block; }
    .sodo-search-dropdown .sodo-search-empty { padding: 10px 12px; color: #9ca3af; }
</style>
<script>
    (function() {
        function escapeHtml(s) {
            return String(s == null ? '' : s).replace(/[&<>"']/g, function(c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }

        // Render 1 tầng (3 vị trí) của cây điều tầng, lazy-load khi bấm mở node đã có người.
        // mode = 'view' (chỉ xem, ô trống không bấm được) hoặc 'assign' (ô trống bấm được để xếp vị trí).
        function loadLevel(parentId, container, mode, level, onSlotClick) {
            fetch('?m=sodo&f=ajax_dieu_tang_children&parent_id=' + encodeURIComponent(parentId))
                .then(function(res) { return res.json(); })
                .then(function(slots) {
                    var ul = document.createElement('ul');
                    ul.className = 'sodo-children';
                    slots.forEach(function(slot) {
                        var li = document.createElement('li');
                        if (slot.occupied) {
                            var span = document.createElement('span');
                            span.className = 'sodo-node';
                            span.innerHTML = '<span class="sodo-toggle">' + (slot.has_children ? '+' : '·') + '</span> '
                                + '<strong>F' + level + '</strong> | ' + escapeHtml(slot.name) + ' (' + escapeHtml(slot.email) + ')';
                            span.dataset.loaded = '0';
                            li.appendChild(span);
                            span.addEventListener('click', function() {
                                if (span.dataset.loaded === '0') {
                                    span.dataset.loaded = '1';
                                    loadLevel(slot.user_id, li, mode, level + 1, onSlotClick);
                                } else {
                                    li.classList.toggle('open');
                                }
                            });
                        } else {
                            var empty = document.createElement('span');
                            empty.className = 'sodo-empty' + (mode === 'assign' ? ' sodo-clickable' : '');
                            empty.textContent = 'Vị trí trống #' + slot.position;
                            if (mode === 'assign') {
                                empty.addEventListener('click', function() {
                                    onSlotClick(slot.parent_id, slot.position, level);
                                });
                            }
                            li.appendChild(empty);
                        }
                        ul.appendChild(li);
                    });
                    container.appendChild(ul);
                    container.classList.add('open');
                });
        }

        window.sodoLoadLevel = loadLevel;

        <?php if ($root_user): ?>
            loadLevel(<?= (int) $root_user['id'] ?>, document.getElementById('sodoSfTree'), 'view', 1, null);
        <?php elseif (!empty($system_roots)): ?>
            (function() {
                var container = document.getElementById('sodoSfTree');
                <?php foreach ($system_roots as $rootNode): ?>
                    (function() {
                        var li = document.createElement('li');
                        li.style.listStyle = 'none';
                        var span = document.createElement('span');
                        span.className = 'sodo-node';
                        span.innerHTML = '<span class="sodo-toggle">+</span> <?= addslashes(htmlspecialchars($rootNode['name'])) ?> (<?= addslashes(htmlspecialchars($rootNode['email'])) ?>) - Gốc hệ thống';
                        span.dataset.loaded = '0';
                        li.appendChild(span);
                        container.appendChild(li);
                        span.addEventListener('click', function() {
                            if (span.dataset.loaded === '0') {
                                span.dataset.loaded = '1';
                                loadLevel(<?= (int) $rootNode['user_id'] ?>, li, 'view', 1, null);
                            } else {
                                li.classList.toggle('open');
                            }
                        });
                    })();
                <?php endforeach; ?>
            })();
        <?php endif; ?>

        // Modal xếp vị trí thay sponsor
        document.querySelectorAll('.sodo-assign-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var waitingUserId = btn.dataset.waitingUserId;
                var sponsorId = btn.dataset.sponsorId;
                document.getElementById('sodoAssignTitle').textContent =
                    'Xếp "' + btn.dataset.waitingName + '" vào cây của sponsor "' + btn.dataset.sponsorName + '"';
                var alertBox = document.getElementById('sodoAssignAlert');
                alertBox.className = 'alert d-none';
                var treeEl = document.getElementById('sodoAssignTree');
                treeEl.innerHTML = '';

                loadLevel(sponsorId, treeEl, 'assign', 1, function(parentId, position, level) {
                    var confirmMsg = 'Xác nhận xếp "' + btn.dataset.waitingName + '" vào F' + level + ' - vị trí #' + position
                        + ' (trong cây của sponsor "' + btn.dataset.sponsorName + '")?\nThao tác này KHÔNG thể hoàn tác, mỗi thành viên chỉ được xếp vị trí 1 lần duy nhất.';
                    if (!confirm(confirmMsg)) return;

                    var formData = new FormData();
                    formData.append('waiting_user_id', waitingUserId);
                    formData.append('parent_id', parentId);
                    formData.append('position', position);

                    fetch('?m=sodo&f=xu_ly_xep_tang', { method: 'POST', body: formData })
                        .then(function(res) { return res.json(); })
                        .then(function(data) {
                            if (data.ok) {
                                alertBox.className = 'alert alert-success';
                                alertBox.textContent = 'Xếp vị trí thành công.';
                                setTimeout(function() { window.location.reload(); }, 1200);
                            } else {
                                alertBox.className = 'alert alert-danger';
                                alertBox.textContent = data.error || 'Có lỗi xảy ra.';
                            }
                        })
                        .catch(function() {
                            alertBox.className = 'alert alert-danger';
                            alertBox.textContent = 'Đã xảy ra lỗi. Vui lòng thử lại.';
                        });
                });

                new bootstrap.Modal(document.getElementById('sodoAssignModal')).show();
            });
        });

        // Ô tìm kiếm sổ xuống (gõ tới đâu tìm tới đó, bấm chọn thì chuyển sang xem cây người đó)
        var searchInput = document.getElementById('sodoSearchInput');
        var searchDropdown = document.getElementById('sodoSearchDropdown');
        var searchTimer = null;

        searchInput.addEventListener('input', function() {
            var q = searchInput.value.trim();
            clearTimeout(searchTimer);
            if (q === '') {
                searchDropdown.classList.remove('show');
                return;
            }
            searchTimer = setTimeout(function() {
                fetch('?m=sodo&f=ajax_search_user&q=' + encodeURIComponent(q))
                    .then(function(res) { return res.json(); })
                    .then(function(list) {
                        searchDropdown.innerHTML = '';
                        if (list.length === 0) {
                            searchDropdown.innerHTML = '<div class="sodo-search-empty">Không tìm thấy thành viên phù hợp.</div>';
                        } else {
                            list.forEach(function(r) {
                                var a = document.createElement('a');
                                a.href = '?m=sodo&f=dieu_tang&user_id=' + r.id;
                                a.innerHTML = escapeHtml(r.name) + ' <small>' + escapeHtml(r.email) + (r.mobile ? ' - ' + escapeHtml(r.mobile) : '') + ' (ID ' + r.id + ')</small>';
                                searchDropdown.appendChild(a);
                            });
                        }
                        searchDropdown.classList.add('show');
                    });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.sodo-search-wrap')) searchDropdown.classList.remove('show');
        });
    })();
</script>

<?php include_once("footer.php"); ?>
