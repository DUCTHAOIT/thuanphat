<?php
header('Content-Type: application/json');

$code = trim($_GET['code'] ?? '');
if ($code === '') {
    echo json_encode(['status' => 'empty']);
    exit;
}

$stmt = $mysqli->prepare("SELECT name FROM user WHERE mobile = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['status' => 'ok', 'name' => $row['name']]);
} else {
    echo json_encode(['status' => 'error']);
}
$stmt->close();
