<?php require_once './api/auth.php'; ?>

<!-- Main Header -->
<div class="main-header">
    <div class="logo-header">
        <a href="dashboard.php" class="logo">ArtGallery</a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
    </div>

    <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid">
            <form class="navbar-left navbar-form nav-search mr-md-3" action="#">
                <div class="input-group">
                    <input type="text" placeholder="Search ..." class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-search search-icon"></i>
                        </span>
                    </div>
                </div>
            </form>

            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <img src="<?= htmlspecialchars($user['profile_photo'] ?? 'assets/img/profile.jpg') ?>"
                            alt="user-img" width="36" class="img-circle">
                        <span>
                            <?= htmlspecialchars($user['name']) ?>
                            <span class="badge badge-info ml-1">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <div class="user-box">
                                <div class="u-img">
                                    <img src="<?= htmlspecialchars($user['profile_photo'] ?? 'assets/img/profile.jpg') ?>"
                                        alt="user">
                                </div>
                                <div class="u-text">
                                    <h4>
                                        <?= htmlspecialchars($user['name']) ?>
                                    </h4>
                                    <p class="text-muted">
                                        <?= htmlspecialchars($user['email']) ?>
                                    </p>
                                    <a href="./profile.html" class="btn btn-rounded btn-danger btn-sm">My Profile</a>
                                </div>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="logoutUser(event)">
                            <i class="fa fa-power-off"></i> Logout
                        </a>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- End Main Header -->

<script>
    function logoutUser(event) {
        event.preventDefault();

        fetch('./api/users/logout.php', {
            method: 'POST'
        })
            .then(res => res.json())
            .then(data => {
                window.location.href = './login.html';
            })
            .catch(error => {
                console.error('Logout error:', error);
                window.location.href = './login.html';
            });
    }
</script>