<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'Artist') {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['transactionID'], $data['payment_status'])) {
    http_response_code(400);
    echo json_encode(["error" => "Transaction ID and new status are required"]);
    exit;
}

$transactionID = $data['transactionID'];
$newStatus = (int) $data['payment_status'];
$artistID = $_SESSION['user_id'];

// Confirm artist owns transaction
$sql = "SELECT * FROM transaction WHERE transactionID = ? AND artistID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$transactionID, $artistID]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaction) {
    http_response_code(403);
    echo json_encode(["error" => "You do not have permission to update this transaction"]);
    exit;
}

$sql = "UPDATE transaction SET payment_status = ? WHERE transactionID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$newStatus, $transactionID]);

echo json_encode(["message" => "Transaction status updated successfully"]);
?>
