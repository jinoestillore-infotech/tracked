<?php
include 'process_edit.php';

$pageTitle = $subject['subject_name'] . " - Edit Subject";

include '../includes/header.php';
?>
<link href="../assets/css/edit_subject.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <!-- Header -->
    <div class="welcome-card mb-4">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <h2 class="fw-bold text-white mb-2">
                    Edit Subject
                </h2>
                <p class="text-light opacity-75 mb-0 small">
                    Update your schedule details below.
                </p>
            </div>
        </div>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
    <div class="col-12 col-sm-8 mx-auto alert alert-success alert-dismissible fade show custom-alert"
         role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= $_SESSION['success']; ?>
        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="col-12 col-sm-8 mx-auto alert alert-danger alert-dismissible fade show custom-alert"
            role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <?= $_SESSION['error']; ?>
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Form Card -->
    <form action="process_edit_subject.php" method="POST">
        <input type="hidden" name="id" value="<?= $subject['id']; ?>">
        <input type="hidden" name="day_id" value="<?= $subject['day_id']; ?>">
        <div class="col-12 col-sm-8 mx-auto card border-0 shadow-lg rounded-4">
            <!-- Body -->
            <div class="card-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Subject Code
                        </label>

                        <input type="text"
                                name="subject_code"
                                class="form-control"
                                value="<?= htmlspecialchars($subject['subject_code']); ?>"
                                required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Subject Name</label>
                        <input type="text"
                            name="subject_name"
                            class="form-control form-control-lg"
                            value="<?= htmlspecialchars($subject['subject_name']); ?>"
                            required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Instructor
                    </label>

                    <input type="text"
                            name="instructor"
                            class="form-control"
                            value="<?= htmlspecialchars($subject['instructor']); ?>"
                            required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Room
                        </label>

                        <input type="text"
                            name="room"
                            class="form-control"
                            value="<?= htmlspecialchars($subject['room']); ?>"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Units
                        </label>

                        <input type="number"
                                name="units"
                                class="form-control"
                                min="0"
                                value="<?= htmlspecialchars($subject['units']); ?>"
                                required>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Start Time</label>
                        <input type="time"
                            name="start_time"
                            class="form-control form-control-lg"
                            value="<?= $subject['start_time']; ?>"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">End Time</label>
                        <input type="time"
                            name="end_time"
                            class="form-control form-control-lg"
                            value="<?= $subject['end_time']; ?>"
                            required>
                    </div>

                </div>

            </div>

            <!-- Footer (INSIDE FORM) -->
            <div class="card-footer bg-white border-0 p-4">

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary w-50 rounded-pill fw-semibold">

                        Save Changes

                    </button>

                    <a href="day_schedule.php?id=<?= $subject['day_id']; ?>"
                    class="btn btn-light border w-50 rounded-pill">

                        Cancel

                    </a>

                </div>

            </div>

        </div>

    </form>

</div>
</body>
</html>