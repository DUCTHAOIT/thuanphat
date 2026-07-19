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
$wallet = ['tong' => 0, 'kha_dung' => 0, 'tieu_dung' => 0, 'tai_tieu_dung' => 0, 'thue_phi' => 0, 'tich_luy_tieu_dung' => 0];
$stmt = $mysqli->prepare("SELECT tong, kha_dung, tieu_dung, tai_tieu_dung, thue_phi, tich_luy_tieu_dung FROM user_wallets WHERE user_id = ?");
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

// ----- Số lượng F1 + tổng tuyến dưới (không giới hạn tầng) - dùng cho 3 thẻ thống kê nhanh -----
// Chi tiết từng tầng F1-F8 (hoa hồng trực tiếp) xem trang riêng "Sơ đồ trực tiếp" (?m=user&f=so_do_truc_tiep).
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

// ----- Thống kê thu nhập: đã nhận (released, đã cộng ví) vs chưa nhận (pending, chờ business_active) -----
// Hoa hồng trực tiếp (mục 4 BUSINESS_RULES.md) luôn released ngay, không bao giờ pending.
// Hoa hồng điều tầng + thưởng danh hiệu (bảng commissions) và Tích lũy tiêu dùng (bảng
// accumulated_consumption_bonuses, cập nhật 2026-07-13 - đổi tên từ "thưởng điểm thẻ tiêu dùng") thì
// pending/released theo commission_active (mục 5).
function sum_commission_by_status($mysqli, $user_id, $type, $status)
{
    $stmt = $mysqli->prepare("SELECT SUM(amount) AS total FROM commissions WHERE user_id = ? AND type = ? AND status = ?");
    $stmt->bind_param("iss", $user_id, $type, $status);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return (float) ($r['total'] ?? 0);
}
function sum_accumulated_consumption_bonus_by_status($mysqli, $user_id, $status)
{
    $stmt = $mysqli->prepare("SELECT SUM(amount) AS total FROM accumulated_consumption_bonuses WHERE user_id = ? AND status = ?");
    $stmt->bind_param("is", $user_id, $status);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return (float) ($r['total'] ?? 0);
}

$hoa_hong_truc_tiep_da_nhan = sum_commission_by_status($mysqli, $user_id, 'direct', 'released');
$hoa_hong_truc_tiep_chua_nhan = sum_commission_by_status($mysqli, $user_id, 'direct', 'pending'); // luôn = 0 theo mục 4

$hoa_hong_dieu_tang_da_nhan = sum_commission_by_status($mysqli, $user_id, 'spillover', 'released');
$hoa_hong_dieu_tang_chua_nhan = sum_commission_by_status($mysqli, $user_id, 'spillover', 'pending');

$thuong_danh_hieu_da_nhan = sum_commission_by_status($mysqli, $user_id, 'rank_bonus', 'released');
$thuong_danh_hieu_chua_nhan = sum_commission_by_status($mysqli, $user_id, 'rank_bonus', 'pending');

$tich_luy_tieu_dung_da_nhan = sum_accumulated_consumption_bonus_by_status($mysqli, $user_id, 'released');
$tich_luy_tieu_dung_chua_nhan = sum_accumulated_consumption_bonus_by_status($mysqli, $user_id, 'pending');

$thu_nhap_rows = [
    ['label' => 'Hoa hồng trực tiếp (F1-F8)', 'da_nhan' => $hoa_hong_truc_tiep_da_nhan, 'chua_nhan' => $hoa_hong_truc_tiep_chua_nhan],
    ['label' => 'Hoa hồng điều tầng (cây điều tầng)', 'da_nhan' => $hoa_hong_dieu_tang_da_nhan, 'chua_nhan' => $hoa_hong_dieu_tang_chua_nhan],
    ['label' => 'Thưởng danh hiệu', 'da_nhan' => $thuong_danh_hieu_da_nhan, 'chua_nhan' => $thuong_danh_hieu_chua_nhan],
    ['label' => 'Tích lũy tiêu dùng', 'da_nhan' => $tich_luy_tieu_dung_da_nhan, 'chua_nhan' => $tich_luy_tieu_dung_chua_nhan],
];
$tong_da_nhan = array_sum(array_column($thu_nhap_rows, 'da_nhan'));
$tong_chua_nhan = array_sum(array_column($thu_nhap_rows, 'chua_nhan'));

