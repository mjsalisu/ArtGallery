<?php
// Assuming you have a database connection set up
include 'db_connection.php';

// Get filter parameters from URL (if any)
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$artist_filter = isset($_GET['artist']) ? $_GET['artist'] : '';
$price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
$price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';

// Prepare SQL query with filtering
$query = "SELECT * FROM artworks WHERE 1=1";

if ($category_filter) {
    $query .= " AND category = '$category_filter'";
}

if ($artist_filter) {
    $query .= " AND artist = '$artist_filter'";
}

if ($price_min) {
    $query .= " AND price >= '$price_min'";
}

if ($price_max) {
    $query .= " AND price <= '$price_max'";
}

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Artworks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Browse Artworks</h1>

        <!-- Filter Form -->
        <form method="GET" action="browse_artworks.php" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Select Category</option>
                        <option value="Painting" <?php echo ($category_filter=='Painting' ) ? 'selected' : '' ; ?>
                            >Painting</option>
                        <option value="Sculpture" <?php echo ($category_filter=='Sculpture' ) ? 'selected' : '' ; ?>
                            >Sculpture</option>
                        <!-- Add more categories as needed -->
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="artist" class="form-control" placeholder="Artist"
                        value="<?php echo $artist_filter; ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" name="price_min" class="form-control" placeholder="Min Price"
                        value="<?php echo $price_min; ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" name="price_max" class="form-control" placeholder="Max Price"
                        value="<?php echo $price_max; ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <!-- Artworks List -->
        <div class="row">
            <?php while ($artwork = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?php echo $artwork['image_url']; ?>" class="card-img-top" alt="Artwork Image">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $artwork['title']; ?>
                        </h5>
                        <p class="card-text">By
                            <?php echo $artwork['artist']; ?>
                        </p>
                        <p class="card-text">$
                            <?php echo number_format($artwork['price'], 2); ?>
                        </p>
                        <a href="artwork_detail.php?id=<?php echo $artwork['id']; ?>" class="btn btn-primary">View
                            Details</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw8f+ua7Kw1TIq0U6p6ZFE7e6wWReJ9f6fXY5tm7/1R8m2zA6XBv0fnkzApC7M"
        crossorigin="anonymous"></script>
</body>

</html>