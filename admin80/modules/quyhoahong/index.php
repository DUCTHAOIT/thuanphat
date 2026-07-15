<?php
// Trang theo dõi: Quỹ công ty (40%) / Quỹ chia hoa hồng (60%), danh sách hoa hồng + thưởng đã trả/pending,
// quỹ hoa hồng còn lại, quỹ vận hành (5 quỹ con) và ví toàn hệ thống.
// Ref: docs/BUSINESS_RULES.md mục 2 (Ví), mục 3 (Quỹ công ty/quỹ chia hoa hồng/quỹ vận hành), mục 5
// (pending/release), mục 6 (thưởng tiêu dùng tuần hoàn, thưởng danh hiệu).
// Theo mẫu admin80/modules/order/index.php và admin80/modules/withdraw/index.php: raw PHP + $mysqli
// prepared statements, filter qua $_GET, không dùng Smarty.
session_start();

$limit = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$type = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');
$search_like = '%' . $search . '%';

// Tab nào đang được xem (bổ sung 2026-07-15 - gộp các mục chi tiết vào nav nhỏ, giữ đúng tab sau khi lọc)
$activeTab = $_GET['tab'] ?? 'fund';
if (!in_array($activeTab, ['fund', 'wallet', 'bonus'], true)) $activeTab = 'fund';

// Lịch sử quỹ vận hành / quỹ tiêu dùng tuần hoàn công ty (bổ sung 2026-07-15, tách trang riêng khỏi phân
// trang "Danh sách hoa hồng/thưởng" - dùng chung bộ lọc ngày ở trên, có thêm lọc theo nguồn/quỹ riêng).
$fundLimit = 20;
$fundPage = isset($_GET['fund_page']) ? max(1, (int)$_GET['fund_page']) : 1;
$fundOffset = ($fundPage - 1) * $fundLimit;
$fundSourceFilter = $_GET['fund_source'] ?? '';
$fundCodeFilter = $_GET['fund_code'] ?? '';

$commissionTypes = ['direct', 'spillover', 'rank_bonus'];
$typeLabels = [
    'direct' => 'Hoa hồng trực tiếp (F1-F8)',
    'spillover' => 'Hoa hồng lấp tầng',
    'rank_bonus' => 'Thưởng danh hiệu',
    'accumulated_consumption' => 'Tích lũy tiêu dùng',
    'recurring' => 'Thưởng tiêu dùng tuần hoàn',
];

// Nhãn nguồn tiền của admin_fund_transactions (mục 3, mục 6 BUSINESS_RULES.md) - để phân biệt trong lịch sử
// quỹ vận hành / quỹ tiêu dùng tuần hoàn công ty, theo yêu cầu Sếp phân biệt "cộng từ tái tiêu dùng" với
// "cộng từ chia 10% quỹ hoa hồng".
$fundSourceLabels = [
    'direct_commission' => '10% quỹ chia hoa hồng mỗi đơn',
    'card_bonus' => '30% thưởng tiêu dùng tuần hoàn',
    'rebuy' => 'Phần dư Rebuy (tái tiêu dùng)',
];

