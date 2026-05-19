<?php
session_start();

$fieldErrors = $_SESSION['fieldErrors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['fieldErrors'], $_SESSION['old']);

$pageTitle = "TrackEd - Login Your Account";
include '../includes/header.php';

?>

<link href="../assets/css/login.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top p-1">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center m-0 p-0" href="../index.php">
            <img src="../assets/images/trackEd-logo2.png" alt="TrackEd"
            style="height: 60px; width: 110px; margin: 0px; padding: 0px;">
        </a>
    </div>
</nav>
<div class="auth-wrapper">
    <h2 class="fw-bold mb-2 text-center">Welcome back</h2>
    <p class="text-secondary mb-4 text-center">Login to your account</p>
    <form method="POST" action="process_login.php" style="width:100%;">
        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            <?php if (!empty($fieldErrors['email'])): ?>
                <small class="text-danger"><?= $fieldErrors['email'] ?></small>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password"
                   name="password"
                   class="form-control">
            <?php if (!empty($fieldErrors['password'])): ?>
                <small class="text-danger"><?= $fieldErrors['password'] ?></small>
            <?php endif; ?>
        </div>
        <button class="btn btn-primary w-100" style="background:#4f46e5; border:none;">
            Login
        </button>
        <p class="text-center mt-3 text-secondary">
            No account?
            <a href="register.php">Create one</a>
        </p>
    </form>
</div>
</body>
</html>