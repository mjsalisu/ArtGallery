<?php
require '../db.php';
require '../session.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Email and password are required"]);
    exit;
}

$sql = "SELECT artistID, name, role, password FROM users WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$data['email']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($data['password'], $user['password'])) {
    $_SESSION['user_id'] = $user['artistID'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];
    echo json_encode(["message" => "Login successful"]);
} else {
    http_response_code(401);
    echo json_encode(["error" => "Invalid credentials"]);
}
?>
