<?php
// Include database connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $buyer_name = mysqli_real_escape_string($conn, $_POST['buyer_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $request_details = mysqli_real_escape_string($conn, $_POST['request_details']);
    $status = 'Pending';  // Default status for new request

    // Insert the request into the database
    $query = "INSERT INTO custom_requests (buyer_name, email, request_details, status) 
              VALUES ('$buyer_name', '$email', '$request_details', '$status')";
    
    if (mysqli_query($conn, $query)) {
        echo "Request submitted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Custom Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>Submit Custom Request</h2>

        <!-- Request Submission Form -->
        <form method="POST" action="submit_request.php">
            <div class="mb-3">
                <label for="buyer_name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="buyer_name" name="buyer_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="request_details" class="form-label">Request Details</label>
                <textarea class="form-control" id="request_details" name="request_details" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close database connection
mysqli_close($conn);
?>