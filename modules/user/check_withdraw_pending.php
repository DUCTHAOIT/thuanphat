<?php
session_start();
header('Content-Type: application/json');

$username = getSession("username");
if (!isset($username) || empty($username)) {
    echo json_encode(['pending' => false]);
    exit();
}
$user_id = getMemberNameID($username, "id");

$stmt = $mysqli->prepare("
    SELECT id, amount, status, created_at 
    FROM transactions 
    WHERE user_id = ? AND type = 'withdraw' AND status = 'pending' 
    ORDER BY created_at DESC 
    LIMIT 1
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'pending' => true,
        'id' => $row['id'],
        'amount' => number_format($row['amount'], 0, ',', '.') . ' VND',
        'status' => ucfirst($row['status']),
        'created_at' => date('d/m/Y H:i', strtotime($row['created_at']))
    ]);
} else {
    echo json_encode(['pending' => false]);
}
