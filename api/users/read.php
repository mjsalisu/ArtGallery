<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$sql = "SELECT artistID, name, email, phone, role, address, biography, profile_photo, created_at 
        FROM users WHERE artistID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && $user['profile_photo']) {
    $user['profile_photo'] = '/uploads/profiles/' . $user['profile_photo'];
}

echo json_encode($user);
?>
