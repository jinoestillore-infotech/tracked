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
    <?php include 'study_stats.php'; ?>
    <?php include 'study_planner_tab.php'; ?>
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
                            <?php foreach ($subjectsList as $subject): ?>
                                <option value="<?= $subject['id']; ?>">
                                    <?= htmlspecialchars($subject['subject_name']); ?>
                                </option>
                            <?php endforeach; ?>
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
                            <?php foreach ($topicsList as $topic): ?>
                                <option value="<?= $topic['id']; ?>"
                                        data-subject="<?= $topic['schedule_id']; ?>"
                                        hidden>
                                    <?= htmlspecialchars($topic['topic_name']); ?>
                                </option>
                            <?php endforeach; ?>
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
<?php if (isset($_SESSION['open_modal'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal =
        new bootstrap.Modal(
            document.getElementById('addPlanModal')
        );

    modal.show();
});
</script>
<?php unset($_SESSION['open_modal']); ?>
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