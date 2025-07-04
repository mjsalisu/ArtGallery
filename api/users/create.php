<?php
require '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['email'], $data['phone'], $data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

try {
    $checkSql = "SELECT artistID FROM users WHERE email = ? OR phone = ?";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([$data['email'], $data['phone']]);
    if ($checkStmt->rowCount() > 0) {   
        echo json_encode(["error" => "Email or phone number already exists"]);
        http_response_code(409); // Conflict
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
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
