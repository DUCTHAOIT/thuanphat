<?php
session_start(); // Bắt buộc nếu bạn dùng $_SESSION
$username = getSession("username");
if (!isset($username) || empty($username)) {
    header("Location: /"); // Chuyển hướng về trang chủ
    exit();
}
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

// ----- Cây sơ đồ trực tiếp (toàn bộ tuyến dưới, đệ quy theo ref_by - mục 3 BUSINESS_RULES.md) -----
function getUserTree($mysqli, $user_id, $level = 1) {
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

function sumSales($tree) {
    $sum = 0;
    foreach ($tree as $node) {
        $sum += $node['sales'];
        if (!empty($node['children'])) $sum += sumSales($node['children']);
    }
    return $sum;
}

function countUsers($tree) {
    $count = 0;
    foreach ($tree as $node) {
        $count += 1;
        if (!empty($node['children'])) $count += countUsers($node['children']);
    }
    return $count;
}

function renderTree($tree) {
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

// ----- Cây lấp tầng (chưa có luồng xếp tầng nên chỉ hiển thị số liệu thật hiện có) -----
$stmt = $mysqli->prepare("SELECT COUNT(*) c FROM spillover_waiting_list WHERE sponsor_id = ? AND placed = 0");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$spillover_waiting_count = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
$stmt->close();

$stmt = $mysqli->prepare("SELECT COUNT(*) c FROM spillover_tree WHERE sponsor_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$spillover_placed_count = (int) ($stmt->get_result()->fetch_assoc()['c'] ?? 0);
$stmt->close();

// ----- Giao dịch ví gần đây -----
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
?>
<style>
    .tpud {
        max-width: 1280px;
        margin: 0 auto;
        padding: 20px 15px 60px;
        color: #1f2937;
    }

    .tpud * {
        box-sizing: border-box;
    }

    .tpud h1,
    .tpud h2,
    .tpud h3,
    .tpud h4,
    .tpud h5 {
        color: #1f2937;
        margin: 0;
    }

    .tpud-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .tpud-top h2 {
        font-size: 22px;
        font-weight: 700;
    }

    .tpud-sub {
        color: #6b7280;
        font-size: 14px;
        margin-top: 4px;
    }

    .tpud-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .tpud-badge-success {
        background: #dcfce7;
        color: #15803d;
    }

    .tpud-badge-warning {
        background: #fef3c7;
        color: #b45309;
    }

    .tpud-badge-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .tpud-badge-muted {
        background: #f3f4f6;
        color: #6b7280;
    }

    .tpud-grid {
        display: grid;
        gap: 16px;
        margin-bottom: 20px;
    }

    .tpud-grid-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    .tpud-grid-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .tpud-grid-2 {
        grid-template-columns: 1fr 1fr;
    }

    @media (max-width: 992px) {

        .tpud-grid-4,
        .tpud-grid-3,
        .tpud-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .tpud-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .tpud-card-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .tpud-card-value {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .tpud-card-value small {
        font-size: 13px;
        font-weight: 500;
        color: #6b7280;
    }

    .tpud-btn {
        display: inline-block;
        width: 100%;
        text-align: center;
        padding: 7px 10px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .tpud-btn-green {
        background: #16a34a;
        color: #fff;
    }

    .tpud-btn-blue {
        background: #2563eb;
        color: #fff;
    }

    .tpud-btn-muted {
        background: #f3f4f6;
        color: #6b7280;
        cursor: default;
    }

    .tpud-btn-outline {
        background: #fff;
        color: #b45309;
        border-color: #fde68a;
    }

    .tpud-referral {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f9fafb;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        padding: 10px 14px;
    }

    .tpud-referral a {
        color: #16a34a;
        font-weight: 600;
        text-decoration: none;
        word-break: break-all;
    }

    .tpud-referral button {
        background: #16a34a;
        border: none;
        color: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .tpud-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .tpud-table th,
    .tpud-table td {
        padding: 8px 10px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .tpud-table th {
        color: #6b7280;
        font-weight: 600;
        background: #f9fafb;
    }

    .tpud-table tfoot td {
        font-weight: 700;
        border-top: 2px solid #e5e7eb;
    }

    .tpud-hh-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }

    .tpud-hh-row:last-of-type {
        border-bottom: none;
    }

    .tpud-hh-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        margin-top: 6px;
        border-top: 2px solid #e5e7eb;
        font-weight: 700;
    }

    .tpud-tree-root {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 14px;
    }

    .tpud-tree-node {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        text-align: center;
        background: #fff;
    }

    .tpud-tree-children {
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        position: relative;
        padding-top: 16px;
    }

    .tpud-tree-child {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tpud-tree-badge {
        margin-top: 4px;
        font-size: 11px;
        color: #16a34a;
        font-weight: 700;
    }

    .tpud-empty {
        text-align: center;
        color: #9ca3af;
        padding: 30px 10px;
        font-size: 13px;
    }

    .tpud-empty i {
        font-size: 26px;
        display: block;
        margin-bottom: 8px;
        color: #d1d5db;
    }

    .tpud-section-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .tpud-section-head a {
        font-size: 13px;
        color: #2563eb;
        text-decoration: none;
    }

    .tpud-ftree ul {
        list-style-type: none;
        margin-left: 20px;
        padding-left: 15px;
        border-left: 1px dashed #ccc;
        display: none;
    }

    .tpud-ftree.open > ul {
        display: block;
    }

    .tpud-ftree li.open > ul {
        display: block;
    }

    .tpud-ftree li {
        margin: 5px 0;
        cursor: pointer;
        position: relative;
    }

    .tpud-ftree li span {
        padding: 4px 8px;
        background: #f5f5f5;
        border-radius: 6px;
        display: inline-block;
        transition: all 0.2s;
        color: #1f2937;
        font-size: 13px;
    }

    .tpud-ftree li span:hover {
        background: #e2e2e2;
    }

    .tpud-ftree li::before {
        content: "▶";
        position: absolute;
        left: -15px;
        font-size: 12px;
        transition: transform 0.2s;
    }

    .tpud-ftree li.open::before {
        transform: rotate(90deg);
    }

    .tpud-ftree-root {
        position: relative;
        cursor: pointer;
        padding: 4px 8px 4px 18px;
        background: #f5f5f5;
        border-radius: 6px;
        display: inline-block;
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
        transition: background 0.2s;
    }

    .tpud-ftree-root:hover {
        background: #e2e2e2;
    }

    .tpud-ftree-root::before {
        content: "▶";
        position: absolute;
        left: 4px;
        font-size: 12px;
        transition: transform 0.2s;
    }

    .tpud-ftree.open > .tpud-ftree-root::before {
        transform: rotate(90deg);
    }
</style>

<div class="tpud">
    <div class="tpud-top">
        <div>
            <h2>Xin chào, <?= htmlspecialchars($MemberName ?: $username) ?> 👋</h2>
            <div class="tpud-sub">
                UID: <strong><?= str_pad($user_id, 6, '0', STR_PAD_LEFT) ?></strong>
                &nbsp;|&nbsp; Business:
                <?php if ($business_active): ?>
                    <span class="tpud-badge tpud-badge-success">Đã Kích Hoạt</span>
                <?php else: ?>
                    <span class="tpud-badge tpud-badge-danger">Chưa kích hoạt</span>

                    <p style="margin-top: 10px; color: #f70707; font-size: 14px;">
                        Để có thể nhận hoa hồng và thưởng hệ thống, vui lòng mua 1 combo 5.000.000 VNĐ
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

    <!-- Thống kê thu nhập + hoa hồng theo cấp -->
    <div class="tpud-grid tpud-grid-2">
        <div class="tpud-card">
            <h4 style="margin-bottom:10px; font-size:15px;">Thống kê thu nhập</h4>
            <div class="tpud-hh-row"><span>Tổng thu nhập (ví tổng)</span><strong><?= number_format($wallet['tong'], 0) ?> VND</strong></div>
            <div class="tpud-hh-row"><span>Hoa hồng đã nhận (đã cộng ví)</span><strong><?= number_format($hoa_hong_da_nhan, 0) ?> VND</strong></div>
            <div class="tpud-hh-row"><span>Hoa hồng đang chờ kích hoạt</span><strong><?= number_format($hoa_hong_dang_cho, 0) ?> VND</strong></div>
            <div class="tpud-hh-total"><span>Hoa hồng tổng</span><span><?= number_format($total_hoa_hong, 0) ?> VND</span></div>
            <?php if ($hoa_hong_dang_cho > 0 && !$business_active): ?>
                <div style="margin-top:8px; font-size:12px; color:#b45309;">* Hoa hồng đang chờ vì bạn chưa kích hoạt gói 5.000.000đ. Kích hoạt để nhận toàn bộ vào ví.</div>
            <?php endif; ?>
        </div>
        <div class="tpud-card">
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

    <!-- Cây sơ đồ trực tiếp -->
    <div class="tpud-card" style="margin-bottom:20px;">
        <div class="tpud-section-head">
            <h4 style="font-size:15px;">Cây sơ đồ trực tiếp</h4>
        </div>
        <?php if (empty($direct_tree)): ?>
            <div class="tpud-empty"><i class="fa fa-sitemap" aria-hidden="true"></i>Chưa có thành viên F1 nào</div>
        <?php else: ?>
            <div style="margin-bottom:10px;">
                <a href="../?m=user&f=export_tree" class="tpud-btn tpud-btn-green" style="width:auto; display:inline-block; padding:6px 14px; text-decoration:none;">Export Excel</a>
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
                (function () {
                    function wireUp() {
                        document.getElementById("tpudFtreeRoot")?.addEventListener("click", function () {
                            document.getElementById("tpudFtree")?.classList.toggle("open");
                        });

                        document.querySelectorAll("#tpudFtree li > span").forEach(function (span) {
                            span.addEventListener("click", function (e) {
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

    <!-- Cây điều tầng -->
    <div class="tpud-grid tpud-grid-2">
        <div class="tpud-card">
            <div class="tpud-section-head">
                <h4 style="font-size:15px;">Cây điều tầng</h4>
            </div>
            <?php if ($spillover_placed_count > 0): ?>
                <p>Đã xếp: <strong><?= number_format($spillover_placed_count) ?></strong> thành viên trong cây lấp tầng.</p>
            <?php else: ?>
                <div class="tpud-empty">
                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                    Chưa có thành viên nào được xếp vào cây lấp tầng.
                    <?php if ($spillover_waiting_count > 0): ?>
                        <br><span class="tpud-badge tpud-badge-warning" style="margin-top:8px;">Đang chờ xếp tầng: <?= $spillover_waiting_count ?> người</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Giao dịch gần đây + Lịch sử rút tiền -->
    <div class="tpud-grid tpud-grid-2">
        <div class="tpud-card">
            <h4 style="margin-bottom:10px; font-size:15px;">Giao dịch gần đây</h4>
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
        const userId = <?= $user_id ?>;
        $.ajax({
            url: '/?m=user&f=get_withdraw_list',
            method: 'GET',
            data: {
                user_id: userId,
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