<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'Artist') {
    http_response_code(403);
    echo json_encode(["error" => "Only artists can upload profile photo"]);
    exit;
}

if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["error" => "Valid profile image required"]);
    exit;
}

$upload_dir = '../../uploads/profiles/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$filename = uniqid() . '_' . basename($_FILES['photo']['name']);
$filepath = $upload_dir . $filename;

if (!move_uploaded_file($_FILES['photo']['tmp_name'], $filepath)) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to upload photo"]);
    exit;
}

// Save to DB
$sql = "UPDATE users SET profile_photo = ? WHERE artistID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$filename, $_SESSION['user_id']]);

echo json_encode(["message" => "Profile photo uploaded successfully", "filename" => $filename]);
?>
