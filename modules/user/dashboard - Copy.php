<?php
include_once("header.php");
$user_id = getMemberNameID($username, "id");

// ----------- LẤY NGÀY TỪ FORM SEARCH -----------
$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;

// ----------- WHERE CỦA TRUY VẤN -----------
$where_date = "";
if ($start_date && $end_date) {
    $where_date = "AND c.created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    echo "<h2>Thống kê hoa hồng từ $start_date đến $end_date</h2>";
} else {
    echo "<h2>Thống kê hoa hồng toàn bộ</h2>";
}

// ----------- TÍNH TỔNG THEO LOẠI -----------
function get_total($mysqli, $user_id, $level, $where_date) {
    $result = $mysqli->query("
        SELECT SUM(amount) AS total 
        FROM commissions c
        WHERE user_id = $user_id AND level = $level
        $where_date
    ");
    return $result->fetch_assoc()['total'] ?? 0;
}

$direct = get_total($mysqli, $user_id, 0, $where_date);
$level1 = get_total($mysqli, $user_id, 1, $where_date);
$level2 = get_total($mysqli, $user_id, 2, $where_date);
$total = $direct + $level1 + $level2;

echo "<p><strong>1. Hoa hồng bán trực tiếp:</strong> " . number_format($direct, 0) . " VND<br>";
echo "<strong>2. Hoa hồng tuyến trên F1:</strong> " . number_format($level1, 0) . " VND<br>";
echo "<strong>3. Hoa hồng tuyến trên F2:</strong> " . number_format($level2, 0) . " VND<br>";
echo "<strong style='color:blue;'>Tổng cộng:</strong> " . number_format($total, 0) . " VND</p>";

// ----------- PHÂN TRANG -----------
$limit = 10;
$page = max(1, intval($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// ----------- ĐẾM ĐƠN HÀNG -----------
$result_count = $mysqli->query("
    SELECT COUNT(DISTINCT c.order_id) AS total
    FROM commissions c
    WHERE c.user_id = $user_id $where_date
");
$total_records = $result_count->fetch_assoc()['total'] ?? 0;
$total_pages = ceil($total_records / $limit);

// ----------- CSS GIAO DIỆN -----------
echo <<<CSS
<style>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
table, th, td {
    border: 1px solid #ccc;
}
th {
    background-color: #f2f2f2;
    text-align: center;
    padding: 8px;
}
td {
    padding: 8px;
    vertical-align: top;
}
tr:nth-child(even) {
    background-color: #f9f9f9;
}
h2, h3 {
    color: #333;
}
.pagination {
    margin-top: 15px;
    text-align: center;
}
.pagination a {
    margin: 0 4px;
    text-decoration: none;
    padding: 6px 10px;
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333;
}
.pagination a[style*="bold"] {
    background-color: #007bff;
    color: white;
}
form {
    margin-top: 20px;
}
form input[type='date'] {
    padding: 5px;
}
form button {
    padding: 6px 12px;
    margin-left: 10px;
}
</style>
CSS;

// ----------- BẢNG CHI TIẾT ĐƠN HÀNG -----------
echo "<h3>Chi tiết hoa hồng theo đơn hàng:</h3>";
echo "<table>";
echo "<tr><th>Đơn hàng</th><th>Sản phẩm</th><th>Người bán</th><th>Tổng tiền</th><th>Hoa hồng</th><th>Ngày</th></tr>";

$result = $mysqli->query("
    SELECT 
        c.order_id,
        o.user_id AS seller_id,
        o.products AS products,
        o.amount AS amount,           
        u.name AS seller_name,
        MAX(c.created_at) AS created_at,
        SUM(c.amount) AS commission_total
    FROM commissions c
    JOIN orders o ON c.order_id = o.id
    JOIN user u ON o.user_id = u.id
    WHERE c.user_id = $user_id $where_date
    GROUP BY c.order_id
    ORDER BY created_at DESC
    LIMIT $limit OFFSET $offset
");

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>#{$row['order_id']}</td>";
    echo "<td>" . nl2br(htmlspecialchars($row['products'])) . "</td>";
    echo "<td>{$row['seller_name']} (#{$row['seller_id']})</td>";
    echo "<td>" . number_format($row['amount'], 0) . " VND</td>";
    echo "<td>" . number_format($row['commission_total'], 0) . " VND</td>";
    echo "<td>{$row['created_at']}</td>";
    echo "</tr>";
}
echo "</table>";

// ----------- PHÂN TRANG HTML -----------
if ($total_pages > 1) {
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i == $page) ? "style='font-weight:bold;'" : "";
        $query = http_build_query(array_merge($_GET, ['page' => $i]));
        echo "<a href='?$query' $active>$i</a>";
    }
    echo "</div>";
}

// ----------- FORM TÌM KIẾM -----------
echo "<form method='get'>
  <label>Từ ngày:</label> <input type='date' name='start_date' value='$start_date'>
  <label>Đến ngày:</label> <input type='date' name='end_date' value='$end_date'>
  <button type='submit'>Search</button>
</form>";

include_once("footer.php");
?>
