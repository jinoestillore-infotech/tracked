        <div class="tab-pane fade <?= (!isset($_GET['tab']) || $_GET['tab'] == 'overview') ? 'show active' : '' ?>" id="overview">
            <div class="card border-0 shadow-sm p-4 subject-card">
                <h5 class="fw-bold text-light mb-3">
                    Subject Overview
                </h5>
                <p class="text-secondary mb-0">
                    This is your learning workspace for
                    <strong><?= htmlspecialchars($subject['subject_name']); ?></strong>.
                    Here you can manage notes, assignments, and track your progress.
                </p>
            </div>
            <div class="row g-4 mt-1">
                <!-- Notes -->
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm subject-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-secondary small mb-1">
                                        Total Notes
                                    </p>
                                    <h3 class="fw-bold text-light mb-0">
                                        <?= $totalNotes; ?>
                                    </h3>
                                </div>
                                <div class="subject-icon">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tasks -->
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm subject-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-secondary small mb-1">
                                        Total Tasks
                                    </p>
                                    <h3 class="fw-bold text-light mb-0">
                                        <?= $totalTasks; ?>
                                    </h3>
                                </div>
                                <div class="subject-icon">
                                    <i class="bi bi-list-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Completed -->
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm subject-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-secondary small mb-1">
                                        Completed Tasks
                                    </p>
                                    <h3 class="fw-bold text-success mb-0">
                                        <?= $completedTasks; ?>
                                    </h3>
                                </div>
                                <div class="subject-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pending -->
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm subject-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-secondary small mb-1">
                                        Pending Tasks
                                    </p>
                                    <h3 class="fw-bold text-warning mb-0">
                                        <?= $pendingTasks; ?>
                                    </h3>
                                </div>
                                <div class="subject-icon">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>