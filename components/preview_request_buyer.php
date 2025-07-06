<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Request Overview</h5>
        <?php if (empty($request['artistID'])): ?>
            <a href="cancel_request.php?id=<?= $requestID ?>" class="btn btn-rounded btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this request?');">Cancel Request</a>
            <?php else: ?>
                <?php if ($request['status'] == 1): ?>
                    <span class="btn btn-rounded btn-success btn-sm">Claimed</span>
                <?php elseif ($request['status'] == 2): ?>
                    <span class="btn btn-rounded btn-secondary btn-sm">Completed</span>
                <?php endif; ?>
            <?php endif; ?>
    </div>

    <p><span class="text-muted">Note: You can't cancel a request once an artist has claimed it.</span></p>

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
                            <img src="uploads/sketches/<?= htmlspecialchars($request['sketch_sample']) ?>" class="card-img">
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
                    <p class="card-text">Review the artist's submission and approve if satisfied.</p>

                    <p><strong>Status:</strong><br>
                        <span class="text-primary">
                            <?= $request['status'] == 1 ? 'In Progress' : ($request['status'] == 2 ? 'Completed' : 'Pending') ?>
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
                            <img src="uploads/sketches/<?= htmlspecialchars($request['uploaded_artwork']) ?>" class="card-img">
                        </div>

                        <!-- <div class="form-group">
                            <label class="fw-bold">Feedback</label>
                            <textarea class="form-control" rows="3" placeholder="Your feedback or comments..."></textarea>
                        </div>
                        <div class="pt-1">
                            <button type="submit" class="btn btn-outline-success btn-rounded btn-sm">Approve Submission</button>
                            <button class="btn btn-outline-danger btn-rounded btn-sm">Reject Submission</button>
                        </div> -->
                    <?php else: ?>
                        <p class="text-muted">No submission yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
