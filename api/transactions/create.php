<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['artworkID'])) {
    http_response_code(400);
    echo json_encode(["error" => "Artwork ID is required"]);
    exit;
}

// Get artwork details
$sql = "SELECT artworkID, userID AS artistID, price, type, quantity FROM artworks WHERE artworkID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$data['artworkID']]);
$artwork = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$artwork) {
    http_response_code(404);
    echo json_encode(["error" => "Artwork not found"]);
    exit;
}

if ($artwork['artistID'] == $_SESSION['user_id']) {
    http_response_code(400);
    echo json_encode(["error" => "You cannot buy your own artwork"]);
    exit;
}

// Handle physical/digital logic
$deliveryAddress = null;
if ($artwork['type'] === 'physical') {
    if ($artwork['quantity'] < 1) {
        http_response_code(400);
        echo json_encode(["error" => "This physical artwork is sold out"]);
        exit;
    }

    if (empty($data['delivery_address'])) {
        http_response_code(400);
        echo json_encode(["error" => "Delivery address is required for physical artworks"]);
        exit;
    }

    $deliveryAddress = $data['delivery_address'];
}

// Create transaction
$sql = "INSERT INTO transaction (artworkID, artistID, buyerID, amount, delivery_address, payment_status)
        VALUES (?, ?, ?, ?, ?, 0)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $artwork['artworkID'],
    $artwork['artistID'],
    $_SESSION['user_id'],
    $artwork['price'],
    $deliveryAddress
]);

// Deduct 1 from quantity for physical
if ($artwork['type'] === 'physical') {
    $sql = "UPDATE artworks SET quantity = quantity - 1 WHERE artworkID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$artwork['artworkID']]);
}

echo json_encode([
    "message" => "Purchase completed successfully",
    "transactionID" => $pdo->lastInsertId()
]);
?>
