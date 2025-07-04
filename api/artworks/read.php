<?php
require '../db.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Artwork ID is required"]);
    exit;
}

$sql = "SELECT a.*, u.name AS artist_name
        FROM artworks a
        JOIN users u ON a.userID = u.artistID
        WHERE a.artworkID = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$artwork = $stmt->fetch(PDO::FETCH_ASSOC);

if ($artwork) {
    $artwork['photo'] = '/uploads/' . $artwork['photo'];
    echo json_encode($artwork);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Artwork not found"]);
}
?>
