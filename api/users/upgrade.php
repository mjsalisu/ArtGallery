<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$sql = "UPDATE users SET role = 'Artist', updated_at = CURRENT_TIMESTAMP WHERE userID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);

$_SESSION['user_role'] = 'Artist';

echo json_encode(["message" => "You are now an Artist"]);
?>
