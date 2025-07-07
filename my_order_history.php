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
    <title>My Order History | ArtGallery</title>
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
                        <h4 class="page-title">My Order History</h4>
                        <!-- <a href="create_requests.php" class="btn btn-rounded btn-primary btn-sm">Submit New Request</a> -->
                    </div>

                    <!-- Start -->
                    <div class="card">
                        <div class="card-body">
                        <?php
                            
                            $stmt = $pdo->prepare("
                                SELECT t.*, a.title AS artwork_title, a.type AS artwork_type, a.photo AS artwork_file, u.name AS artist_name
                                FROM transaction t
                                JOIN artworks a ON t.artworkID = a.artworkID
                                JOIN users u ON t.artistID = u.userID
                                WHERE t.buyerID = ?
                                ORDER BY t.created_at DESC
                            ");
                            $stmt->execute([$user_id]);
                            $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $headers = ['Artwork Title', 'Artist', 'Price (₦)', 'Status', 'Purchase Date', 'Action'];
                            $rowsHtml = '';

                            foreach ($purchases as $purchase) {
                                $rowsHtml .= '<tr>';
                                $rowsHtml .= '<td>' . htmlspecialchars($purchase['artwork_title']) . '</td>';
                                $rowsHtml .= '<td>' . htmlspecialchars($purchase['artist_name']) . '</td>';
                                $rowsHtml .= '<td>₦' . number_format($purchase['amount']) . '</td>';

                                $statusBadge = match ($purchase['payment_status']) {
                                    1 => '<span class="badge badge-success">Paid</span>',
                                    2 => '<span class="badge badge-info">Delivered</span>',
                                    default => '<span class="badge badge-warning">Pending</span>',
                                };
                                $rowsHtml .= '<td>' . $statusBadge . '</td>';

                                $rowsHtml .= '<td>' . date('d M Y', strtotime($purchase['created_at'])) . '</td>';

                                if ($purchase['artwork_type'] === 'digital' && $purchase['payment_status'] === 1) {
                                    $rowsHtml .= '<td><a href="uploads/artworks/' . $purchase['artwork_file'] . '" class="btn btn-sm btn-primary" download>Download</a></td>';
                                } elseif ($purchase['artwork_type'] === 'physical' && $purchase['payment_status'] === 2) {
                                    $rowsHtml .= '<td><span class="text-success">Delivered</span></td>';
                                } else {
                                    $rowsHtml .= '<td><span class="text-muted">N/A</span></td>';
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