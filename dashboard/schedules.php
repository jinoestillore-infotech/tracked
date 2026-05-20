<?php
include 'process_schedules.php';

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$pageTitle = "TrackEd - Schedules";
include '../includes/header.php';
?>

<link href="../assets/css/schedules.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="welcome-card mb-3">
        <div class="row align-items-center g-4">
            <!-- Left Side -->
            <div class="col-12 col-lg-8">
                <!-- Back Button -->
                <a href="index.php"
                    class="btn btn-light btn-sm mb-3 rounded-pill p-2">
                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
                <h2 class="fw-bold text-white mb-2 lh-sm">
                    Schedules
                </h2>
                <p class="mb-0 text-light opacity-75 small">
                    Organize your weekly class schedule and subjects.
                </p>
            </div>
            <!-- Right Side -->
            <div class="col-12 col-lg-4 text-lg-end">
                <button class="btn btn-light fw-semibold rounded-pill px-4"
                        data-bs-toggle="modal"
                        data-bs-target="#addDayModal">
                    <i class="bi bi-plus-lg"></i>
                    Add Day
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
                            Create Schedule Days
                        </h6>
                        <small class="text-light opacity-50">
                            Click Add Day to create weekdays like Monday or Tuesday for your class schedules.
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
                            Open a Day Schedule
                        </h6>
                        <small class="text-light opacity-50">
                            Click a schedule card to view and manage subjects assigned for that day.
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
                            Monitor Subject Count
                        </h6>
                        <small class="text-light opacity-50">
                            Each schedule card displays the total number of subjects added for that day.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Days Grid -->
    <div class="row g-4">
        <?php if ($days->num_rows > 0): ?>
            <?php while ($day = $days->fetch_assoc()): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="day_schedule.php?id=<?= $day['id']; ?>"
                       class="text-decoration-none">
                        <div class="card shadow-sm border-0 h-100 schedule-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="fw-bold text-light mb-1">
                                            <?= htmlspecialchars($day['day_name']); ?>
                                        </h4>
                                        <p class=" text-secondary small mb-0">
                                            View subjects and schedules
                                        </p>
                                    </div>
                                    <div class="schedule-icon">
                                        <i class="bi bi-calendar3"></i>
                                    </div>
                                </div>
                                <p class="text-light small text-end mt-1 mb-0">
                                    <?= $day['subject_count']; ?> Subject<?= $day['subject_count'] != 1 ? 's' : ''; ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar-x display-4 text-muted"></i>
                        <h4 class="fw-bold mt-3">
                            No Schedule Days Yet
                        </h4>
                        <p class="text-muted">
                            Start by adding your first schedule day.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Day Modal -->
<div class="modal fade" id="addDayModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <form action="process_add_day.php" method="POST">
                <div class="modal-header border-0">
                    <div class="schedule-icon">
                        <i class="bi bi-calendar2-week fs-1"></i>
                    </div>
                    <h5 class="modal-title fw-bold ms-1">Add Schedule Days</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Select Day
                        </label>
                        <select name="day_name"
                                class="form-select"
                                required>
                            <option value="">Choose Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light border rounded-pill"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit"
                            class="btn btn-primary rounded-pill">
                        Add Day
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


