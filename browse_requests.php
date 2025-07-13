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
    <title>Claim Artwork Request | ArtGallery</title>
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
                    <h4 class="page-title">Claim Artwork Request</h4>
                    <p class="text-muted">
                        Browse custom artwork requests posted by buyers and participate if it's unclaimed.
                    </p>
                    <!-- Start -->
                    <div class="card">
                        <div class="card-body">
                        <?php
                            // Fetch open custom requests for artist participation (excluding user's own)
                            $stmt = $pdo->prepare("
                            SELECT r.*, 
                                u.name AS buyer_name, 
                                a.name AS artist_name 
                            FROM custom_requests r
                            LEFT JOIN users u ON r.created_by = u.userID
                            LEFT JOIN users a ON r.artistID = a.userID
                            WHERE r.created_by != ? AND r.status != -1
                            ORDER BY r.status ASC, r.created_at DESC
                            ");
                            $stmt->execute([$user_id]);
                            $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $headers = ['Title', 'Budget (₦)', 'Buyer', 'Status', 'Date', 'Actions'];
                            $rowsHtml = '';

                            foreach ($requests as $request) {
                            $rowsHtml .= '<tr>';
                            $rowsHtml .= '<td>' . htmlspecialchars($request['request_title']) . '</td>';
                            $rowsHtml .= '<td>₦' . number_format($request['offered_price']) . '</td>';
                            $rowsHtml .= '<td>' . htmlspecialchars($request['buyer_name'] ?? '-') . '</td>';

                            $statusText = match ((int)$request['status']) {
                                1 => '<span class="badge badge-warning">In Progress</span>',
                                2 => '<span class="badge badge-success">Completed</span>',
                                default => '<span class="badge badge-light">Open</span>',
                            };
                            $rowsHtml .= '<td>' . $statusText . '</td>';
                            $rowsHtml .= '<td>' . date('d M Y', strtotime($request['created_at'])) . '</td>';

                            // Determine actions
                            if (is_null($request['artistID'])) {
                                // Not claimed yet
                                $rowsHtml .= '<td><a href="preview_request.php?id=' . $request['requestID'] . '" class="btn btn-sm btn-primary">Participate</a></td>';
                            } elseif ($request['artistID'] == $user_id) {
                                // Logged in artist has claimed it
                                $rowsHtml .= '<td><a href="preview_request.php?id=' . $request['requestID'] . '" class="btn btn-sm btn-info">View Submission</a></td>';
                            } else {
                                // Claimed by someone else
                                $rowsHtml .= '<td><span class="badge badge-secondary">Already Taken</span></td>';
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