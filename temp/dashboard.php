<?php
// Dashboard Template with Menus for Artist, Buyer, and Admin
session_start(); // Assuming login is handled and user roles are stored in session

// Dummy role check for demonstration
$user_role = $_SESSION['role'] ?? 'Buyer'; // Default to Buyer

function renderMenu($role) {
    switch ($role) {
        case 'Artist':
            return [
                'Upload Artwork' => 'upload_artwork.php',
                'Custom Requests' => 'custom_requests.php',
                'Manage Gallery' => 'manage_gallery.php',
            ];
        case 'Buyer':
            return [
                'Browse Artworks' => 'browse_artworks.php',
                'View Artist Profiles' => 'view_artist_profiles.php',
                'Custom Requests' => 'submit_custom_request.php',
                'Purchase History' => 'purchase_history.php',
            ];
        case 'Admin':
            return [
                'User Management' => 'user_management.php',
                'Artwork Approval' => 'artwork_approval.php',
                'Transaction Reports' => 'transaction_reports.php',
                'Dispute Resolution' => 'dispute_resolution.php',
            ];
        default:
            return [];
    }
}

$menu_items = renderMenu($user_role);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo ucfirst($user_role); ?> Dashboard
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Art Platform</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php foreach ($menu_items as $name => $link): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $link; ?>">
                            <?php echo $name; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- <h1 class="text-center">Welcome to the
            <?php echo ucfirst($user_role); ?> Dashboard
        </h1>
        <p class="text-center text-muted">Use the navigation bar to access your dashboard features.</p> -->

        <div class="card-body">
            <h4 class="card-title text-center mb-4">Account Management</h4>
            <form method="POST" action="">
                <?php if ($userRole === 'Buyer'): ?>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address"
                        required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>