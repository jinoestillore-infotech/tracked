<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);
$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("
    SELECT security_question
    FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$userSecurity =
    $stmt->get_result()->fetch_assoc();

$currentQuestion =
$userSecurity['security_question'] ?? null;

$pageTitle = "Settings";
include '../includes/header.php';
?>

<link href="../assets/css/settings.css" rel="stylesheet">

</head>
<body>

<div class="container py-4">
    <!-- HEADER -->
    <div class="welcome-card mb-4">
        <div class="row align-items-center">
            <!-- Button -->
            <div class="col-12 col-lg-4 
                        order-1 order-lg-2 
                        text-start text-lg-end mb-3 mb-lg-0">
                <a href="index.php"
                class="btn btn-light btn-sm rounded-pill px-3 py-2">
                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>

            <!-- Subject Info -->
            <div class="col-12 col-lg-8 order-2 order-lg-1">
                <h2 class="fw-bold text-white mb-2">
                    Account Settings
                </h2>
                <p class="text-light opacity-75 mb-0 small">
                    Manage your security settings and password.
                </p>
            </div>
        </div>
    </div>

    <!-- SETTINGS GRID -->
    <div class="row g-4">
        <!-- SECURITY QUESTION -->
        <div class="col-12 col-xl-6">
            <div class="card border shadow-sm subject-card h-100">
                <div class="card-body p-4">
                    <!-- TITLE -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="settings-icon bg-primary-subtle text-primary me-3">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">
                                Security Question
                            </h5>
                            <p class="text-secondary small mb-0">
                                Used for account recovery and password reset.
                            </p>
                        </div>
                    </div>
                    <!-- FORM -->
                    <form action="process_security_question.php"
                          method="POST">
                        <!-- QUESTION -->
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">
                                Select Question
                            </label>
                            <select name="security_question"
                                    class="form-select form-control-custom"
                                    required>
                                <option value="">
                                    Choose a security question
                                </option>
                                <option value="What is your mother's maiden name?">
                                    What is your mother's maiden name?
                                </option>
                                <option value="What was your first school?">
                                    What was your first school?
                                </option>
                                <option value="What is your favorite food?">
                                    What is your favorite food?
                                </option>
                                <option value="What city were you born in?">
                                    What city were you born in?
                                </option>
                            </select>
                        </div>

                        <!-- ANSWER -->
                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">
                                Your Answer
                            </label>
                            <input type="text"
                                   name="security_answer"
                                   class="form-control form-control-custom"
                                   placeholder="Enter your answer"
                                   required>
                        </div>
                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-save me-1"></i>
                            Save Security Question
                        </button>
                    </form>
                    <!-- CURRENT SECURITY QUESTION -->
                    <div class="mt-4 pt-4 border-top">
                        <p class="text-secondary small mb-2 fw-semibold">
                            Current Security Question
                        </p>
                        <?php if (!empty($currentQuestion)): ?>
                            <div class="alert alert-success border-0 mb-0 rounded-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check me-2"></i>
                                    <span>
                                        <?= htmlspecialchars($currentQuestion); ?>
                                    </span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-secondary border-0 mb-0 rounded-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    <span>
                                        No security question added yet.
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHANGE PASSWORD -->
        <div class="col-12 col-xl-6">
            <div class="card border shadow-sm subject-card h-100">
                <div class="card-body p-4">
                    <!-- TITLE -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="settings-icon bg-warning-subtle text-warning me-3">
                            <i class="bi bi-key"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">
                                Change Password
                            </h5>
                            <p class="text-secondary small mb-0">
                                Update your account password securely.
                            </p>
                        </div>
                    </div>
                    <!-- FORM -->
                    <form action="process_change_password.php"
                          method="POST">
                        <!-- CURRENT -->
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">
                                Current Password
                            </label>
                            <input type="password"
                                   name="current_password"
                                   class="form-control form-control-custom"
                                   placeholder="Enter current password"
                                   required>
                        </div>
                        <!-- NEW -->
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold">
                                New Password
                            </label>
                            <input type="password"
                                   name="new_password"
                                   class="form-control form-control-custom"
                                   placeholder="Enter new password"
                                   required>
                        </div>
                        <!-- CONFIRM -->
                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold">
                                Confirm Password
                            </label>
                            <input type="password"
                                   name="confirm_password"
                                   class="form-control form-control-custom"
                                   placeholder="Confirm new password"
                                   required>
                        </div>
                        <!-- BUTTON -->
                        <button type="submit"
                                class="btn btn-warning px-4 rounded-pill">
                            <i class="bi bi-shield-check me-1"></i>
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
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
</body>
</html>