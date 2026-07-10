<?php
session_start(); // Bắt buộc nếu bạn dùng $_SESSION
$username = getSession("username");
if (!isset($username) || empty($username)) {
    header("Location: /"); // Chuyển hướng về trang chủ
    exit();
}
$hide_slide = true; // Trang tài khoản: hiện menu như bình thường, ẩn ảnh slideshow đầu trang
include_once("header.php");

$user_id = getMemberNameID($username, "id");
$mobile = getMemberNameID($username, "mobile");
$MemberName = getMemberNameID($username, "name");
$Membertknh = getMemberNameID($username, "tknh");
$Membernganhangtknh = getMemberNameID($username, "nganhangtknh");
$business_active = (int) getMemberNameID($username, "business_active");

// ----- Ví (user_wallets) -----
$wallet = ['tong' => 0, 'kha_dung' => 0, 'tieu_dung' => 0, 'tai_tieu_dung' => 0, 'thue_phi' => 0];
$stmt = $mysqli->prepare("SELECT tong, kha_dung, tieu_dung, tai_tieu_dung, thue_phi FROM user_wallets WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($res) $wallet = $res;

// ----- Thẻ tiêu dùng -----
$card_balance = 0;
$stmt = $mysqli->prepare("SELECT balance FROM consumption_cards WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($res) $card_balance = $res['balance'];

// ----- Đếm toàn bộ tuyến dưới (mọi cấp) của 1 user -----
function count_total_downline($mysqli, $user_id)
{
    $ids = [$user_id];
    $total = 0;
    while (!empty($ids)) {
        $in = implode(",", array_map('intval', $ids));
        $res = $mysqli->query("SELECT id FROM user WHERE ref_by IN ($in)");
        $next = [];
        while ($row = $res->fetch_assoc()) $next[] = $row['id'];
        $total += count($next);
        $ids = $next;
    }
    return $total;
}

// ----- Số lượng F1 + tổng tuyến dưới (F2-F9) - dùng cho 3 thẻ thống kê nhanh -----
// Chi tiết từng tầng F1-F9 xem trang riêng "Sơ đồ trực tiếp" (?m=user&f=so_do_truc_tiep).
$stmt = $mysqli->prepare("SELECT COUNT(*) c FROM user WHERE ref_by = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_f1 = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
$stmt->close();

$total_downline = count_total_downline($mysqli, $user_id);
$total_f2_f9 = $total_downline - $total_f1;

// ----- Tổng hoa hồng sơ đồ trực tiếp (tất cả các tầng gộp lại) -----
$stmt = $mysqli->prepare("
    SELECT SUM(c.amount) AS hoa_hong, SUM(o.amount) AS doanh_so
    FROM commissions c
    JOIN orders o ON c.order_id = o.id
    WHERE o.status = 'approved' AND c.user_id = ? AND c.type = 'direct'
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();
$total_hoa_hong = (float) ($row['hoa_hong'] ?? 0);
$total_doanh_so = (float) ($row['doanh_so'] ?? 0);

// ----- Thống kê thu nhập: hoa hồng đã nhận (released, đã cộng ví) vs đang chờ kích hoạt (pending) -----
function sum_commission_by_status($mysqli, $user_id, $status)
{
    $stmt = $mysqli->prepare("SELECT SUM(amount) AS total FROM commissions WHERE user_id = ? AND type = 'direct' AND status = ?");
    $stmt->bind_param("is", $user_id, $status);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return (float) ($r['total'] ?? 0);
}
$hoa_hong_da_nhan = sum_commission_by_status($mysqli, $user_id, 'released');
$hoa_hong_dang_cho = sum_commission_by_status($mysqli, $user_id, 'pending');

// ----- Giao dịch ví gần đây (xem đầy đủ tại trang "Lịch sử giao dịch") -----
$wallet_txns = [];
$stmt = $mysqli->prepare("SELECT wallet_type, direction, amount, ref_type, created_at FROM wallet_transactions WHERE user_id = ? ORDER BY id DESC LIMIT 8");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $wallet_txns[] = $row;
$stmt->close();

$wallet_label = ['tong' => 'Ví tổng', 'kha_dung' => 'Ví khả dụng', 'tieu_dung' => 'Ví tiêu dùng', 'tai_tieu_dung' => 'Ví tái tiêu dùng', 'thue_phi' => 'Ví thuế, phí'];
$ref_type_label = ['order' => 'Thanh toán đơn hàng', 'commission' => 'Hoa hồng', 'withdraw' => 'Rút tiền', 'rebuy' => 'Tái tiêu dùng', 'refund' => 'Hoàn tiền', 'rank_bonus' => 'Thưởng danh hiệu', 'card_bonus' => 'Thẻ tiêu dùng tuần hoàn', 'admin_adjust' => 'Điều chỉnh'];

// ----- Lịch sử rút tiền gần đây -----
$withdraw_history = [];
$stmt = $mysqli->prepare("SELECT amount, status, created_at FROM transactions WHERE user_id = ? AND type = 'withdraw' ORDER BY id DESC LIMIT 5");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $withdraw_history[] = $row;
$stmt->close();

$withdraw_status_label = ['pending' => 'Đang xử lý', 'approved' => 'Thành công', 'rejected' => 'Từ chối'];
$withdraw_status_class = ['pending' => 'tpud-badge-warning', 'approved' => 'tpud-badge-success', 'rejected' => 'tpud-badge-danger'];

$active_nav = 'dashboard';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css">

<div class="tpud">
    <?php include dirname(__FILE__) . "/_nav.php"; ?>

    <div class="tpud-top">
        <div>
            <h2>Xin chào, <?= htmlspecialchars($MemberName ?: $username) ?> 👋</h2>
            <div class="tpud-sub">
                UID: <strong><?= str_pad($user_id, 6, '0', STR_PAD_LEFT) ?></strong>
                &nbsp;|&nbsp; Kích Hoạt Kinh Doanh:
                <?php if ($business_active): ?>
                    <span class="tpud-badge tpud-badge-success">Đã Kích Hoạt</span>
                <?php else: ?>
                    <span class="tpud-badge tpud-badge-danger">Chưa kích hoạt</span>

                    <p style="margin-top: 10px; color: #f70707; font-size: 14px;">
                        Để trở thành thành viên Kinh doanh của Thuận Phát và nhận quyền lợi, thưởng, vui lòng mua 1 combo Thành Viên
                        <a href="<?php echo _DOMAIN_ROOT_URL; ?>/vn/san-pham/" style="font-size: 20px; color: #007bff; text-decoration: underline;"> tại đây </a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 4 ví -->
    <div class="tpud-grid tpud-grid-4">
        <div class="tpud-card">
            <div class="tpud-card-label">Ví khả dụng</div>
            <div class="tpud-card-value"><?= number_format($wallet['kha_dung'], 0) ?> <small>VND</small></div>
            <?php if ($wallet['kha_dung'] > 0): ?>
                <button type="button" class="tpud-btn tpud-btn-green" data-toggle="modal" data-target="#withdrawModal">Rút tiền</button>
            <?php else: ?>
                <span class="tpud-btn tpud-btn-muted">Số dư không đủ</span>
            <?php endif; ?>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Ví tiêu dùng</div>
            <div class="tpud-card-value"><?= number_format($wallet['tieu_dung'], 0) ?> <small>VND</small></div>
            <a class="tpud-btn tpud-btn-blue" href="<?php echo _DOMAIN_ROOT_URL; ?>/vn/san-pham/">Mua hàng</a>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Ví tái tiêu dùng</div>
            <div class="tpud-card-value"><?= number_format($wallet['tai_tieu_dung'], 0) ?> <small>VND</small></div>
            <span class="tpud-btn tpud-btn-muted" title="Tự động tái tiêu dùng khi đạt 5.000.000đ, tối đa 258.000.000đ">Tái tiêu dùng</span>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Ví thuế, phí</div>
            <div class="tpud-card-value"><?= number_format($wallet['thue_phi'], 0) ?> <small>VND</small></div>
            <span class="tpud-btn tpud-btn-muted" title="Các khoản thuế, phí">Thuế, Phí</span>
        </div>
    </div>

    <!-- Link giới thiệu -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <div class="tpud-card-label">Link giới thiệu của bạn</div>
        <div class="tpud-referral">
            <a id="link_afi" href="<?php echo _DOMAIN_ROOT_URL; ?>/user/<?php echo $mobile; ?>">
                <?php echo _DOMAIN_ROOT_URL; ?>/user/<?php echo $mobile; ?>
            </a>
            <button type="button" id="btn-copy">Sao chép</button>
        </div>
    </div>

    <script>
        document.getElementById('btn-copy').addEventListener('click', function() {
            var linkText = document.getElementById('link_afi').innerText;
            var button = this;

            // Cách copy cổ điển nhưng bao chạy 100% trên mọi thiết bị, không lo lỗi HTTPS
            var textarea = document.createElement('textarea');
            textarea.value = linkText;
            document.body.appendChild(textarea);
            textarea.select();
            textarea.setSelectionRange(0, 99999); // Dành cho điện thoại

            try {
                var successful = document.execCommand('copy');
                if (successful) {
                    // Đổi chữ trên nút thành "Đã sao chép!"
                    var originalText = button.innerHTML;
                    button.innerHTML = "Đã sao chép!";
                    button.disabled = true;

                    // Sau 2 giây đổi lại như cũ
                    setTimeout(function() {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                } else {
                    alert('Không thể copy, hãy copy thủ công');
                }
            } catch (err) {
                alert('Trình duyệt không hỗ trợ copy');
            }

            // Xóa ô text tạm sau khi dùng xong
            document.body.removeChild(textarea);
        });
    </script>

    <!-- 3 thống kê -->
    <div class="tpud-grid tpud-grid-3">
        <div class="tpud-card">
            <div class="tpud-card-label">Điểm tiêu dùng (thẻ)</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($card_balance, 0) ?> điểm</div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Thành viên trực tiếp (F1)</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_f1) ?> thành viên</div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Thành viên F2 - F9</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_f2_f9) ?> thành viên</div>
        </div>
    </div>

    <!-- Thống kê thu nhập -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <div class="tpud-section-head">
            <h4 style="font-size:15px;">Thống kê thu nhập</h4>
            <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=so_do_truc_tiep">Xem chi tiết theo cấp F1-F9 &rarr;</a>
        </div>
        <div class="tpud-hh-row"><span>Tổng thu nhập (ví tổng)</span><strong><?= number_format($wallet['tong'], 0) ?> VND</strong></div>
        <div class="tpud-hh-row"><span>Hoa hồng đã nhận (đã cộng ví)</span><strong><?= number_format($hoa_hong_da_nhan, 0) ?> VND</strong></div>
        <div class="tpud-hh-row"><span>Hoa hồng đang chờ kích hoạt</span><strong><?= number_format($hoa_hong_dang_cho, 0) ?> VND</strong></div>
        <div class="tpud-hh-total"><span>Hoa hồng tổng (doanh số <?= number_format($total_doanh_so, 0) ?> VND)</span><span><?= number_format($total_hoa_hong, 0) ?> VND</span></div>
        <?php if ($hoa_hong_dang_cho > 0 && !$business_active): ?>
            <div style="margin-top:8px; font-size:12px; color:#b45309;">* Hoa hồng đang chờ vì bạn chưa kích hoạt gói 5.000.000đ. Kích hoạt để nhận toàn bộ vào ví.</div>
        <?php endif; ?>
    </div>

    <!-- Giao dịch gần đây + Lịch sử rút tiền -->
    <div class="tpud-grid tpud-grid-2">
        <div class="tpud-card">
            <div class="tpud-section-head">
                <h4 style="font-size:15px;">Giao dịch gần đây</h4>
                <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=lich_su_vi">Xem tất cả &rarr;</a>
            </div>
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
            <?php endif; ?>
        </div>
        <div class="tpud-card">
            <h4 style="margin-bottom:10px; font-size:15px;">Lịch sử rút tiền</h4>
            <?php if (empty($withdraw_history)): ?>
                <div class="tpud-empty">Chưa có yêu cầu rút tiền nào</div>
            <?php else: ?>
                <div style="overflow-x:auto;">
                    <table class="tpud-table">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Số tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($withdraw_history as $w): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($w['created_at'])) ?></td>
                                    <td><?= number_format($w['amount'], 0) ?></td>
                                    <td><span class="tpud-badge <?= $withdraw_status_class[$w['status']] ?? 'tpud-badge-muted' ?>"><?= $withdraw_status_label[$w['status']] ?? $w['status'] ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <div style="text-align:right; margin-top:8px;">
                <a href="#" data-toggle="modal" data-target="#withdrawListModal" style="font-size:13px; color:#2563eb;">Xem tất cả &rarr;</a>
            </div>
        </div>
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
        const totalHoaHong = <?= (float) $wallet['kha_dung'] ?>;
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
                            $('#withdrawModal').modal('hide');
                        }, 3000);
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

<!-- Modal danh sách rút tiền -->
<div class="modal fade" id="withdrawListModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Danh sách giao dịch rút tiền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:10px; right:10px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ngày tạo</th>
                            <th>Số tiền</th>
                            <th>Ngân hàng</th>
                            <th>STK</th>
                            <th>Chủ TK</th>
                            <th>Trạng thái</th>
                            <th>Ngày duyệt</th>
                        </tr>
                    </thead>
                    <tbody id="withdraw-table-body">
                    </tbody>
                </table>
                <div id="withdraw-pagination"></div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadWithdrawList(page = 1) {
        $.ajax({
            url: '/?m=user&f=get_withdraw_list',
            method: 'GET',
            data: {
                page: page
            },
            dataType: 'json',
            success: function(res) {
                $('#withdraw-table-body').html(res.html);
                $('#withdraw-pagination').html(res.pagination);
            },
            error: function() {
                $('#withdraw-table-body').html('<tr><td colspan="8">Lỗi tải dữ liệu</td></tr>');
            }
        });
    }

    $('#withdrawListModal').on('shown.bs.modal', function() {
        loadWithdrawList(1);
    });

    $(document).on('click', '#withdraw-pagination .page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        loadWithdrawList(page);
    });
</script>

<?php include_once("footer.php"); ?>