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
    <title>My Artwork Requests | ArtGallery</title>
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="page-title">My Artwork Requests</h4>
                        <a href="create_requests.php" class="btn btn-rounded btn-primary btn-sm">Submit New Request</a>
                    </div>

                    <!-- Start -->
                    <div class="card">
                        <div class="card-body">
                        <?php
                            // Fetch data with artist info
                            $stmt = $pdo->prepare("
                                SELECT r.*, u.name AS artist_name 
                                FROM custom_requests r 
                                LEFT JOIN users u ON r.artistID = u.userID
                                WHERE r.created_by = ?
                            ");
                            $stmt->execute([$user_id]);
                            $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $headers = ['Title', 'Price (₦)', 'Artist', 'Status', 'Date', 'Actions'];
                            $rowsHtml = '';

                            foreach ($requests as $request) {
                                $rowsHtml .= '<tr>';
                                $rowsHtml .= '<td>' . htmlspecialchars($request['request_title']) . '</td>';
                                $rowsHtml .= '<td>₦' . number_format($request['offered_price']) . '</td>';

                                if ($request['artistID']) {
                                    $rowsHtml .= '<td>'.'<br>
                                            <a href="artist-profile.php?id=' . $request['artistID'] . '" class="btn btn-link">@' . htmlspecialchars($request['artist_name'] ?? '') . '</a>
                                        </td>';
                                } else {
                                    $rowsHtml .= '<td><span class="badge badge-secondary">Unclaimed</span></td>';
                                }

                                $statusText = match ($request['status']) {
                                    1 => '<span class="badge badge-warning">In Progress</span>',
                                    2 => '<span class="badge badge-success">Completed</span>',
                                    default => '<span class="badge badge-light">Pending</span>',
                                };
                                $rowsHtml .= '<td>' . $statusText . '</td>';

                                $rowsHtml .= '<td>' . date('d M Y', strtotime($request['created_at'])) . '</td>';
                                $rowsHtml .= '<td><a href="preview_request.php?id=' . $request['requestID'] . '" class="btn btn-sm btn-info">Preview</a></td>';
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