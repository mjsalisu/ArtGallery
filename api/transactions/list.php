<?php
require '../auth.php';
require '../db.php';


if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$userID = $_SESSION['user_id'];

$sql = "SELECT t.transactionID, t.amount, t.payment_status, t.created_at,
               a.title AS artwork_title, u.name AS buyer_name, ua.name AS artist_name
        FROM transaction t
        JOIN artworks a ON t.artworkID = a.artworkID
        JOIN users u ON t.buyerID = u.artistID
        JOIN users ua ON t.artistID = ua.artistID
        WHERE t.buyerID = ? OR t.artistID = ?
        ORDER BY t.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$userID, $userID]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($transactions);
?>
