<?php
require '../session.php';
require '../db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'Artist') {
    http_response_code(403);
    echo json_encode(["error" => "Only artists can view available custom requests."]);
    exit;
}

$currentArtistID = $_SESSION['user_id'];

$sql = "SELECT r.requestID, r.request_title, r.specifications, r.offered_price, r.created_at, 
               r.created_by_role, u.name AS requester_name
        FROM custom_requests r
        LEFT JOIN users u ON r.buyerID = u.artistID
        WHERE r.status = 0 AND r.artistID IS NULL AND (r.buyerID IS NULL OR r.buyerID != ?)
        ORDER BY r.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$currentArtistID]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($requests);
?>
