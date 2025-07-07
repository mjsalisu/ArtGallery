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
    <title>My Artworks | ArtGallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900">
    <link rel="stylesheet" href="./assets/css/ready.css">
    <link rel="stylesheet" href="./assets/css/demo.css">
</head>

<body>
    <div class="wrapper">
        <!-- Header -->
        <?php include('components/header.php'); ?>

        <!-- Sidebar -->
        <?php include('components/sidebar.php'); ?>

        <!-- Main Panel -->
        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h4 class="page-title">My Artworks</h4>
                        <a href="create_artworks.php" class="btn btn-rounded btn-primary btn-sm">Upload New Artwork</a>
                    </div>

                    <!-- Start -->
                    <div class="card">
                        <div class="card-body">
                        <?php
                            $stmt = $pdo->prepare("
                                SELECT a.*, 
                                    COUNT(t.transactionID) AS total_sales
                                FROM artworks a
                                LEFT JOIN transaction t ON a.artworkID = t.artworkID AND t.payment_status = 'completed'
                                WHERE a.artistID = ?
                                GROUP BY a.artworkID
                                ORDER BY a.created_at DESC
                            ");
                            $stmt->execute([$user_id]);
                            $artworks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $headers = ['Title', 'Price (₦)', 'Submission Date', 'Type', 'Quantity', 'Sales', 'Status', 'Actions'];
                            $rowsHtml = '';

                            foreach ($artworks as $art) {
                                $rowsHtml .= '<tr>';
                                $rowsHtml .= '<td>' . htmlspecialchars($art['title']) . '</td>';
                                $rowsHtml .= '<td>₦' . number_format($art['price']) . '</td>';
                                $rowsHtml .= '<td>' . date('d M Y', strtotime($art['created_at'])) . '</td>';
                                $rowsHtml .= '<td>' . ucfirst($art['type']) . '</td>';

                                // Quantity logic
                                if ($art['type'] === 'physical') {
                                    $qty = intval($art['quantity']);
                                    $qtyBadge = $qty === 0
                                        ? '<span class="badge badge-danger">0</span>'
                                        : ($qty < 5
                                            ? '<span class="badge badge-warning">' . $qty . '</span>'
                                            : '<span class="badge badge-success">' . $qty . '</span>');
                                    $rowsHtml .= '<td>' . $qtyBadge . '</td>';
                                } else {
                                    $rowsHtml .= '<td><span class="badge badge-info">Unlimited</span></td>';
                                }

                                $rowsHtml .= '<td>' . intval($art['total_sales']) . '</td>';

                                // Status
                                $isSoldOut = $art['type'] === 'physical' && intval($art['total_sales']) >= intval($art['quantity']);
                                if ($isSoldOut) {
                                    $statusText = '<span class="badge badge-danger">Sold Out</span>';
                                } else {
                                    $statusText = $art['status']
                                        ? '<span class="badge badge-success">Active</span>'
                                        : '<span class="badge badge-secondary">Inactive</span>';
                                }

                                $rowsHtml .= '<td>' . $statusText . '</td>';
                                $rowsHtml .= '<td>
                                    <a href="view_artwork.php?id=' . $art['artworkID'] . '" class="btn btn-sm btn-info">View</a>
                                    <a href="toggle_artwork.php?id=' . $art['artworkID'] . '" class="btn btn-sm ml-1 ' . 
                                        ($art['status'] ? 'btn-danger' : 'btn-success') . '">' . 
                                        ($art['status'] ? 'Deactivate' : 'Activate') . 
                                    '</a>
                                </td>';
                                $rowsHtml .= '</tr>';
                            }

                            include('components/table.php');
                        ?>
                        </div>
                    </div>

                <!-- End -->
                </div>
            </div>
        </div>
        <!-- End of Main Panel -->
    </div>

    <?php include('components/scripts.html'); ?>
</body>

</html>