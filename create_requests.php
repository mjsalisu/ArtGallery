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
    <title>Create Artwork Request | ArtGallery</title>
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
                        <h4 class="page-title">Create Artwork Request</h4>
                        <a href="my_requests.php" class="btn btn-rounded btn-secondary btn-sm">Cancel</a>
                    </div>
                    <!-- Start -->
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Submit New Request</h5>
                                    <p class="text-muted text-center small">
                                        Submit your custom artwork request. Artists can review and respond.
                                    </p>
                                    <div id="message" class="alert d-none my-3"></div>

                                    <form action="api/custom_requests/create.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="requestTitle">Request Title</label>
                                            <input type="text" id="requestTitle" name="request_title" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="artworkSpecifications">Artwork Specifications</label>
                                            <textarea id="artworkSpecifications" name="specifications" class="form-control" rows="3" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="offeredPrice">Offered Price (₦)</label>
                                            <input type="number" id="offeredPrice" name="offered_price" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="sketchSample">Sketch Sample (Optional)</label>
                                            <input type="file" id="sketchSample" name="sketch_sample" accept="image/*" class="form-control-file">
                                            <small class="form-text text-muted">Upload a sketch or reference image if available.</small>
                                        </div>

                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-block btn-rounded mb-3">Submit Request</button>
                                    </form>
                                </div>
                            </div>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);
        const msgBox = document.getElementById("message");

        if (params.has("success") || params.has("error")) {
            const isSuccess = params.has("success");
            const message = isSuccess ? params.get("success") : params.get("error");

            msgBox.classList.remove("d-none");
            msgBox.classList.add("alert", isSuccess ? "alert-success" : "alert-danger");
            msgBox.textContent = decodeURIComponent(message);

            // Optionally clear URL parameters after showing message
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>

</html>