<?php
$pageTitle = "About - TrackEd";
include 'includes/header.php';
?>

<link href="assets/css/landing.css" rel="stylesheet">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<section class="pt-5 mt-5 p-0 m-0">
    <div class="container-fluid">
        <div class="row align-items-center g-2">
            <div class="col-lg-6">
                <img src="assets/images/trackEd-icon1.png"
                     class="img-fluid">
            </div>
            <div class="col-lg-6">
                <h1 class="fw-bold">About TrackEd</h1>
                <p class="text-muted mt-3">
                    TrackEd is a Student Learning Tracker System designed to help<br />
                    students improve organization, productivity, and study habits.
                </p>
                <p class="text-muted">
                    The platform combines subject management, schedules, <br />
                    and learning progress tracking into one centralized dashboard.
                </p>
                <p class="text-muted">
                    This project was built to provide students with a simple, <br />
                    modern, and efficient learning management experience.
                </p>
                <a href="auth/register.php"
                   class="btn btn-primary btn-primary-custom mt-3">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
