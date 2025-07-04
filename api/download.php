<?php
require 'session.php';
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

if (!isset($_GET['transactionID'])) {
    http_response_code(400);
    echo json_encode(["error" => "Transaction ID is required"]);
    exit;
}

$userID = $_SESSION['user_id'];
$transactionID = $_GET['transactionID'];

$sql = "SELECT a.type, a.photo
        FROM transaction t
        JOIN artworks a ON t.artworkID = a.artworkID
        WHERE t.transactionID = ? AND t.buyerID = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$transactionID, $userID]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    http_response_code(403);
    echo json_encode(["error" => "Not authorized or invalid transaction"]);
    exit;
}

if ($data['type'] !== 'digital') {
    http_response_code(400);
    echo json_encode(["error" => "This artwork is not digital"]);
    exit;
}

$filePath = __DIR__ . '/uploads/' . $data['photo'];

if (!file_exists($filePath)) {
    http_response_code(404);
    echo json_encode(["error" => "File not found"]);
    exit;
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
readfile($filePath);
exit;
?>
