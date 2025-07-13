<?php
require '../auth.php';
require '../db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid method']);
    exit;
}

$requestID = $_POST['requestID'] ?? null;
$artistID = $_SESSION['user_id'];

if (!$requestID) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing request ID']);
    exit;
}

// Validate the artist is actually assigned to this request
$stmt = $pdo->prepare("
    SELECT * FROM custom_requests
    WHERE requestID = ? AND artistID = ? AND status = 1
");
$stmt->execute([$requestID, $artistID]);
$request = $stmt->fetch();
if (!$request) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Access denied or invalid request']);
    exit;
}

if (!isset($_FILES['uploaded_artwork']) || $_FILES['uploaded_artwork']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No artwork uploaded']);
    exit;
}

// Save uploaded file
$uploadDir = '../../uploads/artworks/request/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
$ext = pathinfo($_FILES['uploaded_artwork']['name'], PATHINFO_EXTENSION);
$newName = uniqid('artwork_', true) . '.' . $ext;
$target = $uploadDir . $newName;

if (!move_uploaded_file($_FILES['uploaded_artwork']['tmp_name'], $target)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
    exit;
}

// Update database
$update = $pdo->prepare("
    UPDATE custom_requests
    SET uploaded_artwork = ?, status = 2
    WHERE requestID = ?
");
$update->execute(['uploads/artworks/request/' . $newName, $requestID]);

echo json_encode(['success' => true, 'message' => 'Artwork submitted successfully!']);