// Xây 1 nhánh SELECT chuẩn hoá cho 1 bảng hoa hồng/thưởng, dùng chung cho UNION ALL bên dưới.
// $typeExpr: cột/giá trị literal trả về cho cột "type" của kết quả.
// $levelExpr: cột/giá trị literal trả về cho cột "level" - accumulated_consumption_bonuses không có cột
// level (cập nhật 2026-07-13: Tích lũy tiêu dùng không còn chia theo tầng cây, xem mục 6 BUSINESS_RULES.md).
function buildBonusBranch($table, $typeExpr, $typeCheck, $status, $start_date, $end_date, $search, $levelExpr = 't.level') {
    // Chỉ bảng commissions có cột rebuy_id (nguồn gốc giao dịch Rebuy - mục 6 "Giao dịch tái tiêu dùng tự
    // động"); accumulated_consumption_bonuses/recurring_consumption_bonuses không áp dụng cho Rebuy nên luôn NULL.
    $rebuyIdExpr = $table === 'commissions' ? 't.rebuy_id' : 'NULL';
    $sql = "SELECT t.id, t.order_id, $rebuyIdExpr AS rebuy_id, t.user_id, u.name, u.email, $typeExpr AS type, $levelExpr AS level, t.amount, t.status, t.created_at, t.released_at
            FROM $table t JOIN user u ON u.id = t.user_id WHERE 1=1";
    $types = "";
    $params = [];

    if ($status !== '') {
        $sql .= " AND t.status = ?";
        $types .= "s";
        $params[] = $status;
    }
    if ($start_date !== '' && $end_date !== '') {
        $sql .= " AND DATE(t.created_at) BETWEEN ? AND ?";
        $types .= "ss";
        $params[] = $start_date;
        $params[] = $end_date;
    }
    if ($search !== '') {
        $sql .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.id = ?)";
        $types .= "ssi";
        $params[] = '%' . $search . '%';
        $params[] = '%' . $search . '%';
        $params[] = (int) $search;
    }
    if ($typeCheck !== null) {
        $sql .= " AND t.type = ?";
        $types .= "s";
        $params[] = $typeCheck;
    }

    return [$sql, $types, $params];
}

// Gộp các nhánh cần thiết theo bộ lọc $type (bỏ hẳn nhánh không khớp $type đã chọn thay vì lọc rỗng)
function buildBonusUnionSql($type, $status, $start_date, $end_date, $search, $commissionTypes) {
    $branches = [];
    $types = "";
    $params = [];

    if ($type === '' || in_array($type, $commissionTypes, true)) {
        $typeCheck = ($type !== '' && in_array($type, $commissionTypes, true)) ? $type : null;
        [$sql, $t, $p] = buildBonusBranch('commissions', 't.type', $typeCheck, $status, $start_date, $end_date, $search);
        $branches[] = $sql;
        $types .= $t;
        $params = array_merge($params, $p);
    }
    if ($type === '' || $type === 'accumulated_consumption') {
        [$sql, $t, $p] = buildBonusBranch('accumulated_consumption_bonuses', "'accumulated_consumption'", null, $status, $start_date, $end_date, $search, 'NULL');
        $branches[] = $sql;
        $types .= $t;
        $params = array_merge($params, $p);
    }
    if ($type === '' || $type === 'recurring') {
        [$sql, $t, $p] = buildBonusBranch('recurring_consumption_bonuses', "'recurring'", null, $status, $start_date, $end_date, $search);
        $branches[] = $sql;
        $types .= $t;
        $params = array_merge($params, $p);
    }

    if (empty($branches)) return [null, "", []];
    return [implode(" UNION ALL ", $branches), $types, $params];
}

[$unionSql, $unionTypes, $unionParams] = buildBonusUnionSql($type, $status, $start_date, $end_date, $search, $commissionTypes);

$paidTotal = 0;
$pendingTotal = 0;
$totalRows = 0;
$result = null;

if ($unionSql !== null) {
    // Tổng đã trả (released) / đang chờ (pending), theo bộ lọc đang áp dụng
    $sumSql = "SELECT status, SUM(amount) AS total FROM ($unionSql) x GROUP BY status";
    $stmt = $mysqli->prepare($sumSql);
    if (!empty($unionParams)) $stmt->bind_param($unionTypes, ...$unionParams);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        if ($row['status'] === 'released') $paidTotal = (float) $row['total'];
        if ($row['status'] === 'pending') $pendingTotal = (float) $row['total'];
    }
    $stmt->close();

    // Tổng số dòng để phân trang
    $countSql = "SELECT COUNT(*) AS cnt FROM ($unionSql) x";
    $stmt = $mysqli->prepare($countSql);
    if (!empty($unionParams)) $stmt->bind_param($unionTypes, ...$unionParams);
    $stmt->execute();
    $totalRows = (int) ($stmt->get_result()->fetch_assoc()['cnt'] ?? 0);
    $stmt->close();

    // Danh sách chi tiết, có phân trang
    $listSql = "SELECT * FROM ($unionSql) x ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $listTypes = $unionTypes . "ii";
    $listParams = array_merge($unionParams, [$limit, $offset]);
    $stmt = $mysqli->prepare($listSql);
    $stmt->bind_param($listTypes, ...$listParams);
    $stmt->execute();
    $result = $stmt->get_result();
}

