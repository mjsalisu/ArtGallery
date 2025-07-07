<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'Artist') {
    http_response_code(403);
    echo json_encode(["error" => "Only artists can create artworks."]);
    exit;
}

// Validate required fields
if (
    !isset($_POST['title'], $_POST['category'], $_POST['type'], $_POST['description'], $_POST['price']) ||
    !in_array($_POST['type'], ['digital', 'physical']) ||
    !isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK
) {
    http_response_code(400);
    echo json_encode(["error" => "All required fields including image and type are needed"]);
    exit;
}

// Quantity is required only for physical
$type = $_POST['type'];
$quantity = null;

if ($type === 'physical') {
    if (!isset($_POST['quantity']) || !is_numeric($_POST['quantity']) || $_POST['quantity'] < 1) {
        http_response_code(400);
        echo json_encode(["error" => "Quantity must be provided for physical artworks"]);
        exit;
    }
    $quantity = (int)$_POST['quantity'];
}

// Handle image upload
$upload_dir = '../../uploads/artworks/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}
$filename = uniqid() . '_' . basename($_FILES['photo']['name']);
$filepath = $upload_dir . $filename;

if (!move_uploaded_file($_FILES['photo']['tmp_name'], $filepath)) {
    http_response_code(500);
    echo json_encode(["error" => "Image upload failed"]);
    exit;
}

// Save artwork
$sql = "INSERT INTO artworks (userID, title, category, type, description, price, quantity, photo, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_SESSION['user_id'],
    $_POST['title'],
    $_POST['category'],
    $type,
    $_POST['description'],
    $_POST['price'],
    $quantity,
    $filename
]);

echo json_encode([
    "message" => "Artwork created successfully",
    "artworkID" => $pdo->lastInsertId()
]);
?>
