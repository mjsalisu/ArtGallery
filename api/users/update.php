<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$userID = $_SESSION['user_id'];

$fields = ['name', 'email', 'phone', 'address', 'biography'];
$updates = [];
$params = [];

foreach ($fields as $field) {
    if (!empty($_POST[$field])) {
        $updates[] = "$field = ?";
        $params[] = $_POST[$field];
    }
}

// Handle profile photo update
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../../uploads/profiles/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $filename = uniqid() . '_' . basename($_FILES['profile_photo']['name']);
    $filepath = $upload_dir . $filename;
    move_uploaded_file($_FILES['profile_photo']['tmp_name'], $filepath);

    $updates[] = "profile_photo = ?";
    $params[] = $filename;
}

if (empty($updates)) {
    http_response_code(400);
    echo json_encode(["error" => "No fields provided to update"]);
    exit;
}

$params[] = $userID;
$sql = "UPDATE users SET " . implode(', ', $updates) . ", updated_at = CURRENT_TIMESTAMP WHERE userID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["message" => "Profile updated successfully"]);
?>
