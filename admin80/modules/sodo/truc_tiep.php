<?php
// Trang admin: Quản lý sơ đồ cây trực tiếp (toàn hệ thống) - mục 4 BUSINESS_RULES.md.
// Cây trực tiếp đệ quy theo user.ref_by. Thành viên không có người giới thiệu (ref_by IS NULL) hiển thị
// là F1 của "Root" (khái niệm hiển thị, không phải 1 dòng thật trong bảng user).
// Cây load kiểu lazy (AJAX) qua ajax_truc_tiep_children.php để tránh nặng trang khi hệ thống nhiều thành
// viên - xem admin80/modules/sodo/ajax_truc_tiep_children.php.
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

include_once("header.php");
?>
<div class="container-fluid py-4">
    <h3 class="mb-4">Quản lý sơ đồ cây trực tiếp</h3>

    <div class="card mb-3">
        <div class="card-body">
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <div class="sodo-search-wrap" style="position:relative; width:340px;">
                    <input type="text" id="sodoSearchInput" class="form-control" placeholder="Tìm theo tên / email / SĐT / ID thành viên" autocomplete="off">
                    <div id="sodoSearchDropdown" class="sodo-search-dropdown"></div>
                </div>
                <?php if ($user_id > 0): ?>
                    <a href="?m=sodo&f=truc_tiep" class="btn btn-secondary">Xem toàn hệ thống (Root)</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">
                <?php if ($root_user): ?>
                    Cây trực tiếp của: <?= htmlspecialchars($root_user['name']) ?> (<?= htmlspecialchars($root_user['email']) ?>)
                <?php else: ?>
                    Cây trực tiếp toàn hệ thống (Root)
                <?php endif; ?>
            </h5>
            <div id="sodoTree" class="sodo-tree"></div>
        </div>
    </div>
</div>

<style>
    .sodo-tree ul { list-style: none; margin: 0; padding-left: 22px; }
    .sodo-tree > ul { padding-left: 0; }
    .sodo-tree li { margin: 4px 0; }
    .sodo-tree .sodo-node { cursor: pointer; padding: 3px 8px; border-radius: 4px; display: inline-block; }
    .sodo-tree .sodo-node:hover { background: #f0f0f0; }
    .sodo-tree .sodo-node.active { color: #6b7280; }
    .sodo-tree .sodo-toggle { display: inline-block; width: 16px; text-align: center; color: #6b7280; }
    .sodo-tree .sodo-children { display: none; }
    .sodo-tree > .sodo-children { display: block; }
    .sodo-tree li.open > .sodo-children { display: block; }

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
        function label(node, level) {
            var badge = node.business_active == 1
                ? '<span class="badge ms-1" style="background:#28a745; color:#fff;">Active</span>'
                : '<span class="badge ms-1" style="background:#6c757d; color:#fff;">Chưa active</span>';
            var sales = 'Doanh số: ' + Number(node.sales || 0).toLocaleString('vi-VN') + 'đ';
            return '<span class="sodo-toggle">' + (node.has_children ? '+' : '  ') + '</span> '
                + '<strong>F' + level + '</strong> | ' + escapeHtml(node.name) + ' (' + escapeHtml(node.email) + ') - ' + sales + ' ' + badge;
        }

        function escapeHtml(s) {
            return String(s == null ? '' : s).replace(/[&<>"']/g, function(c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }

        function loadChildren(parentId, container, level, cb) {
            fetch('?m=sodo&f=ajax_truc_tiep_children&parent_id=' + encodeURIComponent(parentId))
                .then(function(res) { return res.json(); })
                .then(function(list) {
                    var ul = document.createElement('ul');
                    ul.className = 'sodo-children';
                    if (list.length === 0) {
                        ul.innerHTML = '<li><em>Chưa có F1</em></li>';
                    } else {
                        list.forEach(function(node) {
                            var li = document.createElement('li');
                            var span = document.createElement('span');
                            span.className = 'sodo-node';
                            span.innerHTML = label(node, level);
                            span.dataset.userId = node.id;
                            span.dataset.loaded = '0';
                            li.appendChild(span);
                            ul.appendChild(li);

                            span.addEventListener('click', function() {
                                if (!node.has_children) return;
                                if (span.dataset.loaded === '0') {
                                    span.dataset.loaded = '1';
                                    loadChildren(node.id, li, level + 1);
                                } else {
                                    li.classList.toggle('open');
                                }
                            });
                        });
                    }
                    container.appendChild(ul);
                    container.classList.add('open');
                    if (cb) cb();
                });
        }

        var rootId = <?= $root_user ? (int) $root_user['id'] : 0 ?>;
        var treeEl = document.getElementById('sodoTree');
        loadChildren(rootId, treeEl, 1);

        // Ô tìm kiếm sổ xuống (gõ tới đâu tìm tới đó, bấm chọn thì chuyển sang xem cây người đó)
        var searchInput = document.getElementById('sodoSearchInput');
        var dropdown = document.getElementById('sodoSearchDropdown');
        var searchTimer = null;

        searchInput.addEventListener('input', function() {
            var q = searchInput.value.trim();
            clearTimeout(searchTimer);
            if (q === '') {
                dropdown.classList.remove('show');
                return;
            }
            searchTimer = setTimeout(function() {
                fetch('?m=sodo&f=ajax_search_user&q=' + encodeURIComponent(q))
                    .then(function(res) { return res.json(); })
                    .then(function(list) {
                        dropdown.innerHTML = '';
                        if (list.length === 0) {
                            dropdown.innerHTML = '<div class="sodo-search-empty">Không tìm thấy thành viên phù hợp.</div>';
                        } else {
                            list.forEach(function(r) {
                                var a = document.createElement('a');
                                a.href = '?m=sodo&f=truc_tiep&user_id=' + r.id;
                                a.innerHTML = escapeHtml(r.name) + ' <small>' + escapeHtml(r.email) + (r.mobile ? ' - ' + escapeHtml(r.mobile) : '') + ' (ID ' + r.id + ')</small>';
                                dropdown.appendChild(a);
                            });
                        }
                        dropdown.classList.add('show');
                    });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.sodo-search-wrap')) dropdown.classList.remove('show');
        });
    })();
</script>

<?php include_once("footer.php"); ?>
