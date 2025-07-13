<?php
require '../session.php';
require '../db.php';

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

$requestID = $_POST['requestID'] ?? null;
$userID = $_SESSION['user_id'];

if (!$requestID) {
    echo json_encode(["success" => false, "message" => "Missing request ID"]);
    exit;
}

// Verify ownership
$stmt = $pdo->prepare("SELECT * FROM custom_requests WHERE requestID = ? AND created_by = ?");
$stmt->execute([$requestID, $userID]);
$request = $stmt->fetch();

if (!$request) {
    echo json_encode(["success" => false, "message" => "Request not found or access denied"]);
    exit;
}

// Update the request status to -1 (cancelled)
$update = $pdo->prepare("UPDATE custom_requests SET status = -1 WHERE requestID = ?");
$update->execute([$requestID]);

echo json_encode(["success" => true, "message" => "Request cancelled successfully"]);
?>
