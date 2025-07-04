<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['request_title'], $data['specifications'], $data['offered_price'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

// Assign NULL for the opposite role
$buyerID = $_SESSION['user_role'] === 'Buyer' ? $_SESSION['user_id'] : null;
$created_by_role = $_SESSION['user_role'];

$sql = "INSERT INTO custom_requests (buyerID, artistID, created_by_role, request_title, specifications, offered_price, sketch_sample, uploaded_artwork, status)
        VALUES (?, NULL, ?, ?, ?, ?, '', '', 0)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $buyerID,
    $created_by_role,
    $data['request_title'],
    $data['specifications'],
    $data['offered_price']
]);

echo json_encode([
    "message" => "Request created successfully and open for participation.",
    "requestID" => $pdo->lastInsertId()
]);
?>