$totalPages = (int) ceil($totalRows / $limit);

// Quỹ công ty (40%) / quỹ chia hoa hồng (60%): trên TẤT CẢ đơn đã duyệt (mục 3 BUSINESS_RULES.md)
$orderSql = "SELECT SUM(o.amount) AS total_amount FROM orders o JOIN user u ON u.id = o.user_id WHERE o.status = 'approved'";
$orderTypes = "";
$orderParams = [];
if ($start_date !== '' && $end_date !== '') {
    $orderSql .= " AND DATE(o.created_at) BETWEEN ? AND ?";
    $orderTypes .= "ss";
    $orderParams[] = $start_date;
    $orderParams[] = $end_date;
}
if ($search !== '') {
    $orderSql .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.id = ?)";
    $orderTypes .= "ssi";
    $orderParams[] = $search_like;
    $orderParams[] = $search_like;
    $orderParams[] = (int) $search;
}
$stmt = $mysqli->prepare($orderSql);
if (!empty($orderParams)) $stmt->bind_param($orderTypes, ...$orderParams);
$stmt->execute();
$totalOrderAmount = (float) ($stmt->get_result()->fetch_assoc()['total_amount'] ?? 0);
$stmt->close();

$companyFund = $totalOrderAmount * 0.4;
$commissionFund = $totalOrderAmount * 0.6;
$remainingCommissionFund = $commissionFund - $paidTotal;

// Quỹ vận hành: tổng + breakdown 5 quỹ con (mục 3), theo khoảng ngày nếu có lọc
$fundLabels = [
    'thi_truong_leader' => 'Thị trường leader',
    'van_phong' => 'Văn phòng',
    'dao_tao' => 'Đào tạo, Marketing',
    'it_van_hanh' => 'IT support, vận hành web',
    'du_phong' => 'Quỹ dự phòng',
];
// Quỹ tiêu dùng tuần hoàn công ty (bổ sung 2026-07-15, mục 6): 30% còn lại của thưởng tiêu dùng tuần hoàn,
// tách riêng khỏi quỹ vận hành ở trên - xem creditCompanyCardFund() trong order_commission.php.
$companyCardFundLabels = [
    'cp_nen_tang' => 'Chi phí nền tảng (nhân sự, IT)',
    'bdh_leader' => 'Ban điều hành & Leader',
    'du_phong_the' => 'Quỹ dự phòng (thẻ tiêu dùng)',
];
$fundTotals = array_fill_keys(array_merge(array_keys($fundLabels), array_keys($companyCardFundLabels)), 0.0);
$fundSql = "SELECT fund_code, SUM(amount) AS total FROM admin_fund_transactions WHERE 1=1";
$fundTypes = "";
$fundParams = [];
if ($start_date !== '' && $end_date !== '') {
    $fundSql .= " AND DATE(created_at) BETWEEN ? AND ?";
    $fundTypes .= "ss";
    $fundParams[] = $start_date;
    $fundParams[] = $end_date;
}
$fundSql .= " GROUP BY fund_code";
$stmt = $mysqli->prepare($fundSql);
if (!empty($fundParams)) $stmt->bind_param($fundTypes, ...$fundParams);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $fundTotals[$row['fund_code']] = (float) $row['total'];
}
$stmt->close();
$operatingFundTotal = array_sum(array_intersect_key($fundTotals, $fundLabels));
$companyCardFundTotal = array_sum(array_intersect_key($fundTotals, $companyCardFundLabels));

$fundAllLabels = array_merge($fundLabels, $companyCardFundLabels);

