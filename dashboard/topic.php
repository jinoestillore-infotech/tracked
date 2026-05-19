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
                <a href="subject.php?id=<?= $topic['schedule_id']; ?>&tab=topics"
                   class="btn btn-light btn-sm rounded-pill px-3 py-2">
                    <i class="bi bi-arrow-left"></i>
                    Back to Topics
                </a>
            </div>
            <!-- Topic Info -->
            <div class="col-12 col-lg-9
                        order-2 order-lg-1
                        text-center text-lg-start">
                <h3 class="fw-bold text-white mb-2">
                    <?= htmlspecialchars($topic['topic_name']); ?>
                </h3>
                <p class="text-light opacity-75 mb-2 text-break">
                    <?= htmlspecialchars($topic['description']); ?>
                </p>
                <span class="badge rounded-pill px-3 py-2
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
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <form action="process_add_highlight.php"
                  method="POST"
                  data-loading-form>
                <input type="hidden"
                       name="topic_id"
                       value="<?= $topic['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Add Highlight
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
                              placeholder="Important exam pointers..."
                              required></textarea>
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
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <form action="process_upload_file.php"
                  method="POST"
                  enctype="multipart/form-data"
                  data-loading-form>
                <input type="hidden"
                       name="topic_id"
                       value="<?= $topic['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Upload Learning File
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
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
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <form action="process_add_question.php"
                  method="POST"
                  data-loading-form>
                <input type="hidden"
                       name="topic_id"
                       value="<?= $topic['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        Add Practice Question
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
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