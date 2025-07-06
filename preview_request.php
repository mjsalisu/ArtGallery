<?php
require './api/auth.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

$requestID = $_GET['id'];
$userID = $_SESSION['user_id'];

// Fetch request
$stmt = $pdo->prepare("
    SELECT r.*, 
           u.name AS buyer_name, 
           a.name AS artist_name 
    FROM custom_requests r
    LEFT JOIN users u ON r.created_by = u.artistID
    LEFT JOIN users a ON r.artistID = a.artistID
    WHERE r.requestID = ?
");
$stmt->execute([$requestID]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
    die("Request not found.");
}

// Determine viewer's role
$isBuyer = ($userID == $request['created_by']);
$isArtist = ($userID == $request['artistID']);
$alreadyClaimed = !empty($request['artistID']);

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Preview Artwork Request | ArtGallery</title>
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
                    <!-- Start -->
                    <div class="card">
                        <div class="card-body">
                            <?php if ($isBuyer): ?>
                                <!-- Include the buyer's version of the request preview -->
                                <?php include('components/preview_request_buyer.php'); ?>
                            <?php endif; ?>

                            <?php if (!$isBuyer): ?>
                                <!-- Include the artist's version -->
                                <?php include('components/preview_request_artist.php'); ?>
                            <?php endif; ?>
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