<?php
require 'api/auth.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Custom Artwork | ArtGallery</title>
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

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="page-title">Custom Artwork Request Logs</h4>
                        <a href="submit-request.php" class="btn btn-primary">Submit New Request</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Request Title</th>
                                        <th>Offered Price (₦)</th>
                                        <th>Artist</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        require_once 'api/db.php';
                                        $stmt = $pdo->prepare("SELECT * FROM custom_requests WHERE user_id = ?");
                                        $stmt->execute([$user_id]);
                                        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($requests as $index => $req):
                                    ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($req['title']) ?></td>
                                            <td>₦<?= number_format($req['offered_price']) ?></td>
                                            <td><?= $req['artist_username'] ?? '-' ?></td>
                                            <td>
                                                <span class="badge badge-<?= match ($req['status']) {
                                                    'Submitted' => 'secondary',
                                                    'Accepted' => 'success',
                                                    'Rejected' => 'danger',
                                                    'Work in Progress' => 'warning',
                                                    default => 'light'
                                                } ?>">
                                                    <?= htmlspecialchars($req['status']) ?>
                                                </span>
                                            </td>
                                            <td><a href="request-preview.php?id=<?= $req['id'] ?>">Preview</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($requests)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No requests found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('components/scripts.html'); ?>
</body>

</html>