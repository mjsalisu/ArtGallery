<?php
require '../db.php';

$conditions = [];
$params = [];

// Hide sold-out physical art
$conditions[] = "(a.type = 'digital' OR (a.type = 'physical' AND (a.quantity IS NULL OR a.quantity > 0)))";

// Filters
if (!empty($_GET['category'])) {
    $conditions[] = 'a.category = ?';
    $params[] = $_GET['category'];
}
if (!empty($_GET['artist'])) {
    $conditions[] = 'u.name LIKE ?';
    $params[] = '%' . $_GET['artist'] . '%';
}
if (!empty($_GET['minPrice'])) {
    $conditions[] = 'a.price >= ?';
    $params[] = (int)$_GET['minPrice'];
}
if (!empty($_GET['maxPrice'])) {
    $conditions[] = 'a.price <= ?';
    $params[] = (int)$_GET['maxPrice'];
}

$where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

$sql = "SELECT a.artworkID, a.title, a.category, a.type, a.description, a.price, a.quantity, a.photo, a.status,
               u.name AS artist_name
        FROM artworks a
        JOIN users u ON a.artistID = u.userID
        $where
        ORDER BY a.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$artworks = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($artworks as &$art) {
    $art['photo'] = $art['photo'];
}

echo json_encode($artworks);
?>
