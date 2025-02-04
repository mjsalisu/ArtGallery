<?php
// Include database connection
include 'db_connection.php';

// Fetch all requests that are pending
$query = "SELECT * FROM custom_requests WHERE status = 'Pending'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Custom Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>Review Custom Requests</h2>

        <!-- List Pending Requests -->
        <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Buyer Name</th>
                    <th>Email</th>
                    <th>Request Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($request = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <?php echo $request['id']; ?>
                    </td>
                    <td>
                        <?php echo $request['buyer_name']; ?>
                    </td>
                    <td>
                        <?php echo $request['email']; ?>
                    </td>
                    <td>
                        <?php echo $request['request_details']; ?>
                    </td>
                    <td>
                        <a href="approve_request.php?id=<?php echo $request['id']; ?>&action=approve"
                            class="btn btn-success btn-sm">Approve</a>
                        <a href="approve_request.php?id=<?php echo $request['id']; ?>&action=reject"
                            class="btn btn-danger btn-sm">Reject</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No pending requests found.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close database connection
mysqli_close($conn);
?>