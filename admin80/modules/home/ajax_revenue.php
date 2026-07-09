<?php
header('Content-Type: application/json');

$type = $_GET['type'] ?? 'year';
$labels = [];
$data = [];

switch ($type) {
    case 'day':
        $from = $_GET['from'] ?? date('Y-m-01');
        $to = $_GET['to'] ?? date('Y-m-t');

        $sql = "
            SELECT DATE(created_at) AS d, SUM(amount) AS total
            FROM orders
            WHERE status = 'approved' AND DATE(created_at) BETWEEN ? AND ?
            GROUP BY d ORDER BY d ASC
        ";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $from, $to);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['d'];
            $data[] = $row['total'];
        }
        break;

    case 'month':
        $year = intval($_GET['year'] ?? date('Y'));
        $labels = [];
        $data = array_fill(1, 12, 0); // mảng 12 tháng với giá trị 0

        $sql = "
        SELECT MONTH(created_at) AS m, SUM(amount) AS total
        FROM orders
        WHERE status = 'approved' AND YEAR(created_at) = ?
        GROUP BY m ORDER BY m ASC
    ";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $data[intval($row['m'])] = (float) $row['total'];
        }

        foreach (range(1, 12) as $m) {
            $labels[] = 'Tháng ' . $m;
        }
        // dữ liệu tháng từ $data[1] đến $data[12]
        $data = array_values($data);
        break;

    case 'year':
    default:
        $year = intval($_GET['year'] ?? date('Y'));
        $sql = "
            SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, SUM(amount) AS total
            FROM orders
            WHERE status = 'approved' AND YEAR(created_at) = ?
            GROUP BY ym ORDER BY ym ASC
        ";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['ym'];
            $data[] = $row['total'];
        }
        break;
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
