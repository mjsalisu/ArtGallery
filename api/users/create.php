<?php
require '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['email'], $data['phone'], $data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

$sql = "INSERT INTO users (name, email, phone, role, address, biography, password) VALUES (?, ?, ?, 'Buyer', ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);

$stmt->execute([
    $data['name'],
    $data['email'],
    $data['phone'],
    $data['address'] ?? null,
    $data['biography'] ?? null,
    $hashed_password
]);

echo json_encode(["message" => "User registered successfully", "userID" => $pdo->lastInsertId()]);
?>
