<?php
include 'process_topic.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$pageTitle = $topic['subject_code'] . " - " . $topic['topic_name'];
include '../includes/header.php';
?>

<link href="../assets/css/subjects.css" rel="stylesheet">

</head>
<body>
<div class="container py-4">
    <!-- HEADER -->
    <div class="welcome-card mb-4">
        <div class="row align-items-center">
            <!-- Back -->
            <div class="col-12 col-lg-3
                        order-1 order-lg-2
                        text-start text-lg-end mb-3 mb-lg-0">
                <a href="index.php"
                   class="btn btn-light btn-sm rounded-pill px-3 py-2">
                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
            <!-- Topic Info -->
            <div class="col-12 col-lg-9
                        order-2 order-lg-1
                        text-center text-lg-start">
                    <span class="badge rounded-pill px-3 py-2 mb-2
                    <?=
                        $topic['mastery_level'] == 'Mastered'
                        ? 'bg-success'
                        : (
                            $topic['mastery_level'] == 'Studying'
                            ? 'bg-warning text-dark'
                            : 'bg-light text-dark'
                        );
                    ?>">
                    <?= $topic['mastery_level']; ?>
                </span>
                <h3 class="fw-bold text-white mb-0">
                    <?= htmlspecialchars($topic['topic_name']); ?>
                </h3>
                <p class="text-light opacity-75 mb-1 text-break">
                    <?= htmlspecialchars($topic['description']); ?>
                </p>
            </div>
        </div>
    </div>

    <?php include 'tabs_topic.php'; ?>

    <!-- TAB CONTENT -->
    <div class="tab-content">
        <!-- OVERVIEW -->
        <?php include 'overview_topic_tab.php'; ?>

        <!-- HIGHLIGHTS -->
        <?php include 'highlights_tab.php'; ?>

        <!-- FILES -->
        <?php include 'files_tab.php'; ?>

        <!-- QUESTIONS -->
        <?php include 'practice_questions_tab.php'; ?>
    </div>
</div>
<div class="modal fade"
     id="addHighlightModal"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <form action="process_add_highlight.php"
                  method="POST"
                  data-loading-form>
                <input type="hidden"
                       name="topic_id"
                       value="<?= $topic['id']; ?>">
                <div class="modal-header border-0">
                    <div class="modal-icon">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h5 class="modal-title fw-bold ms-1">
                        Add Highlight
                    </h5>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-semibold">
                        Highlight Content
                    </label>
                    <textarea name="content"
                              class="form-control"
                              rows="5"
                              placeholder="Important exam pointers..."
                              required></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light rounded-pill border"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit"
                            class="btn btn-primary rounded-pill"
                            data-loading-button>
                        <span class="btn-text">
                                Save Highlight
                        </span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade"
     id="uploadFileModal"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <form action="process_upload_file.php"
                  method="POST"
                  enctype="multipart/form-data"
                  data-loading-form>
                <input type="hidden"
                       name="topic_id"
                       value="<?= $topic['id']; ?>">
                <div class="modal-header border-0">
                    <div class="modal-icon">
                        <i class="bi bi-folder"></i>
                    </div>
                    <h5 class="modal-title fw-bold ms-1">
                        Upload Learning File
                    </h5>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-semibold">
                        Choose File
                    </label>
                    <input type="file"
                           name="file"
                           class="form-control"
                           required>
                    <small class="text-muted">
                        Allowed: PDF, DOCX, PPT, Images
                    </small>
                </div>
                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light rounded-pill border"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit"
                            class="btn btn-primary rounded-pill"
                            data-loading-button>
                        <span class="btn-text">
                                Upload File
                        </span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade"
     id="addQuestionModal"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <form action="process_add_question.php"
                  method="POST"
                  data-loading-form>
                <input type="hidden"
                       name="topic_id"
                       value="<?= $topic['id']; ?>">
                <div class="modal-header border-0">
                    <div class="modal-icon">
                        <i class="bi bi-patch-question"></i>
                    </div>
                    <h5 class="modal-title fw-bold ms-1">
                        Add Practice Question
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Question
                        </label>
                        <textarea name="question"
                                  class="form-control"
                                  rows="3"
                                  required></textarea>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">
                            Answer
                        </label>
                        <textarea name="answer"
                                  class="form-control"
                                  rows="4"
                                  required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light rounded-pill border"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit"
                            class="btn btn-primary rounded-pill"
                            data-loading-button>
                        <span class="btn-text">
                                Save Question
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