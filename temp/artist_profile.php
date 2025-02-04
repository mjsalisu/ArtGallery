<?php
// Include database connection
include 'db_connection.php';

// Get the artist ID from the URL parameter
$artist_id = isset($_GET['id']) ? $_GET['id'] : die('Artist ID not specified');

// Fetch the artist details from the database
$query_artist = "SELECT * FROM artists WHERE artistID = '$artist_id'";
$result_artist = mysqli_query($conn, $query_artist);

// Check if the artist exists
if (mysqli_num_rows($result_artist) == 0) { 
    die('Artist not found'); 
}

$artist = mysqli_fetch_assoc($result_artist);

// Fetch the artist's galleries
$query_galleries = "SELECT * FROM galleries WHERE artist_id = '$artist_id'";
$result_galleries = mysqli_query($conn, $query_galleries);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">
            <?php echo $artist['name']; ?> - Artist Profile
        </h1>

        <!-- Artist Details Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <img src="<?php echo $artist['profile_picture']; ?>" class="img-fluid" alt="Artist Image">
            </div>
            <div class="col-md-8">
                <h3>About
                    <?php echo $artist['name']; ?>
                </h3>
                <p><strong>Biography:</strong>
                    <?php echo $artist['biography']; ?>
                </p>
                <p><strong>Location:</strong>
                    <?php echo $artist['location']; ?>
                </p>
                <p><strong>Art Style:</strong>
                    <?php echo $artist['art_style']; ?>
                </p>
                <p><strong>Website:</strong> <a href="<?php echo $artist['website']; ?>" target="_blank">
                        <?php echo $artist['website']; ?>
                    </a></p>
            </div>
        </div>

        <!-- Artist's Galleries Section -->
        <h3>Galleries</h3>
        <div class="row">
            <?php if (mysqli_num_rows($result_galleries) > 0): ?>
            <?php while ($gallery = mysqli_fetch_assoc($result_galleries)): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?php echo $gallery['image_url']; ?>" class="card-img-top" alt="Gallery Image">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $gallery['title']; ?>
                        </h5>
                        <p class="card-text">
                            <?php echo $gallery['description']; ?>
                        </p>
                        <a href="gallery_detail.php?id=<?php echo $gallery['id']; ?>" class="btn btn-primary">View
                            Gallery</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <p>This artist has no galleries yet.</p>
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