<?php
session_start();
$pageTitle = "TrackEd - Register An Account";
include '../includes/header.php';

$fieldErrors = $_SESSION['fieldErrors'] ?? [];
$old = $_SESSION['old'] ?? [];
$success = $_SESSION['success'] ?? "";

unset($_SESSION['fieldErrors'], $_SESSION['success'], $_SESSION['old']);
?>

<link href="../assets/css/register.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top p-1">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center m-0 p-0 " href="../index.php">
            <img src="../assets/images/trackEd-logo2.png" alt="TrackEd"
            style="height: 60px; width: 110px; margin: 0px; padding: 0px;">
        </a>
    </div>
</nav>
<section class="auth-wrapper">
    <div class="auth-box">
        <h2 class="fw-bold mb-2">Create account</h2>
        <p class="text-secondary mb-4">
            Start tracking your learning progress
        </p>

        
        <form method="POST" action="process_registration.php">
            <div class="mb-1">
                <label>Full name</label>
                <input type="text" name="fullname" class="form-control form-control-sm <?= !empty($fieldErrors['fullname']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
                <?php if (!empty($fieldErrors['fullname'])): ?>
                    <small class="text-danger"><?= $fieldErrors['fullname'] ?></small>
                <?php endif; ?>
            </div>
            <div class="mb-1">
                <label>Email</label>
                <input type="email" name="email" class="form-control form-control-sm <?= !empty($fieldErrors['email']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                <?php if (!empty($fieldErrors['email'])): ?>
                    <small class="text-danger"><?= $fieldErrors['email'] ?></small>
                <?php endif; ?>
            </div>
            <div class="mb-1">
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-sm <?= !empty($fieldErrors['password']) ? 'is-invalid' : '' ?>" required>
                <?php if (!empty($fieldErrors['password'])): ?>
                    <small class="text-danger"><?= $fieldErrors['password'] ?></small>
                <?php endif; ?>
            </div>
            <div class="mb-1">
                <label>Confirm password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-sm <?= !empty($fieldErrors['confirm_password']) ? 'is-invalid' : '' ?>" required>
                <?php if (!empty($fieldErrors['confirm_password'])): ?>
                    <small class="text-danger"><?= $fieldErrors['confirm_password'] ?></small>
                <?php endif; ?>
            </div>
            <div class="form-check mb-1">
                <input type="checkbox" class="form-check-input" id="showPasswords">
                <label class="form-check-label" for="showPasswords">
                    Show Passwords
                </label>
            </div>
            <button class="btn btn-primary btn-primary-custom w-100">
                Create account
            </button>
            <p class="text-center mt-3 text-secondary">
                Already have an account?
                <a href="login.php" class="text-decoration-none">Sign in</a>
            </p>
        </form>
    </div>
</section>
<div id="toast-container"></div>
<script src="../assets/js/toast.js"></script>
<script>
document.getElementById("showPasswords").addEventListener("change", function () {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");

    if (this.checked) {
        password.type = "text";
        confirmPassword.type = "text";
    } else {
        password.type = "password";
        confirmPassword.type = "password";
    }
});
</script>
<!-- Toastify JS -->
<?php if (!empty($success)): ?>
<script>
showToast("<?= htmlspecialchars($success) ?>", "success");
</script>
<?php endif; ?>

<?php foreach ($fieldErrors as $error): ?>
    <?php if (!empty($error)): ?>
    <script>
    showToast("<?= htmlspecialchars($error) ?>", "error");
    </script>
    <?php endif; ?>
<?php endforeach; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>