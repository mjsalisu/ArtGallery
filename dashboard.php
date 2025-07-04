<?php
require 'api/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$user_role = $_SESSION["user_role"];

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Marketplace | ArtGallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900">
    <link rel="stylesheet" href="assets/css/ready.css">
    <link rel="stylesheet" href="assets/css/demo.css">
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
                    <h4 class="page-title">Marketplace</h4>

                    <!-- Filter Form -->
                    <form id="filterForm" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control" name="category">
                                    <option value="">Select Category</option>
                                    <option>Painting</option>
                                    <option>Sculpture</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="artist" class="form-control" placeholder="Artist">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="price_min" class="form-control" placeholder="Min Price">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="price_max" class="form-control" placeholder="Max Price">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Artwork Cards -->
                    <div class="row">
                        <?php for($i = 0; $i < 4; $i++): ?>
                        <div class="col-md-3 mb-3">
                            <a href="./artwork-cart.html">
                                <div class="card text-white position-relative">
                                    <img src="./assets/img/sample<?=$i?>.jpg" class="card-img">
                                    <div class="card-img-overlay d-flex justify-content-center align-items-center">
                                        <p class="card-text">Artwork description</p>
                                    </div>
                                    <span
                                        class="badge badge-count position-absolute top-0 start-0 m-2 bg-primary px-3 py-1">
                                        ₦45,000
                                    </span>
                                </div>
                            </a>
                        </div>
                        <?php endfor; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php include('components/scripts.html'); ?>
</body>

</html>