// Danh sách chi tiết từng giao dịch cộng quỹ (mục 3, mục 6), phân biệt rõ nguồn: 10% quỹ chia hoa hồng mỗi
// đơn / 30% thưởng tiêu dùng tuần hoàn / phần dư Rebuy (tái tiêu dùng) - áp dụng chung cho cả quỹ vận hành
// và quỹ tiêu dùng tuần hoàn công ty.
$fundListWhere = "WHERE 1=1";
$fundListTypes = "";
$fundListParams = [];
if ($start_date !== '' && $end_date !== '') {
    $fundListWhere .= " AND DATE(created_at) BETWEEN ? AND ?";
    $fundListTypes .= "ss";
    $fundListParams[] = $start_date;
    $fundListParams[] = $end_date;
}
if ($fundSourceFilter !== '') {
    $fundListWhere .= " AND source = ?";
    $fundListTypes .= "s";
    $fundListParams[] = $fundSourceFilter;
}
if ($fundCodeFilter !== '') {
    $fundListWhere .= " AND fund_code = ?";
    $fundListTypes .= "s";
    $fundListParams[] = $fundCodeFilter;
}

$fundCountSql = "SELECT COUNT(*) AS cnt FROM admin_fund_transactions $fundListWhere";
$stmt = $mysqli->prepare($fundCountSql);
if (!empty($fundListParams)) $stmt->bind_param($fundListTypes, ...$fundListParams);
$stmt->execute();
$fundTotalRows = (int) ($stmt->get_result()->fetch_assoc()['cnt'] ?? 0);
$stmt->close();
$fundTotalPages = (int) ceil($fundTotalRows / $fundLimit);

$fundListSql = "SELECT id, fund_code, source, order_id, rebuy_id, amount, created_at
                FROM admin_fund_transactions $fundListWhere
                ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $mysqli->prepare($fundListSql);
$stmt->bind_param($fundListTypes . "ii", ...array_merge($fundListParams, [$fundLimit, $fundOffset]));
$stmt->execute();
$fundListResult = $stmt->get_result();

// Ví toàn hệ thống: số dư hiện tại (không áp bộ lọc ngày, đây là snapshot tại thời điểm xem)
$walletSql = "SELECT SUM(tong) AS tong, SUM(kha_dung) AS kha_dung, SUM(tieu_dung) AS tieu_dung,
                     SUM(tai_tieu_dung) AS tai_tieu_dung, SUM(thue_phi) AS thue_phi,
                     SUM(tich_luy_tieu_dung) AS tich_luy_tieu_dung
              FROM user_wallets";
$walletRow = $mysqli->query($walletSql)->fetch_assoc();

include_once("header.php");

