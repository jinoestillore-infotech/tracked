<?php
include 'process_index.php';

$user = $_SESSION['user'];
$pageTitle = $user['fullname'] . " - Dashboard";
include '../includes/header.php';
?>

<link href="../assets/css/dashboard.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg py-3">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center text-light m-0 p-0 " href="index.php">
        <img src="../assets/images/trackEd-icon1.png" alt="TrackEd"
            style="height: 30px; width: 50px; margin: 0px; padding: 0px;">
            TrackEd
        </a>
        <div class="ms-auto">
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm rounded-5 border border-2 me-2" title="Logout">
                <i class="bi bi-box-arrow-right text-danger fw-bold"></i>
            </a>
        </div>
    </div>
</nav>
<div class="container py-4">
<div class="row mb-4">
    <div class="col-12 col-sm-6">
        <div class="welcome-card">
            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <h2 class="fw-bold text-dark mb-2 lh-sm">
                        Welcome back!
                        
                    </h2>
                    <p class="mb-0 text-dark opacity-75 small">
                        Stay consistent and keep improving your learning progress.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="user-card">
            <div class="d-flex align-items-center justify-content-between mb-0">
                <div>
                    <h5 class="fw-bold text-white mb-0">
                        <?= htmlspecialchars($user['fullname']) ?>
                    </h5>
                </div>
                <div class="user-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="" class="btn btn-sm btn-glow">
                    <i class="bi bi-pencil-square me-1"></i>
                    Edit Profile
                </a>
                <a href="" class="btn btn-sm btn-outline-glow">
                    <i class="bi bi-gear me-1"></i>
                    Settings
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-4">
    <div class="nav-card h-100">
        <h5 class="fw-bold text-light mb-4">
            Navigation
        </h5>
        <div class="d-grid nav-grid text-light">
            <a href="schedules.php" class="nav-link-custom">
                <i class="bi bi-calendar3 text-light"></i>
                Schedules
            </a>
            <a href="subjects.php" class="nav-link-custom">
                <i class="bi bi-journal-text text-light"></i>
                Subjects
            </a>
            <a href="#" class="nav-link-custom">
                <i class="bi bi-check2-square text-light"></i>
                Topics
            </a>
            <a href="#" class="nav-link-custom">
                <i class="bi bi-calendar-event text-light"></i>
                Study Planner
            </a>
            <a href="#" class="nav-link-custom">
                <i class="bi bi-stickies text-light"></i>
                Notes
            </a>
        </div>
    </div>
    </div>

    <div class="col-12 col-lg-8">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="dashboard-card">
                <div class="stat-icon">
                    <i class="bi bi-journal-bookmark"></i>
                </div>
                <h3 class="fw-bold mb-1"><?= $total_subjects ?? 0; ?></h3>
                <p class="text-secondary mb-0">
                    Total Subjects
                </p>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="dashboard-card">
                <div class="stat-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <h3 class="fw-bold mb-1">0%</h3>
                <p class="text-secondary mb-0">
                    Overall Progress
                </p>
            </div>
        </div>
        <div class="col-12">
            <div class="dashboard-card">
                <div class="stat-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h3 class="fw-bold mb-1">0</h3>
                <p class="text-secondary mb-0">
                    Study Plans
                </p>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</body>
</html>