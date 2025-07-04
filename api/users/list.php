<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    http_response_code(403);
    echo json_encode(["error" => "Access denied. Admins only."]);
    exit;
}

$sql = "SELECT artistID, name, email, phone, role, profile_photo, created_at FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as &$user) {
    $user['profile_photo'] = $user['profile_photo']
        ? '/uploads/profiles/' . $user['profile_photo']
        : null;
}

echo json_encode($users);
?>
