<?php
include 'process_study_planner.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$pageTitle = "TrackEd - Study Planner";
include '../includes/header.php';
?>

<link href="../assets/css/study_planner.css" rel="stylesheet">

</head>
<body>

<div class="container py-4">
    <!-- HEADER -->
    <div class="welcome-card mb-3">
        <div class="row align-items-center">
            <!-- BUTTON -->
            <div class="col-12 col-lg-4 
                        order-1 order-lg-2 
                        text-start text-lg-end mb-3 mb-lg-0">

                <a href="index.php"
                   class="btn btn-light btn-sm rounded-pill px-3 py-2">

                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard

                </a>
            </div>
            <!-- TITLE -->
            <div class="col-12 col-lg-8 order-2 order-lg-1">
                <h2 class="fw-bold text-white mb-2">
                    Study Planner
                </h2>
                <p class="text-light opacity-75 mb-0 small">
                    Organize your study sessions, deadlines, and learning goals.
                </p>
            </div>
        </div>
    </div>

    <!-- GUIDE -->
    <div class="guide-card mb-4" id="guideCard">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-info-circle-fill text-info"></i>

                <h5 class="fw-bold text-light mb-0">
                    Guide
                </h5>
            </div>
            <!-- HIDE -->
            <button class="btn btn-sm btn-outline-light rounded-pill px-3"
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
                            Create Study Plans
                        </h6>
                        <small class="text-light opacity-50">
                            Click &apos;Add Plan&apos; to add study schedules and organize your learning sessions.
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
                            Track Progress
                        </h6>
                        <small class="text-light opacity-50">
                            Monitor pending and completed study plans.
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
                            Stay Consistent
                        </h6>
                        <small class="text-light opacity-50">
                            Build better study habits and avoid missing deadlines.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold text-dark mb-1">
                Your Study Plans
            </h5>
            <small class="text-secondary">
                <?= $plans->num_rows; ?> total plans
            </small>
        </div>
        <button class="btn btn-primary btn-sm rounded-pill px-4"
                data-bs-toggle="modal"
                data-bs-target="#addPlanModal">
            <i class="bi bi-plus-lg"></i>
            Add Plan
        </button>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">
        <!-- Total Plans -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1">
                                Total Plans
                            </p>
                            <h3 class="fw-bold text-light mb-0">
                                <?= $totalPlans; ?>
                            </h3>
                        </div>
                        <div class="subject-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Completed Plans -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1">
                                Completed
                            </p>
                            <h3 class="fw-bold text-success mb-0">
                                <?= $completedPlans; ?>
                            </h3>
                        </div>
                        <div class="subject-icon">
                            <i class="bi bi-patch-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Plans -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1">
                                Pending
                            </p>
                            <h3 class="fw-bold text-warning mb-0">
                                <?= $pendingPlans; ?>
                            </h3>
                        </div>
                        <div class="subject-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- STUDY PLANS -->
    <div class="row g-4">
        <?php if ($plans->num_rows > 0): ?>
            <?php while ($plan = $plans->fetch_assoc()): ?>
                <?php
                    $today = strtotime(date('Y-m-d'));
                    $studyDate = strtotime($plan['study_date']);
                    $daysLeft =
                        ceil(($studyDate - $today) / 86400);
                    $badgeClass =
                        'bg-success-subtle text-success';
                    $countdown =
                        'Completed';
                    if ($plan['status'] !== 'Completed') {
                        if ($daysLeft < 0) {
                            $badgeClass =
                                'bg-danger-subtle text-danger';
                            $countdown =
                                'Overdue';
                        } elseif ($daysLeft == 0) {
                            $badgeClass =
                                'bg-danger-subtle text-danger';
                            $countdown =
                                'Today';
                        } elseif ($daysLeft <= 2) {
                            $badgeClass =
                                'bg-warning-subtle text-warning';
                            $countdown =
                                $daysLeft . ' day(s) left';
                        } else {
                            $badgeClass =
                                'bg-primary-subtle text-primary';
                            $countdown =
                                $daysLeft . ' day(s) left';
                        }
                    }
                ?>
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 subject-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="subject-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <span class="badge rounded-pill <?= $badgeClass; ?> px-3 py-2">
                                    <?= $countdown; ?>
                                </span>
                            </div>
                            <h5 class="fw-bold text-light mb-1">
                                <?= htmlspecialchars($plan['title']); ?>
                            </h5>
                            <p class="text-secondary small mb-4">
                                <?= nl2br(htmlspecialchars($plan['description'])); ?>
                            </p>
                            <!-- DETAILS -->
                            <div class="subject-details">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">
                                        Study Date
                                    </span>
                                    <span class="text-light fw-semibold">
                                        <?= date('M d, Y', strtotime($plan['study_date'])); ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">
                                        Study Time
                                    </span>
                                    <span class="text-light fw-semibold">
                                        <?= date('g:i A', strtotime($plan['study_time'])); ?>
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span class="text-secondary">
                                        Status
                                    </span>
                                    <span class="text-light fw-semibold">
                                        <?= htmlspecialchars($plan['status']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- FOOTER -->
                        <div class="card-footer border-0 bg-transparent pt-0">
                            <div class="d-flex flex-wrap justify-content-end gap-2">
                                <?php if ($plan['status'] !== 'Completed'): ?>
                                    <a href="process_complete_plan.php?id=<?= $plan['id']; ?>"
                                       class="btn btn-success btn-sm rounded-pill px-3">
                                        <i class="bi bi-check2-circle"></i>
                                        Complete
                                    </a>
                                <?php endif; ?>
                                <!-- EDIT -->
                                <button class="btn btn-outline-light btn-sm rounded-pill"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editPlanModal<?= $plan['id']; ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <!-- DELETE -->
                                <a href="process_delete_plan.php?id=<?= $plan['id']; ?>"
                                   class="btn btn-outline-danger btn-sm rounded-pill"
                                   onclick="return confirm('Delete this study plan?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>

            <!-- EMPTY STATE -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar-event display-4 text-muted"></i>
                        <h4 class="fw-bold mt-3">
                            No Study Plans Yet
                        </h4>
                        <p class="text-muted">
                            Create your first study session plan.
                        </p>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<!-- ADD PLAN MODAL -->
<div class="modal fade" id="addPlanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <form action="process_add_plan.php"
                  method="POST"
                  data-loading-form>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Add Study Plan
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- SUBJECT -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Subject
                        </label>
                        <select name="subject_id"
                                id="subjectSelect"
                                class="form-select"
                                required>
                            <option value="">
                                Select Subject
                            </option>
                            <?php while ($subject = $subjectsList->fetch_assoc()): ?>
                                <option value="<?= $subject['id']; ?>">
                                    <?= htmlspecialchars($subject['subject_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- TOPIC -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Topic
                        </label>
                        <select name="topic_id"
                                id="topicSelect"
                                class="form-select"
                                required>
                            <option value="">
                                Select Topic
                            </option>
                            <?php while ($topic = $topicsList->fetch_assoc()): ?>
                                <option value="<?= $topic['id']; ?>"
                                        data-subject="<?= $topic['schedule_id']; ?>"
                                        hidden>
                                    <?= htmlspecialchars($topic['topic_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <!-- DATE -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Study Date
                        </label>
                        <input type="date"
                            name="study_date"
                            class="form-control"
                            min="<?= date('Y-m-d'); ?>"
                            required>
                    </div>
                    <!-- NOTES -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Notes
                        </label>
                        <textarea name="notes"
                                class="form-control"
                                rows="3"
                                placeholder="Optional notes..."></textarea>
                    </div>
                    <!-- START TIME -->
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
                            Save Plan
                        </span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- TOAST -->
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
    guide.style.display =
        'none';
}
</script>
<script>
const subjectSelect =
    document.getElementById('subjectSelect');
const topicSelect =
    document.getElementById('topicSelect');
    subjectSelect.addEventListener('change', function () {
    const selectedSubject =
        this.value;

    topicSelect.value = "";
    Array.from(topicSelect.options).forEach(option => {
        if (option.value === "") {
            option.hidden = false;
            return;
        }
        if (
            option.dataset.subject === selectedSubject
        ) {
            option.hidden = false;
        } else {
            option.hidden = true;
        }
    });
});
</script>
<script src="../assets/js/button-loading.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>