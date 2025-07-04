<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'Artist') {
    http_response_code(403);
    echo json_encode(["error" => "Only artists can view request details."]);
    exit;
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Request ID is required"]);
    exit;
}

$currentArtistID = $_SESSION['user_id'];

$sql = "SELECT r.*, u.name AS requester_name
        FROM custom_requests r
        LEFT JOIN users u ON r.buyerID = u.artistID
        WHERE r.requestID = ? AND r.artistID = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id'], $currentArtistID]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if ($request) {
    echo json_encode($request);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Request not found or not claimed by you."]);
}
?>
