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
    <title>Upload New Artwork | ArtGallery</title>
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
                        <h4 class="page-title">Upload New Artwork</h4>
                        <a href="my_artworks.php" class="btn btn-rounded btn-secondary btn-sm">Cancel</a>
                    </div>
                    <!-- Start -->
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Upload New Artwork</h5>
                                    <p class="text-muted text-center">
                                        Upload your completed artwork for review and approval.</p>

                                    <div id="feedback" class="text-center my-3"></div>

                                    <form id="artworkForm" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="artworkCategory">Category</label>
                                                    <select id="artworkCategory" name="category" class="form-control" required>
                                                        <option value="">-- Select Category --</option>
                                                        <option value="painting">Painting</option>
                                                        <option value="sculpture">Sculpture</option>
                                                        <option value="digital_art">Digital Art</option>
                                                        <option value="photography">Photography</option>
                                                        <option value="mixed_media">Mixed Media</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="artworkTitle">Artwork Title</label>
                                                    <input type="text" id="artworkTitle" name="title" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="artworkDescription">Description</label>
                                            <textarea id="artworkDescription" name="description" class="form-control" rows="3" required></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="artworkType">Type</label>
                                                    <select id="artworkType" name="type" class="form-control" required onchange="toggleQuantityField()">
                                                        <option value="">-- Select Type --</option>
                                                        <option value="digital">Digital</option>
                                                        <option value="physical">Physical</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group" id="quantityGroup" style="display: none;">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="number" id="quantity" name="quantity" class="form-control" min="1">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="price">Price (₦)</label>
                                                    <input type="number" id="price" name="price" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="uploadArtwork">Upload Artwork</label>
                                                    <input type="file" id="uploadArtwork" name="photo" accept="image/*" class="form-control-file">
                                                    <small class="form-text text-muted">Upload the main artwork image.</small>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-block btn-rounded mb-3">Submit Artwork</button>
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
    <script>
        function toggleQuantityField() {
            const type = document.getElementById("artworkType").value;
            const quantityGroup = document.getElementById("quantityGroup");
            quantityGroup.style.display = type === "physical" ? "block" : "none";
        }
    </script>

    <script>
        const form = document.getElementById("artworkForm");
        const btn = document.getElementById("submitBtn");
        const msgBox = document.getElementById("feedback");

        form.addEventListener("submit", async function (e) {
            e.preventDefault();
            msgBox.classList.add("d-none");
            btn.disabled = true;
            btn.textContent = "Submitting...";

            const formData = new FormData(form);
            const payload = {};

            formData.forEach((value, key) => {
                payload[key] = value;
            });

            try {
                const response = await fetch("api/artworks/create.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                        
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();
                btn.disabled = false;
                btn.textContent = "Submit Request";

                msgBox.classList.remove("d-none");
                msgBox.className = "alert " + (data.message ? "alert-success" : "alert-danger");
                msgBox.textContent = data.message || data.error || "Something went wrong.";

                if (data.message) {
                    form.reset();
                    setTimeout(() => {
                        window.location.href = "my_requests.php";
                    }, 2500);
                }

            } catch (err) {
                console.error(err);
                btn.disabled = false;
                btn.textContent = "Submit Request";
                msgBox.className = "alert alert-danger";
                msgBox.textContent = "Something went wrong.";
                msgBox.classList.remove("d-none");
            }
        });
    </script>
</body>

</html>