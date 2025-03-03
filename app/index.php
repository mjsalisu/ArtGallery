<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Marketplace | ArtGallery</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
		name='viewport' />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<link rel="stylesheet" href="assets/css/demo.css">
</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<div class="logo-header">
				<a href="index.html" class="logo">ArtGallery</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
					data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg">
				<div class="container-fluid">

					<form class="navbar-left navbar-form nav-search mr-md-3" action="">
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
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
								aria-expanded="false"> <img src="assets/img/profile.jpg" alt="user-img" width="36"
									class="img-circle"><span>Administrator</span></span> </a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<div class="user-box">
										<div class="u-img"><img src="assets/img/profile.jpg" alt="user"></div>
										<div class="u-text">
											<h4>Administrator</h4>
											<p class="text-muted">admin@email.com</p><a href="./profile.html"
												class="btn btn-rounded btn-danger btn-sm">View Profile</a>
										</div>
									</div>
								</li>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="../index.html"><i class="fa fa-power-off"></i> Logout</a>
							</ul>
							<!-- /.dropdown-user -->
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="sidebar">
			<?php include('./include/menu.php'); ?>
		</div>
		<div class="main-panel">
			<div class="content">
				<div class="container-fluid">
					<h4 class="page-title">Marketplace</h4>
					<div class="row row-card-no-pd">
						<div class="col-md-12">
							<!-- Filter Form -->
							<form method="GET" action="#">
								<div class="row">
									<div class="col-md-3">
										<select class="form-control form-control" name="category">
											<option value="">Select Category</option>
											<option value="Painting">Painting</option>
											<option value="Sculpture">Sculpture</option>
										</select>
									</div>
									<div class="col-md-3">
										<input type="text" name="artist" class="form-control" placeholder="Artist">
									</div>
									<div class="col-md-2">
										<input type="number" name="price_min" class="form-control"
											placeholder="Min Price">
									</div>
									<div class="col-md-2">
										<input type="number" name="price_max" class="form-control"
											placeholder="Max Price">
									</div>
									<div class="col-md-2">
										<button type="submit" class="btn btn-primary w-100">Filter</button>
									</div>
								</div>
							</form>
							<div class="card">
								<div class="card-body">
									<!-- Start -->
									<div class="row">
										<div class="col-md-3 mb-3">
											<a href="./artwork-cart.html">
												<div class="card text-white">
													<img src="./assets/img/color-vibes-ai-generated.avif"
														class="card-img">
													<div
														class="card-img-overlay d-flex flex-column justify-content-center text-center">
														<p class="card-text">A brief description of the artwork.</p>
													</div>
													<!-- Price Badge -->
													<span
														class="badge badge-count position-absolute top-0 start-0 m-2 bg-primary px-3 py-1">
														₦65,000
													</span>
												</div>
											</a>
										</div>

										<div class="col-md-3 mb-3">
											<a href="./artwork-cart.html">
												<div class="card text-white position-relative">
													<img src="./assets/img/Green_Sea_Turtle.jpg" class="card-img">
													<div
														class="card-img-overlay d-flex flex-column justify-content-center text-center">
														<p class="card-text">A brief description of the artwork.</p>
													</div>
													<!-- Price Badge -->
													<span
														class="badge badge-count position-absolute top-0 start-0 m-2 bg-primary px-3 py-1">
														₦25,000
													</span>
												</div>
											</a>
										</div>

										<div class="col-md-3 mb-3">
											<a href="./artwork-cart.html">
												<div class="card text-white">
													<img src="./assets/img/Texture.jpg" class="card-img">
													<div
														class="card-img-overlay d-flex flex-column justify-content-center text-center">
														<p class="card-text">A brief description of the artwork.</p>
													</div>
													<!-- Price Badge -->
													<span
														class="badge badge-count position-absolute top-0 start-0 m-2 bg-primary px-3 py-1">
														₦45,000
													</span>
												</div>
											</a>
										</div>

										<div class="col-md-3 mb-3">
											<a href="./artwork-cart.html">
												<div class="card text-white">
													<img src="./assets/img/color-vibes-ai-generated.avif"
														class="card-img">
													<div
														class="card-img-overlay d-flex flex-column justify-content-center text-center">
														<p class="card-text">A brief description of the artwork.</p>
													</div>
													<!-- Price Badge -->
													<span
														class="badge badge-count position-absolute top-0 start-0 m-2 bg-primary px-3 py-1">
														₦50,000
													</span>
												</div>
											</a>
										</div>

									</div>
									<!-- End -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chartist/chartist.min.js"></script>
<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>

</html>