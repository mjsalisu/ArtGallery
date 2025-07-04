<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Transaction ID is required"]);
    exit;
}

$userID = $_SESSION['user_id'];

$sql = "SELECT t.*, 
               a.title AS artwork_title, a.type AS artwork_type, a.photo AS artwork_image,
               u.name AS buyer_name, ua.name AS artist_name
        FROM transaction t
        JOIN artworks a ON t.artworkID = a.artworkID
        JOIN users u ON t.buyerID = u.artistID
        JOIN users ua ON t.artistID = ua.artistID
        WHERE t.transactionID = ? AND (t.buyerID = ? OR t.artistID = ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id'], $userID, $userID]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if ($transaction) {
    $transaction['artwork_image'] = '/uploads/' . $transaction['artwork_image'];
    echo json_encode($transaction);
} else {
    http_response_code(403);
    echo json_encode(["error" => "You are not authorized to view this transaction"]);
}
?>
