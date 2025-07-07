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
    <title>Artworks | ArtGallery</title>
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
                        <h4 class="page-title">Artworks</h4>
                        <!-- <a href="create_requests.php" class="btn btn-rounded btn-primary btn-sm">Submit New Request</a> -->
                    </div>

                    <!-- Start -->
                    <div class="card">
                        <div class="card-body">
                        <?php
                            // Fetch all artwork submissions with artist info
                            $stmt = $pdo->prepare("
                                SELECT a.*, u.name AS artist_name
                                FROM artworks a
                                JOIN users u ON a.artistID = u.userID
                                ORDER BY a.created_at DESC
                            ");
                            $stmt->execute();
                            $artworks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $headers = ['Artwork Title', 'Type', 'Artist', 'Price (₦)', 'Status', 'Actions'];
                            $rowsHtml = '';

                            foreach ($artworks as $art) {
                                $rowsHtml .= '<tr>';
                                $rowsHtml .= '<td>' . htmlspecialchars($art['title']) . '</td>';
                                $rowsHtml .= '<td>' . ucfirst(htmlspecialchars($art['type'])) . '</td>';
                                $rowsHtml .= '<td>' . htmlspecialchars($art['artist_name']) . '</td>';
                                $rowsHtml .= '<td>₦' . number_format($art['price']) . '</td>';

                                $statusLabel = match ((int)$art['status']) {
                                    0 => '<span class="badge badge-warning">Pending</span>',
                                    1 => '<span class="badge badge-success">Approved</span>',
                                    2 => '<span class="badge badge-secondary">Inactive</span>',
                                    3 => '<span class="badge badge-danger">Rejected</span>',
                                    default => '<span class="badge badge-light">Unknown</span>',
                                };
                                $rowsHtml .= '<td>' . $statusLabel . '</td>';

                                $rowsHtml .= '<td>
                                    <a href="view_artwork.php?id=' . $art['artworkID'] . '" class="btn btn-sm btn-info">Preview</a>
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