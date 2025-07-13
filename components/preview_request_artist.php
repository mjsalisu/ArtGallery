<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Artwork Request Preview</h5>
    <a href="./browse_requests.php" class="btn btn-rounded btn-secondary btn-sm">
      See More Artwork Requests
    </a>
  </div>

  <div class="row row-card-no-pd">
    <!-- Request Info -->
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-body">
          <p><strong>Request Title:</strong><br><?= htmlspecialchars($request['request_title']) ?></p>
          <p><strong>Specifications:</strong><br><?= nl2br(htmlspecialchars($request['specifications'])) ?></p>
          <p><strong>Offered Price:</strong><br>₦<?= number_format($request['offered_price']) ?></p>
          <p><strong>Status:</strong><br>
            <span class="text-primary">
              <?= match ((int)$request['status']) {
                -1 => 'Cancelled',
                 0 => 'Pending',
                 1 => 'In Progress',
                 2 => 'Completed',
                 default => 'Unknown'
              } ?>
            </span>
          </p>

          <p><strong>Date:</strong><br><?= date('d M Y', strtotime($request['created_at'])) ?></p>

          <?php if (!empty($request['sketch_sample'])): ?>
            <div class="position-relative mb-3">
              <strong>Sketch Sample:</strong><br>
              <img src="uploads/sketches/<?= htmlspecialchars($request['sketch_sample']) ?>" class="card-img">
            </div>
          <?php endif; ?>

          <!-- Claim Button -->
          <?php if ($request['status'] >= 0 && empty($request['artistID'])): ?>
            <form action="claim_request.php" method="POST">
              <input type="hidden" name="requestID" value="<?= htmlspecialchars($request['requestID']) ?>">
              <button type="submit" class="btn btn-primary btn-rounded btn-sm mt-3">
                Indicate Interest
              </button>
            </form>
          <?php elseif ($isArtist): ?>
            <p class="mt-3 text-muted">You have already claimed this request.</p>
          <?php elseif (!empty($request['artistID'])): ?>
            <p class="mt-3 text-danger">This request has already been claimed by another artist.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Artist Submission -->
    <?php if ($isArtist): ?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Your Submitted Artwork</h5>

            <?php if (!empty($request['uploaded_artwork'])): ?>
              <div class="position-relative mb-3">
                <strong>Uploaded Image:</strong><br>
                <img src="uploads/sketches/<?= htmlspecialchars($request['uploaded_artwork']) ?>" class="card-img">
              </div>
              <?php if ((int)$request['status'] === 2): ?>
                <p class="text-success">This request has been marked as <strong>Completed</strong>.</p>
              <?php endif; ?>

            <?php else: ?>
              <form action="submit_artwork.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="requestID" value="<?= htmlspecialchars($request['requestID']) ?>">
                <div class="form-group">
                  <label>Upload Artwork</label>
                  <input type="file" name="uploaded_artwork" class="form-control-file" required>
                </div>
                <button type="submit" class="btn btn-primary btn-rounded btn-sm">
                  Submit Artwork
                </button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
