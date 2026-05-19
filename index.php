<?php
session_start();
$pageTitle = "Home - Student Learning Tracker";
include 'includes/header.php';
?>

<link href="assets/css/landing.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top px-4 navbar-custom">
    <a class="navbar-brand d-flex align-items-center m-0 p-0 " href="index.php">
    <img src="assets/images/trackEd-logo2.png" alt="TrackEd"
         style="height: 60px; width: 100px; margin: 0px; padding: 0px;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
            <li class="nav-item"><a class="nav-link" href="features.php">Features</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item ms-lg-3">
                <a href="auth/login.php" class="btn btn-outline-secondary btn-sm text-light">Login</a>
            </li>
            <li class="nav-item ms-lg-2">
                <a href="auth/register.php" class="btn btn-primary btn-sm btn-primary-custom">Get Started</a>
            </li>
        </ul>
    </div>
</nav>
<section class="hero text-center text-lg-start d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center m-0 p-0">
                <img src="assets/images/trackEd-landing1.png"
                     class="img-fluid" style="max-height: 350px;">
            </div>
            <div class="col-lg-6 mt-1 mt-lg-0 text-center text-lg-end">
                <h1 class="display-5">
                    Track Your Learning <br>
                    <span style="color:#a5b4fc;">Smarter & Faster</span>
                </h1>
                <p class="mt-3 text-light opacity-75">
                    Organize your subjects, track progress, and build <br />
                    better study habits all in one simple dashboard.
                </p>
                <a href="auth/register.php" class="btn btn-primary btn-lg btn-primary-custom mt-3">
                    Start Tracking Free
                </a>
            </div>
        </div>
    </div>
</section>

<section id="features" class="py-5" style="height: 80vh">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Everything You Need</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <i class="bi bi-journal-text fs-1 text-primary"></i>
                    <h5 class="mt-3">Subject Management</h5>
                    <p class="text-muted">Add and organize all your subjects easily.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <i class="bi bi-bar-chart fs-1 text-primary"></i>
                    <h5 class="mt-3">Progress Tracking</h5>
                    <p class="text-muted">See your learning progress in real-time.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <i class="bi bi-calendar-check fs-1 text-primary"></i>
                    <h5 class="mt-3">Study Planner</h5>
                    <p class="text-muted">Schedule your study sessions efficiently.</p>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="features.php"
                class="btn btn-primary btn-primary-custom btn-lg">
                    Explore Full Features
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">What Students Say</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded">
                    <p>“Helps me stay organized and consistent with studying.”</p>
                    <small class="text-muted">- Student A</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded">
                    <p>“My grades improved because I track everything now.”</p>
                    <small class="text-muted">- Student B</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded">
                    <p>“Simple but powerful tool for daily study planning.”</p>
                    <small class="text-muted">- Student C</small>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold">Why This System?</h2>
        <p class="text-muted mt-3 mx-auto" style="max-width:700px;">
            Most students struggle with disorganization and lack of tracking.
            This system solves that by combining subjects, topics, notes, and schedules
            into one clean dashboard designed for focus and productivity.
        </p>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="cta p-5 text-center">
            <h2 class="fw-bold">Start Organizing Your Studies Today</h2>
            <p class="mt-2">Join now and take control of your learning journey.</p>
            <a href="auth/register.php" class="btn btn-light btn-lg mt-2">Create Free Account</a>
        </div>
    </div>
</section>
<footer class="py-4 text-center">
    <div class="container">
        <p class="mb-0">© <?= date('Y') ?> Student Learning Tracker System</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>