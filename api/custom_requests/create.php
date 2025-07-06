<?php
require '../session.php';
require '../db.php';

header("Content-Type: application/json; charset=UTF-8");

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

$created_by = $_SESSION['user_id'];

$sql = "INSERT INTO custom_requests (created_by, artistID, request_title, specifications, offered_price, sketch_sample, uploaded_artwork, status)
        VALUES (?, NULL, ?, ?, ?, '', '', 0)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $created_by,
    $data['request_title'],
    $data['specifications'],
    $data['offered_price']
]);

echo json_encode([
    "message" => "Request created successfully and open for participation.",
    "requestID" => $pdo->lastInsertId()
]);
?>
