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
    <title>My Sales | ArtGallery</title>
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
                        <h4 class="page-title">My Sales</h4>
                        <!-- <a href="create_requests.php" class="btn btn-rounded btn-primary btn-sm">Submit New Request</a> -->
                    </div>

                    <!-- Start -->
                    <div class="card">
                        <div class="card-body">
                        <?php
                            // Fetch artworks sold by the logged-in artist
                            $stmt = $pdo->prepare("
                                SELECT t.*, a.title AS artwork_title, a.type AS artwork_type, u.name AS buyer_name
                                FROM transaction t
                                JOIN artworks a ON t.artworkID = a.artworkID
                                JOIN users u ON t.buyerID = u.userID
                                WHERE t.artistID = ?
                                ORDER BY t.created_at DESC
                            ");
                            $stmt->execute([$user_id]);  // $user_id is the logged-in artist
                            $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $headers = ['Artwork', 'Buyer Name', 'Price (₦)', 'Status', 'Sale Date', 'Action'];
                            $rowsHtml = '';

                            foreach ($sales as $sale) {
                                $rowsHtml .= '<tr>';
                                $rowsHtml .= '<td>' . htmlspecialchars($sale['artwork_title']) . '</td>';
                                $rowsHtml .= '<td>' . htmlspecialchars($sale['buyer_name']) . '</td>';
                                $rowsHtml .= '<td>₦' . number_format($sale['amount']) . '</td>';

                                $statusLabel = match ((int)$sale['payment_status']) {
                                    1 => '<span class="badge badge-success">Completed</span>',
                                    0 => '<span class="badge badge-warning">Pending</span>',
                                    2 => '<span class="badge badge-danger">Failed</span>',
                                    default => '<span class="badge badge-light">Unknown</span>',
                                };
                                $rowsHtml .= '<td>' . $statusLabel . '</td>';
                                $rowsHtml .= '<td>' . date('d M Y', strtotime($sale['created_at'])) . '</td>';

                                if ((int)$sale['payment_status'] === 1) {
                                    $label = strcasecmp($sale['artwork_type'], 'physical') === 0 ? 
                                             '<span class="badge badge-info">Delivered</span>' : 
                                             '<span class="text-muted">Released</span>';
                                    $rowsHtml .= "<td>$label</td>";
                                } else {
                                    $rowsHtml .= '<td><span class="text-muted">-</span></td>';
                                }                                

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