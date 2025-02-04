<?php
// Define menu items as name => link
$menu_items = [
    'Home' => 'nav.php',
    'Browse Artworks' => 'browse_artworks.php',
    'Artist Profiles' => 'artist_profiles.php',
    'Custom Requests' => 'submit_request.php',
    'About' => 'about.php',
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Side Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            color: white;
            padding: 15px;
            transition: transform 0.3s ease;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 5px;
        }
        .sidebar-collapsed {
            transform: translateX(-100%);
        }
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1050;
            background-color: #343a40;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }
        @media (min-width: 768px) {
            .toggle-btn {
                display: none;
            }
            .sidebar {
                transform: none;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar sidebar-collapsed" id="sidebar">
    <h2>Art Platform</h2>
    <nav>
        <ul class="nav flex-column">
            <?php foreach ($menu_items as $name => $link): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $link; ?>">
                    <?php echo $name; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>

<!-- Toggle Button -->
<button class="toggle-btn" id="toggleSidebar">
    ☰
</button>

<!-- Main Content -->
<div class="content">
    <h1>Welcome to the Art Platform</h1>
    <p>This is where the main content will be displayed.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    // Toggle sidebar visibility
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-collapsed');
    });
</script>
</body>
</html>
