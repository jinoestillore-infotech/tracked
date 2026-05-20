<div class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 'notes') ? 'show active' : '' ?>" id="notes">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-dark fw-bold mb-0">Notes</h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#addNoteModal">
            <i class="bi bi-plus-lg"></i> Add Note
        </button>
    </div>
    <?php
        /* Notes Pagination */
        $notesLimit = 6;
        $notesPage = isset($_GET['notes_page'])
            ? (int)$_GET['notes_page']
            : 1;
        if ($notesPage < 1) {
            $notesPage = 1;
        }
        $notesOffset = ($notesPage - 1) * $notesLimit;
        /* Count Notes */
        $countStmt = $conn->prepare("
            SELECT COUNT(*) as total
            FROM subject_notes
            WHERE schedule_id = ?
        ");
        $countStmt->bind_param("i", $subject['id']);
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalNotes = $countResult->fetch_assoc()['total'];
        $totalNotesPages = ceil($totalNotes / $notesLimit);

        /* Fetch Paginated Notes */
        $stmt = $conn->prepare("
            SELECT *
            FROM subject_notes
            WHERE schedule_id = ?
            ORDER BY created_at DESC
            LIMIT ? OFFSET ?
        ");

        $stmt->bind_param("iii",
            $subject['id'],
            $notesLimit,
            $notesOffset
        );

        $stmt->execute();
        $notes = $stmt->get_result();
    ?>
    <?php if ($notes->num_rows > 0): ?>
        <div class="row g-3">
            <?php while ($note = $notes->fetch_assoc()): ?>
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm h-100 subject-card p-2 m-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <h6 class="fw-bold text-light mb-0 text-break">
                                    <?= htmlspecialchars($note['title']); ?>
                                </h6>
                                <div class="">                             

                                </div>
                            </div>
                            <div class="text-secondary mb-0 p-2">
                                <?= htmlspecialchars(mb_strimwidth($note['content'], 0, 110, '...')) ?>
                                <?php if (mb_strlen($note['content']) > 110): ?>
                                    <span class="text-info small">view to see more</span>
                                <?php endif; ?>
                            </div>
                            <div class="mt-auto pt-3 d-flex justify-content-between gap-2">
                                <div class="">
                                    <small class="text-light opacity-75">
                                        <?= $note['created_at']; ?>
                                    </small>
                                </div>
                                <div>
                                    <a href="#"
                                        class="text-light text-decoration-none me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewNote<?= $note['id']; ?>"
                                        title="View Note">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#"
                                        class="text-primary text-decoration-none mx-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editNote<?= $note['id']; ?>"
                                        title="Edit Note">
                                        <i class="bi bi-pencil"></i>
                                    </a>  
                                    <a href="process_delete_note.php?id=<?= $note['id']; ?>&subject_id=<?= $subject['id']; ?>"
                                        class="text-danger mx-1"
                                        onclick="return confirm('Delete this note?')"
                                        title="Delete Note">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editNote<?= $note['id']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 p-2">
                            <form action="process_edit_note.php" method="POST" data-loading-form>
                                <input type="hidden" name="id" value="<?= $note['id']; ?>">
                                <input type="hidden" name="schedule_id" value="<?= $subject['id']; ?>">
                                <div class="modal-header border-0">
                                    <div class="modal-icon">
                                        <i class="bi bi-pencil-square"></i>
                                    </div>
                                    <h5 class="modal-title fw-bold ms-1">Edit Note</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Title</label>
                                        <input type="text"
                                            name="title"
                                            class="form-control"
                                            value="<?= htmlspecialchars($note['title']); ?>"
                                            minlength="3" maxlength="30"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Content</label>
                                        <textarea name="content"
                                                class="form-control"
                                                rows="5"
                                                required><?= htmlspecialchars($note['content']); ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light rounded-pill border" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary rounded-pill" data-loading-button>
                                        <span class="btn-text">
                                            Update Note
                                        </span>
                                        <span class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="viewNote<?= $note['id']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 p-2">
                            <!-- Header -->
                            <div class="modal-header border-0">
                                <div class="d-flex flex-column">
                                    <!-- Icon + Title -->
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="modal-icon">
                                            <i class="bi bi-eye"></i>
                                        </div>
                                        <h5 class="modal-title fw-bold mb-0 text-break">
                                            <?= htmlspecialchars($note['title']); ?>
                                        </h5>
                                    </div>
                                    <!-- Date below -->
                                    <small class="text-muted mt-1 ms-1">
                                        <?= $note['created_at']; ?>
                                    </small>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="modal-body">
                                <div class="p-3 rounded-3 bg-light text-secondary mb-2 overflow-auto" style="max-height: 200px;">
                                    <p class="mb-0 text-dark">
                                        <?= nl2br(htmlspecialchars($note['content'])); ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Footer -->
                            <div class="modal-footer border-0">
                                <button type="button"
                                        class="btn btn-light rounded-pill px-3 border"
                                        data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php include 'note_pagination.php'; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm p-4 subject-card">
                <div class="text-center">
                    <i class="bi bi-journal-text display-5 text-secondary"></i>
                    <h5 class="fw-bold text-light mt-3">
                        No Notes Yet
                    </h5>
                    <p class="text-secondary mb-0">
                        Start writing your lecture notes to keep track of important lessons.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
