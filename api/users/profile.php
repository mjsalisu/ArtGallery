<?php
require '../db.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Artist ID is required"]);
    exit;
}

$artistID = $_GET['id'];

// Get artist profile
$sql = "SELECT name, email, biography, address, created_at, profile_photo
        FROM users
        WHERE artistID = ? AND role = 'Artist'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$artistID]);
$artist = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$artist) {
    http_response_code(404);
    echo json_encode(["error" => "Artist not found"]);
    exit;
}

// Append photo URL if set
$artist['profile_photo'] = $artist['profile_photo']
    ? '/uploads/profiles/' . $artist['profile_photo']
    : null;

// Get artwork count
$sql = "SELECT COUNT(*) FROM artworks WHERE userID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$artistID]);
$artist['artwork_count'] = $stmt->fetchColumn();

// Get total sales
$sql = "SELECT COALESCE(SUM(amount), 0) FROM transaction WHERE artistID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$artistID]);
$artist['total_sales'] = "₦" . $stmt->fetchColumn();

echo json_encode($artist);
?>
