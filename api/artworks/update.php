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
    echo json_encode(["error" => "You can only update your own artworks"]);
    exit;
}

$fields = ['title', 'category', 'description', 'price', 'status'];
$updates = [];
$params = [];

foreach ($fields as $field) {
    if (isset($data[$field])) {
        $updates[] = "$field = ?";
        $params[] = $data[$field];
    }
}

if (empty($updates)) {
    http_response_code(400);
    echo json_encode(["error" => "No fields provided for update"]);
    exit;
}

$params[] = $data['artworkID'];
$sql = "UPDATE artworks SET " . implode(', ', $updates) . ", updated_at = CURRENT_TIMESTAMP WHERE artworkID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["message" => "Artwork updated successfully"]);
?>
