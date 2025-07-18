<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Request Overview</h5>

        <?php if ((int)$request['status'] === -1): ?>
            <span class="btn btn-rounded btn-danger btn-sm disabled">Cancelled</span>

        <?php elseif (empty($request['artistID'])): ?>
            <button 
                class="btn btn-rounded btn-danger btn-sm" 
                onclick="cancelRequest(<?= htmlspecialchars($requestID) ?>)">
                Cancel Request
            </button>

        <?php else: ?>
            <?php if ((int)$request['status'] === 1): ?>
                <span class="btn btn-rounded btn-success btn-sm">In Progress</span>
            <?php elseif ((int)$request['status'] === 2): ?>
                <span class="btn btn-rounded btn-secondary btn-sm">Completed</span>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div id="cancelFeedback" class="mt-2 d-none alert"></div>

    <?php if (empty($request['artistID']) && (int)$request['status'] !== 3): ?>
        <p><span class="text-muted">Note: You can't cancel a request once an artist has claimed it.</span></p>
    <?php endif; ?>

    <div class="row row-card-no-pd">
        <!-- Request Details -->
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Your Order</h5>
                    <p><strong>Request Title:</strong><br><?= htmlspecialchars($request['request_title']) ?></p>
                    <p><strong>Artwork Specifications:</strong><br><?= nl2br(htmlspecialchars($request['specifications'])) ?></p>
                    <p><strong>Offered Price (₦):</strong><br>₦<?= number_format($request['offered_price']) ?></p>

                    <?php if (!empty($request['sketch_sample'])): ?>
                        <div class="position-relative mb-3">
                            <strong>Sketch Sample:</strong><br>
                            <img src="<?= htmlspecialchars($request['sketch_sample']) ?>" class="card-img">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Artist Submission -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Artist Submission</h5>
                    <p class="card-text">Review the artist's submission and status below:</p>

                    <p><strong>Status:</strong><br>
                        <span class="text-primary">
                            <?= match ((int)$request['status']) {
                                1 => 'In Progress',
                                2 => 'Completed',
                                -1 => 'Cancelled',
                                default => 'Pending'
                            } ?>
                        </span>
                    </p>

                    <p><strong>Handled By (Artist):</strong><br>
                        <?php if (!empty($request['artistID'])): ?>
                            <a href="artist_profile.php?id=<?= urlencode($request['artistID']) ?>">
                                @<?= htmlspecialchars($request['artist_name'] ?? 'Artist') ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Awaiting artist participation</span>
                        <?php endif; ?>
                    </p>

                    <?php if (!empty($request['uploaded_artwork'])): ?>
                        <div class="position-relative mb-3">
                            <strong>Submitted Artwork:</strong><br>
                            <img src="<?= htmlspecialchars($request['uploaded_artwork']) ?>" class="card-img">
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No submission yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function cancelRequest(requestID) {
    if (!confirm("Are you sure you want to cancel this request?")) return;

    const feedback = document.getElementById("cancelFeedback");
    feedback.classList.add("d-none");

    fetch("api/custom_requests/cancel_request.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `requestID=${encodeURIComponent(requestID)}`
    })
    .then(res => res.json())
    .then(data => {
        feedback.classList.remove("d-none");
        feedback.className = "alert " + (data.success ? "alert-success" : "alert-danger");
        feedback.textContent = data.message || "Something went wrong.";

        if (data.success) {
            setTimeout(() => {
                window.location.href = "my_requests.php"; // redirect if needed
            }, 2000);
        }
    })
    .catch(error => {
        console.error("Cancellation error:", error);
        feedback.className = "alert alert-danger";
        feedback.textContent = "Failed to cancel the request.";
        feedback.classList.remove("d-none");
    });
}
</script>
