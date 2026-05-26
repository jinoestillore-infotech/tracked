<?php
require '../includes/db.php';
include 'process_index.php';
include 'process_admin.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

// CHECK IF ADMIN
if ($_SESSION['user']['role'] !== 'admin') {

    $_SESSION['error'] =
        "Access denied.";

    header("Location: ../dashboard/index.php");
    exit;
}

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$pageTitle = "TrackEd - Admin Dashboard";
include '../includes/header.php';
?>


<link href="../assets/css/admin_dashboard.css" rel="stylesheet">

</head>
<body>

<div class="container py-4">
    <!-- HEADER -->
    <div class="welcome-card mb-4">
        <div class="row align-items-center">
            <!-- BUTTON -->
            <div class="col-12 col-lg-4
                        order-1 order-lg-2
                        text-start text-lg-end mb-3 mb-lg-0">
                <a href="../dashboard/index.php"
                   class="btn btn-light btn-sm rounded-pill px-3 py-2">

                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
            <!-- TITLE -->
            <div class="col-12 col-lg-8 order-2 order-lg-1">
                <h2 class="fw-bold text-white mb-2">
                    Admin Dashboard
                </h2>
                <p class="text-light opacity-75 mb-0 small">
                    Monitor TrackEd users and activity.
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 mb-3">
        <div class="nav-card h-100">
            <h5 class="fw-bold text-light mb-4">
                Navigation
            </h5>
            <div class="d-grid nav-grid text-light">
                <a href="user_management.php" class="nav-link-custom">
                    <i class="bi bi-calendar3 text-light"></i>
                    User Management
                </a>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-3 mt-4">
        <!-- TOTAL USERS -->
        <div class="col-6 col-md-3">
            <div class="dashboard-card">
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3 class="fw-bold mb-1">
                    <?= $total_users; ?>
                </h3>
                <p class="text-secondary mb-0">
                    Total Users
                </p>
            </div>
        </div>

        <!-- ACTIVE USERS -->
        <div class="col-6 col-md-3">
            <div class="dashboard-card">
                <div class="stat-icon">
                    <i class="bi bi-activity"></i>
                </div>
                <h3 class="fw-bold mb-1">
                    <?= $active_users; ?>
                </h3>
                <p class="text-secondary mb-0">
                    Active Users
                </p>
            </div>
        </div>

        <!-- ACTIVE USERS -->
        <div class="col-6 col-md-3">
            <div class="dashboard-card">
                <div class="stat-icon">
                    <i class="bi bi-activity"></i>
                </div>
                <h3 class="fw-bold mb-1">
                    <?= $regular_users; ?>
                </h3>
                <p class="text-secondary mb-0">
                    Regular Users
                </p>
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