<?php
// Include database connection
include 'db_connection.php';

// Initialize filter variables with default values
$category_filter = '';
$artist_filter = '';
$price_min = '';
$price_max = '';

// Check if filter values are set via GET method
if (isset($_GET['category'])) {
    $category_filter = $_GET['category'];
}
if (isset($_GET['artist'])) {
    $artist_filter = $_GET['artist'];
}
if (isset($_GET['price_min'])) {
    $price_min = $_GET['price_min'];
}
if (isset($_GET['price_max'])) {
    $price_max = $_GET['price_max'];
}

// Prepare the base SQL query for selecting artworks
$query = "SELECT * FROM artworks WHERE 1=1";

// Add conditions based on filters
if ($category_filter) {
    $query .= " AND category = '$category_filter'";
}

if ($artist_filter) {
    $query .= " AND artist LIKE '%$artist_filter%'";
}

if ($price_min) {
    $query .= " AND price >= '$price_min'";
}

if ($price_max) {
    $query .= " AND price <= '$price_max'";
}

// Execute the query to fetch filtered artworks
$result = mysqli_query($conn, $query);

// Check if there are any artworks returned
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

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
            <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($artwork = mysqli_fetch_assoc($result)): ?>
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
            <?php else: ?>
            <p>No artworks found matching your criteria.</p>
            <?php endif; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw8f+ua7Kw1TIq0U6p6ZFE7e6wWReJ9f6fXY5tm7/1R8m2zA6XBv0fnkzApC7M"
        crossorigin="anonymous"></script>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>