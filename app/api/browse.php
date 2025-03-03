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