<?php require_once './api/auth.php'; ?>

<div class="sidebar">
	<div class="scrollbar-inner sidebar-wrapper">
		
		<ul class="nav">
			<li class="nav-item active">
				<a href="dashboard.php">
					<i class="la la-dashboard"></i>
					<p>Explore Artworks</p>
				</a>
			</li>

			<li class="nav-item">
				<a href="my_requests.php">
					<i class="la la-paint-brush"></i>
					<p>Custom Artwork</p>
				</a>
			</li>

			<li class="nav-item">
				<a href="./my_order_history.php">
					<i class="la la-credit-card"></i>
					<p>Order History</p>
				</a>
			</li>

			<hr class="my-1">

			<li class="nav-item">
				<a href="./my_artworks.php">
					<i class="la la-photo"></i>
					<p>My Artworks</p>
				</a>
			</li>

			<li class="nav-item">
				<a href="browse_requests.php">
					<i class="la la-tasks"></i>
					<p>Claim a Request</p>
				</a>
			</li>

			<li class="nav-item">
				<a href="./my_sales.php">
					<i class="la la-money"></i>
					<p>My Sales</p>
				</a>
			</li>

			<hr class="my-1">

			<li class="nav-item">
				<a href="./users.php">
					<i class="la la-users"></i>
					<p>Manage Users</p>
				</a>
			</li>

			<li class="nav-item">
				<a href="./artworks.php">
					<i class="la la-check-circle"></i>
					<p>Manage Artworks</p>
				</a>
			</li>

			<li class="nav-item">
				<a href="./transactions.php">
					<i class="la la-files-o"></i>
					<p>Transactions</p>
				</a>
			</li>
			
			<?php if ($user['role'] === 'Artist') : ?>
				<li class="nav-item disabled text-center text-muted mt-2">
					<span class="badge badge-success">Artist Account</span>
				</li>
			<?php elseif ($user['role'] === 'Buyer') : ?>
				<li class="nav-item update-pro mt-3 text-center">
					<button class="btn btn-sm btn-outline-secondary btn-rounded"
						onclick="confirmUpgrade(event)">
						<p class="mb-0">Become an <strong>Artist</strong></p>
					</button>
			</li>
			<?php endif; ?>
			
		</ul>
	</div>
</div>

<script>
function confirmUpgrade(event) {
	event.preventDefault();
	if (confirm("Are you sure you want to become an Artist?")) {
		fetch('./api/users/upgrade.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ action: "upgrade" })
		})
		.then(res => res.json())
		.then(data => {
			alert(data.message || "Upgrade successful!");
			location.reload(); // Refresh to reflect new role
		})
		.catch(err => {
			console.error("Upgrade failed:", err);
			alert("Failed to upgrade role. Please try again.");
		});
	}
}
</script>
