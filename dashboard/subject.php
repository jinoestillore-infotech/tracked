<?php
include 'process_subject.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$backUrl = $_SERVER['HTTP_REFERER'] ?? 'subjects.php';

$pageTitle = $subject['subject_name'];
include '../includes/header.php';
?>

<link href="../assets/css/subjects.css" rel="stylesheet">

</head>
<body>

<div class="container py-4">

    <!-- HEADER -->
    <div class="welcome-card mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-lg-3 
                        order-1 order-lg-2 
                        text-start text-lg-end mb-3 mb-lg-0">
                <a href="subjects.php"
                class="btn btn-light btn-sm rounded-pill px-3 py-2">
                    <i class="bi bi-arrow-left"></i>
                    Back to Subjects
                </a>
            </div>
            <!-- Subject Info -->
            <div class="col-12 col-lg-9 order-2 order-lg-1 text-center text-lg-start">
                <h3 class="fw-bold text-white mb-2">
                    <?= htmlspecialchars($subject['subject_name']); ?>
                </h4>
                <p class="text-light mb-1">
                    <i class="bi bi-person-fill me-1"></i>
                    <?= htmlspecialchars($subject['instructor']); ?>
                </p>
                <small class="text-light d-block">
                    <i class="bi bi-door-open-fill me-1"></i>
                    Room: <?= htmlspecialchars($subject['room']); ?>
                    <span class="mx-2">&dash;</span>
                    <i class="bi bi-award-fill me-1"></i>
                    Units: <?= htmlspecialchars($subject['units']); ?>
                </small>
            </div>
        </div>
    </div>

    <!-- TABS -->
    <?php include 'tabs.php'; ?>

    <div class="tab-content">
        <!-- OVERVIEW -->
        <?php include 'overview_tab.php'; ?>

        <!-- NOTES -->
        <?php include 'notes_tab.php'; ?>

        <!-- TASKS -->
        <?php include 'tasks_tab.php'; ?>

        <!-- TOPICS -->
        <?php include 'topics_tab.php'; ?>
    </div>
</div>

<div class="modal fade" id="addNoteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <form action="process_add_note.php" method="POST" data-loading-form>
                <input type="hidden" name="schedule_id" value="<?= $subject['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control" 
                        minlength="3" maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Content</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" data-loading-button>
                        <span class="btn-text">
                            Save Note
                        </span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <form action="process_add_task.php" method="POST" data-loading-form>
                <input type="hidden"
                       name="schedule_id"
                       value="<?= $subject['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Add Task
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>

                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Title
                        </label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Description
                        </label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Due Date
                        </label>
                        <input type="date"
                               name="due_date"
                               class="form-control"
                               min="<?= date('Y-m-d') ?>"
                               required>
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
                            Save Task
                        </span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addTopicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <form action="process_add_topic.php" method="POST" data-loading-form>
                <input type="hidden"
                       name="schedule_id"
                       value="<?= $subject['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Add Topic
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Topic Name -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Topic Name
                        </label>
                        <input type="text"
                               name="topic_name"
                               class="form-control"
                               minlength="3"
                               maxlength="100"
                               required>
                    </div>
                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Description
                        </label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"></textarea>
                    </div>
                    <!-- Mastery -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Mastery Level
                        </label>
                        <select name="mastery_level"
                                class="form-select">
                            <option value="Not Started">
                                Not Started
                            </option>
                            <option value="Studying">
                                Studying
                            </option>
                            <option value="Mastered">
                                Mastered
                            </option>
                        </select>
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
                                Save Topic
                        </span>
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
<script src="../assets/js/button-loading.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>