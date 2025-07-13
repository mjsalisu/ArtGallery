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
                    <p class="page-description">Explore and purchase artworks from our marketplace.</p>

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

                    <!-- Dynamic Artwork cards will be inserted here -->
                    <div class="row" id="artworkContainer"></div>

                </div>
            </div>
        </div>
    </div>

    <?php include('components/scripts.html'); ?>
</body>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("filterForm");
            const container = document.getElementById("artworkContainer");

            form.addEventListener("submit", function (e) {
                e.preventDefault();
                loadArtworks(new FormData(form));
            });

            // Initial load
            loadArtworks();

            function loadArtworks(formData = null) {
                let query = "";
                if (formData) {
                    const params = new URLSearchParams();
                    for (const [key, value] of formData.entries()) {
                        if (value.trim() !== "") {
                            const map = {
                                price_min: "minPrice",
                                price_max: "maxPrice"
                            };
                            params.append(map[key] || key, value);
                        }
                    }
                    query = "?" + params.toString();
                }

                fetch("api/artworks/list.php" + query)
                    .then(res => res.json())
                    .then(data => {
                        container.innerHTML = "";

                        if (data.length === 0) {
                            container.innerHTML = "<p class='text-muted'>No artworks found.</p>";
                            return;
                        }

                        data.forEach((art) => {
                            const card = document.createElement("div");
                            card.className = "col-md-3 mb-3";

                            card.innerHTML = `
                                <a href="view_artwork.php?id=${art.artworkID}">
                                    <div class="card text-white position-relative">
                                        <img src="${art.photo}" class="card-img" alt="${art.title}">
                                        <div class="card-img-overlay d-flex justify-content-center align-items-center">
                                            <p class="card-text">${art.description || 'Artwork description'}</p>
                                        </div>
                                        <span class="badge badge-count position-absolute top-0 start-0 m-2 bg-primary px-3 py-1">
                                            ₦${parseInt(art.price).toLocaleString()}
                                        </span>
                                    </div>
                                </a>
                            `;

                            container.appendChild(card);
                        });
                    })
                    .catch(err => {
                        console.error("Failed to fetch artworks:", err);
                        container.innerHTML = "<p class='text-danger'>Failed to load artworks.</p>";
                    });
            }
        });
    </script>

</html>