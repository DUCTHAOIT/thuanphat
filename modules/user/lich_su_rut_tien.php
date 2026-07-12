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
$Membertknh = getMemberNameID($username, "tknh");
$Membernganhangtknh = getMemberNameID($username, "nganhangtknh");

// ----- Ví khả dụng (user_wallets.kha_dung) - số dư hiện tại, dùng rút tiền -----
$wallet_kha_dung = 0;
$stmt = $mysqli->prepare("SELECT kha_dung FROM user_wallets WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($res) $wallet_kha_dung = (float) $res['kha_dung'];

$withdraw_status_label = ['pending' => 'Đang xử lý', 'approved' => 'Thành công', 'rejected' => 'Từ chối', 'cancelled' => 'Đã Huỷ'];
$withdraw_status_class = ['pending' => 'tpud-badge-warning', 'approved' => 'tpud-badge-success', 'rejected' => 'tpud-badge-danger', 'cancelled' => 'tpud-badge-muted'];

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
$filter_status = trim($_GET['status'] ?? '');
$filter_from = trim($_GET['from'] ?? '');
$filter_to = trim($_GET['to'] ?? '');

if (!array_key_exists($filter_status, $withdraw_status_label)) $filter_status = '';

$where = ["user_id = ?", "type = 'withdraw'"];
$params = [$user_id];
$types = "i";

if ($filter_status !== '') {
    $where[] = "status = ?";
    $params[] = $filter_status;
    $types .= "s";
}
if ($filter_from !== '') {
    $where[] = "created_at >= ?";
    $params[] = $filter_from . " 00:00:00";
    $types .= "s";
}
if ($filter_to !== '') {
    $where[] = "created_at <= ?";
    $params[] = $filter_to . " 23:59:59";
    $types .= "s";
}

$whereSql = implode(" AND ", $where);

$limit = 20;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// Bảng transactions chỉ dùng cho nghiệp vụ Rút tiền (mục 9 BUSINESS_RULES.md)
$stmt = $mysqli->prepare("SELECT COUNT(*) c FROM transactions WHERE $whereSql");
bindParamsArray($stmt, $types, $params);
$stmt->execute();
$total = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
$stmt->close();
$total_pages = (int) ceil($total / $limit);

$listParams = $params;
$listParams[] = $limit;
$listParams[] = $offset;
$listTypes = $types . "ii";

$withdraw_history = [];
$stmt = $mysqli->prepare("SELECT id, amount, bank_name, bank_account_number, bank_account_holder, status, created_at, updated_at FROM transactions WHERE $whereSql ORDER BY id DESC LIMIT ? OFFSET ?");
bindParamsArray($stmt, $listTypes, $listParams);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $withdraw_history[] = $row;
$stmt->close();

// Giữ nguyên các filter đang chọn khi bấm số trang
$pagination_query = $_GET;
unset($pagination_query['page']);

$active_nav = 'lich_su_rut_tien';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css?v=<?php echo @filemtime(dirname(__FILE__) . '/dashboard.css'); ?>">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <!-- Ví khả dụng: số dư hiện tại + nút rút tiền (ô nhỏ, gọn) -->
    <div class="tpud-card" style="display:inline-flex; align-items:center; gap:28px; margin-bottom:16px; padding:20px 32px; width:auto;">
        <div>
            <div style="font-size:16px; color:#6b7280;">Ví khả dụng</div>
            <div style="font-size:34px; font-weight:700;"><?= number_format($wallet_kha_dung, 0) ?> <small style="font-size:18px; font-weight:500; color:#6b7280;">VND</small></div>
        </div>
        <?php if ($wallet_kha_dung > 0): ?>
            <button type="button" class="tpud-btn tpud-btn-green" style="width:auto; padding:14px 32px; font-size:18px;" data-toggle="modal" data-target="#withdrawModal">Rút tiền</button>
        <?php else: ?>
            <span class="tpud-btn tpud-btn-muted" style="width:auto; padding:14px 32px; font-size:18px;">Số dư không đủ</span>
        <?php endif; ?>
    </div>

    <div class="tpud-top">
        <div>
            <h2>Lịch sử rút tiền</h2>
            <div class="tpud-sub">Toàn bộ yêu cầu rút tiền về ngân hàng của bạn</div>
        </div>
    </div>

    <div class="tpud-card" style="margin-bottom:20px;">
        <form method="get" style="display:flex; flex-wrap:wrap; gap:10px; align-items:flex-end;">
            <input type="hidden" name="m" value="user">
            <input type="hidden" name="f" value="lich_su_rut_tien">
            <div>
                <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:4px;">Trạng thái</label>
                <select name="status" class="form-control" style="min-width:150px;">
                    <option value="">Tất cả</option>
                    <?php foreach ($withdraw_status_label as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $filter_status === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
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
                <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=lich_su_rut_tien" class="btn btn-secondary">Xóa lọc</a>
            </div>
        </form>
    </div>

    <div class="tpud-card">
        <?php if (empty($withdraw_history)): ?>
            <div class="tpud-empty">Không tìm thấy yêu cầu rút tiền nào</div>
        <?php else: ?>
            <div style="overflow-x:auto;">
                <table class="tpud-table">
                    <thead>
                        <tr>
                            <th>Ngày tạo</th>
                            <th>Số tiền</th>
                            <th>Ngân hàng</th>
                            <th>STK</th>
                            <th>Chủ TK</th>
                            <th>Trạng thái</th>
                            <th>Ngày duyệt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($withdraw_history as $w): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($w['created_at'])) ?></td>
                                <td><?= number_format($w['amount'], 0) ?></td>
                                <td><?= htmlspecialchars($w['bank_name']) ?></td>
                                <td><?= htmlspecialchars($w['bank_account_number']) ?></td>
                                <td><?= htmlspecialchars($w['bank_account_holder']) ?></td>
                                <td><span class="tpud-badge <?= $withdraw_status_class[$w['status']] ?? 'tpud-badge-muted' ?>"><?= $withdraw_status_label[$w['status']] ?? $w['status'] ?></span></td>
                                <td><?= $w['status'] === 'pending' ? '-' : date('d/m/Y H:i', strtotime($w['updated_at'])) ?></td>
                                <td>
                                    <?php if ($w['status'] === 'pending'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-cancel-withdraw-row" data-id="<?= (int) $w['id'] ?>" style="white-space:nowrap;">Hủy</button>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
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

<!-- Modal Rút tiền -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="withdrawForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yêu cầu rút tiền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="withdraw-alert" class="alert d-none" role="alert"></div>

                <div class="mb-2">
                    <label for="amount" class="form-label">Số tiền</label>
                    <input type="number" class="form-control" name="amount" id="amount" required>
                </div>
                <div class="mb-2">
                    <label for="bank_name" class="form-label">Tên ngân hàng</label>
                    <input type="text" class="form-control" value="<?= $Membernganhangtknh ?>" name="bank_name" required>
                </div>
                <div class="mb-2">
                    <label for="bank_account_number" class="form-label">Số tài khoản</label>
                    <input type="text" class="form-control" value="<?= $Membertknh ?>" name="bank_account_number" required>
                </div>
                <div class="mb-2">
                    <label for="bank_account_holder" class="form-label">Tên chủ tài khoản</label>
                    <input type="text" class="form-control" value="<?= $MemberName ?>" readonly name="bank_account_holder" required>
                </div>
                <div class="mb-2">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea class="form-control" name="note"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const totalHoaHong = <?= (float) $wallet_kha_dung ?>;
        const form = document.getElementById('withdrawForm');
        const alertBox = document.getElementById('withdraw-alert');

        $(document).ready(function() {
            const form = $('#withdrawForm');
            const alertBox = $('#withdraw-alert');

            $('#withdrawModal').on('show.bs.modal', function() {
                fetch('/?m=user&f=check_withdraw_pending')
                    .then(res => res.json())
                    .then(data => {
                        if (data.pending) {
                            let html = `
                        <strong>Bạn đã có 1 yêu cầu rút tiền đang chờ duyệt.</strong><br>
                        <b>Mã lệnh:</b> #${data.id}<br>
                        <b>Số tiền:</b> ${data.amount}<br>
                        <b>Ngày tạo:</b> ${data.created_at}<br>
                        <b>Trạng thái:</b> ${data.status}<br>
                        <strong>Vui lòng chờ xử lý trước khi tạo yêu cầu mới.</strong>
                        <div style="margin-top:6px; font-size:13px; color:#6b7280;">Bạn có thể hủy yêu cầu này ở bảng lịch sử bên dưới (cột "Thao tác").</div>
                    `;
                            alertBox.removeClass('d-none alert-success alert-danger')
                                .addClass('alert-warning')
                                .html(html);
                            form.find('.modal-body > div').not('#withdraw-alert').hide();
                            form.find('.modal-footer').hide();
                        } else {
                            alertBox.addClass('d-none').text('');
                            form.find('.modal-body > div').show();
                            form.find('.modal-footer').show();
                        }
                    })
                    .catch(err => console.error(err));
            });
        });

        // Hủy yêu cầu rút tiền ngay tại hàng trong bảng lịch sử (mục 7 BUSINESS_RULES.md) - dễ thao tác hơn
        // so với đặt trong modal. Event delegation trên document vì các nút này render từ PHP lúc tải trang.
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-cancel-withdraw-row');
            if (!btn) return;

            if (!confirm('Bạn có chắc muốn hủy yêu cầu rút tiền này?')) return;
            const txId = btn.getAttribute('data-id');
            btn.disabled = true;
            btn.textContent = 'Đang hủy...';

            fetch('/?m=user&f=huy_rut_tien', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'transaction_id=' + encodeURIComponent(txId)
                })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        location.reload();
                    } else {
                        alert(data);
                        btn.disabled = false;
                        btn.textContent = 'Hủy';
                    }
                })
                .catch(() => {
                    alert('Đã xảy ra lỗi. Vui lòng thử lại.');
                    btn.disabled = false;
                    btn.textContent = 'Hủy';
                });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const amount = parseFloat(form.amount.value);

            if (amount > totalHoaHong) {
                alertBox.className = 'alert alert-danger';
                alertBox.innerText = 'Số tiền vượt quá số dư ví khả dụng.';
                alertBox.classList.remove('d-none');
                return;
            }

            const formData = new FormData(form);
            fetch('/?m=user&f=xu_ly_rut_tien', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        alertBox.className = 'alert alert-success';
                        alertBox.innerText = 'Yêu cầu rút tiền đã được gửi.';
                        alertBox.classList.remove('d-none');
                        form.reset();
                        Array.from(form.elements).forEach(el => {
                            if (el.tagName !== "BUTTON") {
                                el.parentElement.style.display = 'none';
                            }
                        });
                        const footer = form.querySelector('.modal-footer');
                        if (footer) footer.style.display = 'none';
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        alertBox.className = 'alert alert-danger';
                        alertBox.innerText = data;
                        alertBox.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    alertBox.className = 'alert alert-danger';
                    alertBox.innerText = 'Đã xảy ra lỗi. Vui lòng thử lại.';
                    alertBox.classList.remove('d-none');
                });
        });
    });
</script>

<?php include_once("footer.php"); ?>