function tile($color, $label, $value, $suffix = ' đ') {
    echo '<div class="col-md-4 col-lg-3">';
    echo '<div class="card card-hover"><div class="box bg-' . $color . ' text-center">';
    echo '<h6 class="text-white">' . htmlspecialchars($label) . '</h6>';
    echo '<h1 class="font-light text-white" style="font-size:22px;">' . number_format((float)$value, 0, ',', '.') . $suffix . '</h1>';
    echo '</div></div></div>';
}
?>
<div class="container-fluid py-4">
    <h3 class="mb-4">Quỹ hoa hồng / Quỹ công ty / Quỹ vận hành</h3>

    <div class="row">
        <?php
        tile('warning', 'Tổng giá trị đơn đã duyệt', $totalOrderAmount);
        tile('cyan', 'Quỹ công ty (40%)', $companyFund);
        tile('info', 'Quỹ chia hoa hồng (60%)', $commissionFund);
        tile('success', 'Đã trả (released)', $paidTotal);
        tile('danger', 'Đang chờ (pending)', $pendingTotal);
        tile('inverse', 'Quỹ hoa hồng còn lại', $remainingCommissionFund);
        ?>
    </div>

    <!-- Chi tiết thu gọn vào tab nhỏ (bổ sung 2026-07-15), trang chính chỉ còn "Tổng quan" ở trên. $activeTab
    giữ đúng tab đang xem sau khi submit form lọc trong tab (mỗi form lọc có input ẩn "tab" tương ứng). -->
    <ul class="nav nav-tabs mt-4" id="quyhoahongTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $activeTab === 'fund' ? 'active' : '' ?>" id="tab-fund-btn" data-bs-toggle="tab" data-bs-target="#tab-fund" type="button" role="tab">Quỹ vận hành / Quỹ tiêu dùng tuần hoàn công ty</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $activeTab === 'wallet' ? 'active' : '' ?>" id="tab-wallet-btn" data-bs-toggle="tab" data-bs-target="#tab-wallet" type="button" role="tab">Ví hệ thống</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $activeTab === 'bonus' ? 'active' : '' ?>" id="tab-bonus-btn" data-bs-toggle="tab" data-bs-target="#tab-bonus" type="button" role="tab">Danh sách hoa hồng / thưởng</button>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-3 mb-4">
        <div class="tab-pane fade <?= $activeTab === 'fund' ? 'show active' : '' ?>" id="tab-fund" role="tabpanel">
            <h4 class="mt-2 mb-3">Quỹ vận hành (tổng: <?= number_format($operatingFundTotal, 0, ',', '.') ?> đ)</h4>
            <div class="row">
                <?php foreach ($fundLabels as $code => $label): ?>
                    <?php tile('cyan', $label, $fundTotals[$code]); ?>
                <?php endforeach; ?>
            </div>

            <h4 class="mt-4 mb-3">Quỹ tiêu dùng tuần hoàn công ty (tổng: <?= number_format($companyCardFundTotal, 0, ',', '.') ?> đ)</h4>
            <div class="row">
                <?php foreach ($companyCardFundLabels as $code => $label): ?>
                    <?php tile('purple', $label, $fundTotals[$code]); ?>
                <?php endforeach; ?>
            </div>

            <h4 class="mt-4 mb-3">Lịch sử cộng quỹ vận hành / quỹ tiêu dùng tuần hoàn công ty</h4>

            <form class="mb-3" method="get">
                <input type="hidden" name="m" value="quyhoahong">
                <input type="hidden" name="tab" value="fund">
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
                <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">
                <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                    <input type="date" name="start_date" class="form-control" style="width:auto;" value="<?= htmlspecialchars($start_date) ?>">
                    <input type="date" name="end_date" class="form-control" style="width:auto;" value="<?= htmlspecialchars($end_date) ?>">
                    <select name="fund_source" class="form-control" style="width:auto;">
                        <option value="">-- Tất cả nguồn --</option>
                        <?php foreach ($fundSourceLabels as $key => $label): ?>
                            <option value="<?= $key ?>" <?= $fundSourceFilter === $key ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="fund_code" class="form-control" style="width:auto;">
                        <option value="">-- Tất cả quỹ --</option>
                        <?php foreach ($fundAllLabels as $key => $label): ?>
                            <option value="<?= $key ?>" <?= $fundCodeFilter === $key ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="?m=quyhoahong&tab=fund" class="btn btn-secondary">Xóa lọc</a>
                </div>
            </form>

            <?php if ($fundListResult && $fundListResult->num_rows > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Quỹ</th>
                        <th>Nguồn</th>
                        <th>Đơn/Rebuy</th>
                        <th>Số tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $fundListResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td><?= htmlspecialchars($fundAllLabels[$row['fund_code']] ?? $row['fund_code']) ?></td>
                            <td><?= htmlspecialchars($fundSourceLabels[$row['source']] ?? $row['source']) ?></td>
                            <td>
                                <?php if ($row['order_id']): ?>
                                    Đơn #<?= (int) $row['order_id'] ?>
                                <?php elseif ($row['rebuy_id']): ?>
                                    Rebuy #<?= (int) $row['rebuy_id'] ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><strong><?= number_format((float) $row['amount'], 0, ',', '.') ?> đ</strong></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <nav>
                    <ul class="pagination">
                        <?php for ($p = 1; $p <= $fundTotalPages; $p++): ?>
                            <li class="page-item <?= ($p == $fundPage) ? 'active' : '' ?>">
                                <a class="page-link" href="?m=quyhoahong&tab=fund&fund_page=<?= $p ?>&search=<?= urlencode($search) ?>&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>&type=<?= urlencode($type) ?>&status=<?= urlencode($status) ?>&fund_source=<?= urlencode($fundSourceFilter) ?>&fund_code=<?= urlencode($fundCodeFilter) ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php else: ?>
                <p>Không có dữ liệu phù hợp bộ lọc.</p>
            <?php endif; ?>
        </div>

        <div class="tab-pane fade <?= $activeTab === 'wallet' ? 'show active' : '' ?>" id="tab-wallet" role="tabpanel">
            <h4 class="mt-2 mb-3">Ví toàn hệ thống (số dư hiện tại)</h4>
            <div class="row">
                <?php
                tile('success', 'Ví tổng', $walletRow['tong'] ?? 0);
                tile('success', 'Ví khả dụng', $walletRow['kha_dung'] ?? 0);
                tile('success', 'Ví Tích lũy tiêu dùng', $walletRow['tich_luy_tieu_dung'] ?? 0);
                tile('success', 'Ví tiêu dùng', $walletRow['tieu_dung'] ?? 0);
                tile('success', 'Ví tái tiêu dùng', $walletRow['tai_tieu_dung'] ?? 0);
                tile('success', 'Ví thuế, phí', $walletRow['thue_phi'] ?? 0);
                ?>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-bonus" role="tabpanel">
            <h4 class="mt-2 mb-3">Danh sách hoa hồng / thưởng</h4>

            <form class="mb-3" method="get">
                <input type="hidden" name="m" value="quyhoahong">
                <input type="hidden" name="tab" value="bonus">
                <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                    <input type="text" name="search" class="form-control" style="width:auto;" placeholder="Tên/email/ID thành viên" value="<?= htmlspecialchars($search) ?>">
                    <input type="date" name="start_date" class="form-control" style="width:auto;" value="<?= htmlspecialchars($start_date) ?>">
                    <input type="date" name="end_date" class="form-control" style="width:auto;" value="<?= htmlspecialchars($end_date) ?>">
                    <select name="type" class="form-control" style="width:auto;">
                        <option value="">-- Tất cả loại --</option>
                        <?php foreach ($typeLabels as $key => $label): ?>
                            <option value="<?= $key ?>" <?= $type === $key ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="status" class="form-control" style="width:auto;">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="released" <?= $status === 'released' ? 'selected' : '' ?>>Đã trả</option>
                        <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Đang chờ</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="?m=quyhoahong&tab=bonus" class="btn btn-secondary">Xóa lọc</a>
                </div>
            </form>

            <?php if ($result && $result->num_rows > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Nguồn</th>
                        <th>Thành viên</th>
                        <th>Loại</th>
                        <th>Tầng</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Thời gian trả</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <?php if ($row['order_id']): ?>
                                    Đơn #<?= (int) $row['order_id'] ?>
                                <?php elseif ($row['rebuy_id']): ?>
                                    Rebuy #<?= (int) $row['rebuy_id'] ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['name']) ?><br><small><?= htmlspecialchars($row['email']) ?></small></td>
                            <td><?= htmlspecialchars($typeLabels[$row['type']] ?? $row['type']) ?></td>
                            <td><?= $row['level'] !== null ? (int) $row['level'] : '-' ?></td>
                            <td><strong><?= number_format((float) $row['amount'], 0, ',', '.') ?> đ</strong></td>
                            <td>
                                <?php if ($row['status'] === 'released'): ?>
                                    <span class="badge badge-success">Đã trả</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Đang chờ</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $row['released_at'] ? htmlspecialchars($row['released_at']) : '-' ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <nav>
                    <ul class="pagination">
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?m=quyhoahong&page=<?= $p ?>&search=<?= urlencode($search) ?>&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>&type=<?= urlencode($type) ?>&status=<?= urlencode($status) ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php else: ?>
                <p>Không có dữ liệu phù hợp bộ lọc.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once("footer.php"); ?>
