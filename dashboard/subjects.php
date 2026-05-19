<?php
include 'process_subjects.php';

$pageTitle = "TrackEd - Subjects";
include '../includes/header.php';
?>

<link href="../assets/css/subjects.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
    <!-- Header -->
    <div class="welcome-card mb-3">
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
                    Subjects
                </h2>
                <p class="text-light opacity-75 mb-0 small">
                    View all your enrolled subjects and schedules.
                </p>
            </div>
        </div>
    </div>

    <!-- GUIDE -->
    <div class="guide-card mb-3" id="guideCard">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-info-circle-fill text-info"></i>
                <h5 class="fw-bold text-light mb-0">
                    Guide
                </h5>
            </div>
            <!-- Hide Button -->
            <button class="btn btn-sm btn-outline-light rounded-pill px-3"
                    onclick="hideGuide()">
                <i class="bi bi-eye-slash"></i>
                Hide
            </button>
        </div>
        <div class="row g-3">
            <!-- STEP 1 -->
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="guide-badge">
                        1
                    </div>
                    <div>
                        <h6 class="fw-semibold text-light mb-1">
                            Browse Subjects
                        </h6>
                        <small class="text-light opacity-50">
                            View all enrolled subjects along with instructors, schedules, rooms, and units.
                        </small>
                    </div>
                </div>
            </div>
            <!-- STEP 2 -->
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="guide-badge">
                        2
                    </div>
                    <div>
                        <h6 class="fw-semibold text-light mb-1">
                            Open Learning Workspace
                        </h6>
                        <small class="text-light opacity-50">
                            Click a subject card to access notes, assignments, topics, highlights, and files.
                        </small>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="col-md-4">
                <div class="guide-step">
                    <div class="guide-badge">
                        3
                    </div>
                    <div>
                        <h6 class="fw-semibold text-light mb-1">
                            Track Academic Progress
                        </h6>
                        <small class="text-light opacity-50">
                            Manage learning materials and monitor your study progress for every subject.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if ($subjects->num_rows > 0): ?>
            <?php while ($subject = $subjects->fetch_assoc()): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="subject.php?id=<?= $subject['id']; ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 subject-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="subject-icon">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                    <?= htmlspecialchars($subject['subject_code']); ?>
                                </span>
                            </div>
                            <h4 class="fw-bold text-light mb-1">
                                <?= htmlspecialchars($subject['subject_name']); ?>
                            </h4>
                            <p class="text-secondary mb-1">
                                <?= htmlspecialchars($subject['instructor']); ?>
                            </p>
                            <!-- Details -->
                            <div class="subject-details">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-secondary">
                                        Units
                                    </span>
                                    <span class="text-light fw-semibold">
                                        <?= htmlspecialchars($subject['units']); ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-secondary">
                                        Room
                                    </span>
                                    <span class="text-light fw-semibold">
                                        <?= htmlspecialchars($subject['room']); ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-secondary">
                                        Schedule
                                    </span>
                                    <span class="text-light fw-semibold">
                                        <?= htmlspecialchars($subject['schedule_summary']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-journal-x display-4 text-muted"></i>
                        <h4 class="fw-bold mt-3">
                            No Subjects Yet
                        </h4>
                        <p class="text-muted">
                            Add subjects from your schedules page.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'pagination.php'; ?>

</div>
<script>
function hideGuide() {
    const guide =
        document.getElementById('guideCard');
    guide.style.display = 'none';
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>