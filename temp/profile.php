<?php
session_start();

// Dummy user role for demonstration. Replace with session role variable.
$userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Buyer'; // Example: 'Buyer' or 'Artist'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $address = $_POST['address'] ?? '';
    $phoneNumber = $_POST['phone_number'] ?? '';
    $biography = $_POST['biography'] ?? '';

    // Example of saving the data (replace with actual DB logic)
    if ($userRole === 'Buyer') {
        echo "<script>alert('Buyer details updated successfully!');</script>";
    } elseif ($userRole === 'Artist') {
        echo "<script>alert('Artist profile updated successfully!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Account Management</h4>
                <form method="POST" action="">
                    <?php if ($userRole === 'Buyer'): ?>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="Enter your address" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            placeholder="Enter your phone number" required>
                    </div>
                    <?php elseif ($userRole === 'Artist'): ?>
                    <div class="mb-3">
                        <label for="biography" class="form-label">Biography</label>
                        <textarea class="form-control" id="biography" name="biography" rows="4"
                            placeholder="Tell us about yourself" required></textarea>
                    </div>
                    <?php endif; ?>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>