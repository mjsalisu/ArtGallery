<?php
require './api/auth.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Transactions | ArtGallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900">
    <link rel="stylesheet" href="./assets/css/ready.css">
    <link rel="stylesheet" href="./assets/css/demo.css">
</head>

<body>
    <div class="wrapper">
        <?php include('components/header.php'); ?>
        <?php include('components/sidebar.php'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h4 class="page-title">Transactions</h4>
                    </div>

                    <div class="card">
                        <div class="card-body">
                        <?php
// Fetch transactions relevant to the logged-in user
$stmt = $pdo->prepare("
    SELECT t.*, a.title AS artwork_title, u.name AS buyer_name, ua.name AS artist_name
    FROM transaction t
    JOIN artworks a ON t.artworkID = a.artworkID
    JOIN users u ON t.buyerID = u.userID
    JOIN users ua ON t.artistID = ua.userID
    WHERE t.buyerID = ? OR t.artistID = ?
    ORDER BY t.created_at DESC
");
$stmt->execute([$user_id, $user_id]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$headers = ['Artwork', 'Buyer', 'Artist', 'Amount (₦)', 'Status', 'Transaction Date'];
$rowsHtml = '';

foreach ($transactions as $tx) {
    $rowsHtml .= '<tr>';
    $rowsHtml .= '<td>' . htmlspecialchars($tx['artwork_title']) . '</td>';
    $rowsHtml .= '<td>' . htmlspecialchars($tx['buyer_name']) . '</td>';
    $rowsHtml .= '<td>' . htmlspecialchars($tx['artist_name']) . '</td>';
    $rowsHtml .= '<td>₦' . number_format($tx['amount'], 2) . '</td>';

    $statusBadge = match ((int)$tx['payment_status']) {
        1 => '<span class="badge badge-success">Completed</span>',
        0 => '<span class="badge badge-warning">Pending</span>',
        2 => '<span class="badge badge-danger">Failed</span>',
        default => '<span class="badge badge-light">Unknown</span>',
    };
    $rowsHtml .= '<td>' . $statusBadge . '</td>';

    $rowsHtml .= '<td>' . date('d M Y', strtotime($tx['created_at'])) . '</td>';
    $rowsHtml .= '</tr>';
}

include('components/table.php');
?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('components/scripts.html'); ?>

</body>

</html>
