<?php

/* Highlights Pagination */
$highlightsLimit = 6;

$highlightsPage = isset($_GET['highlights_page'])
    ? (int)$_GET['highlights_page']
    : 1;

if ($highlightsPage < 1) {
    $highlightsPage = 1;
}

$highlightsOffset = ($highlightsPage - 1) * $highlightsLimit;

/* Count Total Highlights */
$countStmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM topic_highlights
    WHERE topic_id = ?
");

$countStmt->bind_param("i", $topic_id);
$countStmt->execute();

$countResult = $countStmt->get_result();
$totalHighlights = $countResult->fetch_assoc()['total'];

$totalHighlightsPages = ceil($totalHighlights / $highlightsLimit);

/* Fetch Paginated Highlights */
$highlightStmt = $conn->prepare("
    SELECT *
    FROM topic_highlights
    WHERE topic_id = ?
    ORDER BY created_at DESC
    LIMIT ? OFFSET ?
");

$highlightStmt->bind_param(
    "iii",
    $topic_id,
    $highlightsLimit,
    $highlightsOffset
);

$highlightStmt->execute();

$highlights = $highlightStmt->get_result();

?>

<!-- HIGHLIGHTS -->
<div class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 'highlights') ? 'show active' : ''; ?>"
     id="highlights">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-dark fw-bold mb-0">
            Topic Highlights
        </h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#addHighlightModal">
            <i class="bi bi-plus-lg"></i>
            Add Highlight
        </button>
    </div>
    <!-- Highlights -->
    <div class="row g-4">
        <?php if ($highlights->num_rows > 0): ?>
            <?php while ($highlight = $highlights->fetch_assoc()): ?>
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 subject-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="subject-icon">
                                        <i class="bi bi-stars"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-light mb-1">
                                            Important Highlight
                                        </h6>
                                        <small class="text-secondary">
                                            <?= date(
                                                "M d, Y",
                                                strtotime($highlight['created_at'])
                                            ); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <p class="text-light mb-2">
                                <?= nl2br(htmlspecialchars(mb_strimwidth($highlight['content'], 0, 190, '...'))); ?>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mb-2">
                            <!-- Actions -->
                            <div class="d-flex justify-content-end flex-wrap gap-1">
                                <button class="bg-transparent border-0 text-info rounded-pill mx-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewHighlightModal<?= $highlight['id']; ?>"
                                        title="View Highlight">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <!-- Edit -->
                                <button class="bg-transparent border-0 text-primary rounded-pill mx-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editHighlightModal<?= $highlight['id']; ?>"
                                        title="Edit Highlight">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <!-- Delete -->
                                <a href="process_delete_highlight.php?id=<?= $highlight['id']; ?>&topic_id=<?= $topic['id']; ?>"
                                   class="bg-transparent border-0 text-danger rounded-pill mx-1"
                                   onclick="return confirm('Delete this highlight?')"
                                   title="Delete Highlight">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- View Highlight Modal -->
                <div class="modal fade"
                    id="viewHighlightModal<?= $highlight['id']; ?>"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-md mb-5 pb-5 modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <!-- Header -->
                            <div class="modal-header border-0 pb-2">
                                <div>
                                    <h5 class="modal-title fw-bold">
                                        Highlight Details
                                    </h5>
                                    <small class="text-muted pb-1 mb-2">
                                        <?= date(
                                            "F d, Y • g:i A",
                                            strtotime($highlight['created_at'])
                                        ); ?>
                                    </small>
                                </div>
                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"></button>
                            </div>
                            <!-- Body -->
                            <div class="modal-body pt-3">
                                <div class="p-4 rounded-4 bg-light">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <i class="bi bi-stars text-warning"></i>
                                        <strong>
                                            Important Highlight
                                        </strong>
                                    </div>
                                    <p class="mb-0 text-dark"
                                    style="white-space: pre-line;">
                                        <?= htmlspecialchars($highlight['content']); ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Footer -->
                            <div class="modal-footer border-0 pt-0">
                                <button type="button"
                                        class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Highlight Modal -->
                <div class="modal fade"
                     id="editHighlightModal<?= $highlight['id']; ?>"
                     tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0">
                            <form action="process_edit_highlight.php"
                                  method="POST"
                                  data-loading-form>
                                <input type="hidden"
                                       name="id"
                                       value="<?= $highlight['id']; ?>">
                                <input type="hidden"
                                       name="topic_id"
                                       value="<?= $topic['id']; ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">
                                        Edit Highlight
                                    </h5>
                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label fw-semibold">
                                        Highlight Content
                                    </label>
                                    <textarea name="content"
                                              class="form-control"
                                              rows="5"
                                              required><?= htmlspecialchars($highlight['content']); ?></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                            class="btn btn-light"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="btn btn-primary"
                                            data-loading-button>
                                        <span class="btn-text">
                                            Save Changes
                                        </span>
                                        <span class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php include 'highlight_pagination.php'; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4 subject-card">
                    <div class="text-center">
                        <i class="bi bi-stars display-5 text-secondary"></i>
                        <h5 class="fw-bold text-light mt-3">
                            No Highlights Yet
                        </h5>
                        <p class="text-secondary mb-0">
                            Add important exam pointers and reviewer highlights.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>