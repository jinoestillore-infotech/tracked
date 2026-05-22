<?php
include 'process_day_schedule.php';

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$pageTitle = $day['day_name'] . " Schedule";
include '../includes/header.php';
?>

<link href="../assets/css/day_schedule.css" rel="stylesheet">

</head>
<body>
<div class="container py-4">
    <div class="welcome-card mb-3">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <a href="schedules.php"
                   class="btn btn-light btn-sm mb-3 rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i>
                    Back to Schedules
                </a>
                <h2 class="fw-bold text-white mb-2">
                    <?= htmlspecialchars($day['day_name']); ?>
                </h2>
                <p class="text-light opacity-75 mb-0 small">
                    Manage your subjects and class schedules.
                </p>
            </div>
            <div class="col-12 col-lg-4 text-lg-end">
                <button class="btn btn-light fw-semibold rounded-pill px-4"
                        data-bs-toggle="modal"
                        data-bs-target="#addSubjectModal">
                    <i class="bi bi-plus-lg"></i>
                    Add Subject
                </button>
            </div>
        </div>
    </div>

    <!-- GUIDE -->
    <div class="guide-card mb-3" id="guideCard">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-info-circle-fill text-info"></i>
                <h5 class="fw-bold text-light mb-0">
                    Guide
                </h5>
            </div>
            <button class="btn btn-sm btn-outline-light rounded-pill p-2"
                    onclick="hideGuide()">
                <i class="bi bi-eye-slash"></i>
                Hide
            </button>
        </div>
        <div class="row g-3">
            <!-- STEP 1 -->
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="guide-badge">
                        1
                    </div>
                    <div>
                        <h6 class="fw-semibold text-light mb-1">
                            Add Subjects
                        </h6>
                        <small class="text-light opacity-50">
                            Click &apos;Add Subject&apos; to create class schedules with subject details, room, instructor, and time.
                        </small>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="guide-badge">
                        2
                    </div>
                    <div>
                        <h6 class="fw-semibold text-light mb-1">
                            Manage Subject Information
                        </h6>
                        <small class="text-light opacity-50">
                            Click a subject card to edit schedules, view details, or remove subjects from this day.
                        </small>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="guide-badge">
                        3
                    </div>
                    <div>
                        <h6 class="fw-semibold text-light mb-1">
                            Open Learning Workspace
                        </h6>
                        <small class="text-light opacity-50">
                            Click &apos;Go to&apos; to access notes, tasks, topics, files, highlights, and practice questions.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject List -->
    <div class="row g-4">
        <?php if ($scheduleResult->num_rows > 0): ?>
            <?php while ($subject = $scheduleResult->fetch_assoc()): ?>
                <div class="col-12 col-sm-4">
                    <div class="card border-0 shadow-sm subject-card h-100" data-bs-toggle="modal"
                         data-bs-target="#subjectModal<?= $subject['id']; ?>">
                        <div class="card-body m-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold mb-1 text-light">
                                        <?= htmlspecialchars($subject['subject_name']); ?>
                                    </h5>
                                    <p class="text-secondary mb-0">
                                        <?= date("g:i A", strtotime($subject['start_time'])); ?>

                                        -

                                        <?= date("g:i A", strtotime($subject['end_time'])); ?>
                                    </p>
                                </div>
                                <div class="subject-icon m-0">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 m-0">
                            <div class="text-end">
                                <a href="subject.php?id=<?= $subject['id']; ?>" class="text-decoration-none me-2">Go to</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade"
                    id="subjectModal<?= $subject['id']; ?>"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 p-2">
                            <!-- Header -->
                            <div class="modal-header border-0 pb-0">
                                <div>
                                    <h5 class="modal-title fw-bold mb-1">
                                        <?= htmlspecialchars($subject['subject_name']); ?>
                                    </h5>
                                    <small class="text-muted">
                                        Subject Details
                                    </small>
                                </div>
                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"></button>
                            </div>
                            <!-- Body -->
                            <div class="modal-body pt-3">
                                <div class="py-2 px-3 rounded-3 bg-light mb-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-calendar2-week text-primary"></i>
                                        <strong>Room</strong>
                                    </div>
                                    <div class="text-muted">
                                        <?= htmlspecialchars($subject['room']); ?>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded-3 bg-light mb-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-clock text-primary"></i>
                                        <strong>Time Schedule</strong>
                                    </div>
                                    <div class="text-muted">
                                        <?= date("g:i A", strtotime($subject['start_time'])); ?>
                                        →
                                        <?= date("g:i A", strtotime($subject['end_time'])); ?>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded-3 bg-light">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-person text-primary"></i>
                                        <strong>Instructor</strong>
                                    </div>
                                    <div class="text-muted">
                                        <?= htmlspecialchars($subject['instructor']); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Footer -->
                            <div class="modal-footer border-0 pt-0">
                                <div class="d-flex w-100 gap-2">
                                    <!-- Edit -->
                                    <a href="edit_subject.php?id=<?= $subject['id']; ?>"
                                    class="btn btn-primary w-50 rounded-pill">

                                        <i class="bi bi-pencil me-1"></i>
                                        Edit

                                    </a>
                                    <!-- Delete -->
                                    <a href="process_delete_subject.php?id=<?= $subject['id']; ?>&day_id=<?= $day_id; ?>"
                                    class="btn btn-outline-danger w-50 rounded-pill"
                                    onclick="return confirm('Are you sure you want to remove this subject?')">
                                    <span class="btn-text">
                                        <i class="bi bi-trash me-1"></i>
                                        Remove
                                    </span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar-x display-4 text-muted"></i>
                        <h4 class="fw-bold mt-3">
                            No Subjects Yet
                        </h4>
                        <p class="text-muted">
                            Add your first subject schedule.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content p-2">
            <form action="process_add_subject.php" method="POST" data-loading-form>
                <input type="hidden"
                       name="day_id"
                       value="<?= $day_id; ?>">
                <div class="modal-header border-0">
                    <div class="subject-icon">
                        <i class="bi bi-calendar2-week fs-1"></i>
                    </div>
                    <h5 class="modal-title fw-bold ms-1">
                        Add Subject
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Subject Code
                            </label>

                            <input type="text"
                                name="subject_code"
                                class="form-control"
                                placeholder="IT101">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                Subject Name
                            </label>
                            <input type="text"
                                name="subject_name"
                                class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Instructor
                        </label>

                        <input type="text"
                               name="instructor"
                               class="form-control"
                               placeholder="Prof. Dela Cruz">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Room
                            </label>

                            <input type="text"
                                name="room"
                                class="form-control"
                                placeholder="Room 204">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Units
                            </label>

                            <input type="number"
                                name="units"
                                class="form-control"
                                min="0"
                                placeholder="3">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Start Time
                            </label>
                            <input type="time"
                               name="start_time"
                               class="form-control"
                               required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                End Time
                            </label>
                            <input type="time"
                                name="end_time"
                                class="form-control"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light border rounded-pill"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit"
                            class="btn btn-primary rounded-pill"
                            data-loading-button>
                        <span class="btn-text">Save Subject</span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="toast-container"></div>
<script src="../assets/js/toast.js"></script>
<?php if (!empty($success)): ?>
<script>
showToast("<?= htmlspecialchars($success) ?>", "success");
</script>
<?php endif; ?>

<?php if (!empty($error)): ?>
<script>
showToast("<?= htmlspecialchars($error) ?>", "error");
</script>
<?php endif; ?>
<script>
function hideGuide() {
    const guide =
        document.getElementById('guideCard');
    guide.style.display = 'none';
}
</script>
<script src="../assets/js/button-loading.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
