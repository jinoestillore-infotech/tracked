<div class="tab-pane fade <?= (!isset($_GET['tab']) || $_GET['tab'] == 'overview') ? 'show active' : ''; ?>"
     id="overview">

    <!-- Overview Intro -->
    <div class="card border-0 shadow-sm p-4 subject-card">
        <h5 class="fw-bold text-light mb-3">
            Topic Overview
        </h5>

        <p class="text-secondary mb-0">
            This workspace helps you organize your study materials,
            important highlights,
            files, and practice questions for
            <strong>
                <?= htmlspecialchars($topic['topic_name']); ?>
            </strong>.
        </p>
    </div>

    <!-- Stats -->
    <div class="row g-4 mt-1">

        <!-- Highlights -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <p class="text-secondary small mb-1">
                                Total Highlights
                            </p>

                            <h3 class="fw-bold text-light mb-0">
                                <?= $highlightCount ?? 0; ?>
                            </h3>
                        </div>

                        <div class="subject-icon">
                            <i class="bi bi-highlighter"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Files -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <p class="text-secondary small mb-1">
                                Total Files
                            </p>

                            <h3 class="fw-bold text-light mb-0">
                                <?= $fileCount ?? 0; ?>
                            </h3>
                        </div>

                        <div class="subject-icon">
                            <i class="bi bi-folder"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Questions -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <p class="text-secondary small mb-1">
                                Practice Questions
                            </p>

                            <h3 class="fw-bold text-light mb-0">
                                <?= $questionCount ?? 0; ?>
                            </h3>
                        </div>

                        <div class="subject-icon">
                            <i class="bi bi-patch-question"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>