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
    <title>Manage Users | ArtGallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900">
    <link rel="stylesheet" href="./assets/css/ready.css">
    <link rel="stylesheet" href="./assets/css/demo.css">
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
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h4 class="page-title">Manage Users</h4>
                        <!-- <a href="create_requests.php" class="btn btn-rounded btn-primary btn-sm">Submit New Request</a> -->
                    </div>

                    <!-- Start -->
                    <div class="card">
                        <div class="card-body">
                        <?php
                            // Fetch all users
                            $stmt = $pdo->query("
                                SELECT userID, name, email, role, status, created_at 
                                FROM users 
                                ORDER BY created_at DESC
                            ");
                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $headers = ['Name', 'Email', 'Role', 'Status', 'Joined', 'Actions'];
                            $rowsHtml = '';

                            foreach ($users as $user) {
                                $rowsHtml .= '<tr>';
                                $rowsHtml .= '<td>' . htmlspecialchars($user['name']) . '</td>';
                                $rowsHtml .= '<td>' . htmlspecialchars($user['email']) . '</td>';

                                $roleClass = $user['role'] === 'admin' ? 'danger' : 'info';
                                $rowsHtml .= '<td><span class="badge badge-' . $roleClass . '">' . ucfirst($user['role']) . '</span></td>';

                                $statusLabel = $user['status'] == 1 ? 'Active' : 'Inactive';
                                $statusClass = $user['status'] == 1 ? 'success' : 'secondary';
                                $rowsHtml .= '<td><span class="badge badge-' . $statusClass . '">' . $statusLabel . '</span></td>';

                                $rowsHtml .= '<td>' . date('d M Y', strtotime($user['created_at'])) . '</td>';

                                $toggleAction = $user['status'] == 1 ? 'disable' : 'enable';
                                $toggleLabel = $user['status'] == 1 ? 'Disable' : 'Enable';
                                $toggleClass = $user['status'] == 1 ? 'danger' : 'success';

                                $rowsHtml .= '<td>
                                    <a href="view_user.php?id=' . $user['userID'] . '" class="btn btn-sm btn-info">View</a>
                                    <a href="api/users/toggle_user_status.php?id=' . $user['userID'] . '&action=' . $toggleAction . '" 
                                    class="btn btn-sm btn-' . $toggleClass . '" 
                                    onclick="return confirm(\'Are you sure you want to ' . $toggleLabel . ' this user?\')">'
                                    . $toggleLabel . '</a>
                                </td>';

                                $rowsHtml .= '</tr>';
                            }

                            include('components/table.php');
                        ?>

                        </div>
                    </div>

                <!-- End -->
                </div>
            </div>
        </div>
        <!-- End of Main Panel -->
    </div>

    <?php include('components/scripts.html'); ?>
</body>

</html>