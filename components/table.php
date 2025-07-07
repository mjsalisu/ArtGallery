<table class="table table-striped">
    <thead>
        <tr>
            <?php foreach ($headers as $header): ?>
                <th><?= htmlspecialchars($header) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?= $rowsHtml ?>
        <?php if (empty($rowsHtml)): ?>
            <tr>
                <td colspan="<?= count($headers) ?>" class="text-center text-muted">No requests found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- <div class="table-responsive">
    <table id="<?= $tableID ?>" class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th><?= htmlspecialchars($header) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody id="<?= $tableID ?>_body">
            <tr><td colspan="<?= count($headers) ?>" class="text-center text-muted">Loading...</td></tr>
        </tbody>
    </table>
</div> -->
