<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'Artist') {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['artworkID'])) {
    http_response_code(400);
    echo json_encode(["error" => "Artwork ID is required"]);
    exit;
}

// Check ownership
$sql = "SELECT userID FROM artworks WHERE artworkID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$data['artworkID']]);
$artwork = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$artwork || $artwork['userID'] != $_SESSION['user_id']) {
    http_response_code(403);
    echo json_encode(["error" => "You can only delete your own artworks"]);
    exit;
}

$sql = "DELETE FROM artworks WHERE artworkID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$data['artworkID']]);

echo json_encode(["message" => "Artwork deleted successfully"]);
?>