$active_nav = 'dashboard';
?>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL; ?>/modules/user/dashboard.css?v=<?php echo @filemtime(dirname(__FILE__) . '/dashboard.css'); ?>">

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
                        Để trở thành thành viên Kinh doanh để nhận quyền lợi, và chính sách thưởng của Thuận Phát, vui lòng mua 1 combo Thành Viên
                        <a href="<?php echo _DOMAIN_ROOT_URL; ?>/vn/san-pham/" style="font-size: 18px; color: #007bff; text-decoration: underline;"> tại đây </a>
                    </p>
                <?php endif; ?>
            </div>
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
            <a class="tpud-btn tpud-btn-blue" href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=lich_su_tai_tieu_dung" title="Tự động tái tiêu dùng khi đạt 5.000.000đ, tối đa 258.000.000đ">Chi tiết</a>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Ví thuế, phí</div>
            <div class="tpud-card-value"><?= number_format($wallet['thue_phi'], 0) ?> <small>VND</small></div>
            <span class="tpud-btn tpud-btn-muted" title="Các khoản thuế, phí">Thuế, Phí</span>
        </div>
    </div>


    <!-- 4 thống kê -->
    <div class="tpud-grid tpud-grid-4">
        <div class="tpud-card">
            <div class="tpud-card-label">Điểm tiêu dùng (thẻ)</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($card_balance, 0) ?> điểm</div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Ví Tích lũy tiêu dùng</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($wallet['tich_luy_tieu_dung'], 0) ?> VND</div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Thành viên trực tiếp (F1)</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_f1) ?> thành viên</div>
        </div>
        <div class="tpud-card">
            <div class="tpud-card-label">Thành viên F2 - F8</div>
            <div class="tpud-card-value" style="margin-bottom:0"><?= number_format($total_f2_f9) ?> thành viên</div>
        </div>
    </div>

    <!-- Thống kê thu nhập -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <div class="tpud-section-head">
            <h4 style="font-size:15px;">Thống kê thu nhập</h4>
            <a href="<?php echo _DOMAIN_ROOT_URL; ?>/?m=user&f=so_do_truc_tiep">Xem chi tiết theo cấp F1-F8 &rarr;</a>
        </div>
        <div style="padding:9px 0;">Tổng thu nhập: <strong><?= number_format($wallet['tong'], 0) ?> VND</strong></div>
        <div style="padding:0 0 9px;">Doanh số (hoa hồng trực tiếp): <strong><?= number_format($total_doanh_so, 0) ?> VND</strong></div>
        <div style="overflow-x:auto; margin-top:10px;">
            <table class="tpud-table">
                <thead>
                    <tr>
                        <th>Khoản thu nhập</th>
                        <th>Đã nhận</th>
                        <th>Chưa nhận</th>
                        <th>Tổng cộng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($thu_nhap_rows as $r): ?>
                        <tr>
                            <td><?= $r['label'] ?></td>
                            <td><?= number_format($r['da_nhan'], 0) ?></td>
                            <td><?= number_format($r['chua_nhan'], 0) ?></td>
                            <td><?= number_format($r['da_nhan'] + $r['chua_nhan'], 0) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Tổng cộng</td>
                        <td><?= number_format($tong_da_nhan, 0) ?></td>
                        <td><?= number_format($tong_chua_nhan, 0) ?></td>
                        <td><?= number_format($tong_da_nhan + $tong_chua_nhan, 0) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php if ($tong_chua_nhan > 0 && !$business_active): ?>
            <div style="margin-top:4px; font-size:13px; color:#b45309;">* Có khoản đang chờ vì bạn chưa kích hoạt gói 5.000.000đ. Kích hoạt để nhận toàn bộ vào ví/điểm thẻ.</div>
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
                    <input type="number" class="form-control" name="amount" id="amount" min="100000" required>
                    <small class="form-text text-muted">Số tiền rút tối thiểu 100.000đ/lần.</small>
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
                        <div style="margin-top:10px;">
                            <a href="/?m=user&f=lich_su_rut_tien" class="btn btn-sm btn-secondary">Xem / hủy yêu cầu tại Lịch sử rút tiền</a>
                        </div>
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

            if (amount < 100000) {
                alertBox.className = 'alert alert-danger';
                alertBox.innerText = 'Số tiền rút tối thiểu là 100.000đ.';
                alertBox.classList.remove('d-none');
                return;
            }

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