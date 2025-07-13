<?php
require '../auth.php';
require '../db.php';

header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Artist') {
    echo json_encode(["success" => false, "message" => "Unauthorized access"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

$requestID = $_POST['requestID'] ?? null;
$artistID = $_SESSION['user_id'];

if (!$requestID) {
    echo json_encode(["success" => false, "message" => "Missing request ID"]);
    exit;
}

// Ensure the request exists and has not been claimed
$stmt = $pdo->prepare("SELECT * FROM custom_requests WHERE requestID = ? AND artistID IS NULL");
$stmt->execute([$requestID]);
$request = $stmt->fetch();

if (!$request) {
    echo json_encode(["success" => false, "message" => "Request not available or already claimed"]);
    exit;
}

// Claim the request by assigning the artist and setting status to 1 (In Progress)
$update = $pdo->prepare("UPDATE custom_requests SET artistID = ?, status = 1 WHERE requestID = ?");
$update->execute([$artistID, $requestID]);

echo json_encode(["success" => true, "message" => "Request claimed successfully"]);
?>
