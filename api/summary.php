<?php
require 'session.php';
require 'db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$userID = $_SESSION['user_id'];
$role = $_SESSION['user_role'];
$summary = [];

if ($role === 'Artist') {
    // Total sales
    $sql = "SELECT COALESCE(SUM(amount), 0) AS total FROM transaction WHERE artistID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $summary[] = ["title" => "Total Sales", "value" => "₦" . $stmt->fetchColumn(), "desc" => "Total amount earned from artwork sales"];

    // Number of unique buyers
    $sql = "SELECT COUNT(DISTINCT buyerID) FROM transaction WHERE artistID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $summary[] = ["title" => "Number of Buyers", "value" => $stmt->fetchColumn(), "desc" => "Unique buyers who purchased your work"];

    // Best-selling artwork
    $sql = "SELECT a.title, COUNT(*) AS count
            FROM transaction t
            JOIN artworks a ON a.artworkID = t.artworkID
            WHERE t.artistID = ?
            GROUP BY t.artworkID
            ORDER BY count DESC
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $top = $stmt->fetch(PDO::FETCH_ASSOC);
    $summary[] = [
        "title" => "Best Seller",
        "value" => $top ? "{$top['title']} ({$top['count']}x)" : "N/A",
        "desc" => "Your most sold artwork"
    ];

    // Pending transactions
    $sql = "SELECT COUNT(*) FROM transaction WHERE artistID = ? AND payment_status = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $summary[] = ["title" => "Pending Orders", "value" => $stmt->fetchColumn(), "desc" => "Transactions awaiting payment or processing"];
} else {
    // Total spent
    $sql = "SELECT COALESCE(SUM(amount), 0) FROM transaction WHERE buyerID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $summary[] = ["title" => "Total Spent", "value" => "₦" . $stmt->fetchColumn(), "desc" => "Amount you've spent on artwork"];

    // Total purchases
    $sql = "SELECT COUNT(*) FROM transaction WHERE buyerID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $summary[] = ["title" => "Total Purchases", "value" => $stmt->fetchColumn(), "desc" => "Number of artworks you purchased"];

    // Most expensive purchase
    $sql = "SELECT a.title, t.amount
            FROM transaction t
            JOIN artworks a ON t.artworkID = a.artworkID
            WHERE t.buyerID = ?
            ORDER BY amount DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $top = $stmt->fetch(PDO::FETCH_ASSOC);
    $summary[] = [
        "title" => "Most Expensive",
        "value" => $top ? "{$top['title']} (₦{$top['amount']})" : "N/A",
        "desc" => "Highest value artwork you've purchased"
    ];

    // Top artist by spend
    $sql = "SELECT u.name, SUM(t.amount) AS total
            FROM transaction t
            JOIN users u ON t.artistID = u.artistID
            WHERE t.buyerID = ?
            GROUP BY u.name
            ORDER BY total DESC
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $top = $stmt->fetch(PDO::FETCH_ASSOC);
    $summary[] = [
        "title" => "Top Artist",
        "value" => $top ? "{$top['name']} (₦{$top['total']})" : "N/A",
        "desc" => "Artist you've supported the most"
    ];
}

echo json_encode($summary);
?>
