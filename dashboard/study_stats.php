    <!-- STATS -->
    <div class="row g-3 mb-4">
        <!-- Total Plans -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1">
                                Total Plans
                            </p>
                            <h3 class="fw-bold text-light mb-0">
                                <?= $totalPlans; ?>
                            </h3>
                        </div>
                        <div class="subject-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Completed Plans -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1">
                                Completed
                            </p>
                            <h3 class="fw-bold text-success mb-0">
                                <?= $completedPlans; ?>
                            </h3>
                        </div>
                        <div class="subject-icon">
                            <i class="bi bi-patch-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Plans -->
        <div class="col-6 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm subject-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1">
                                Pending
                            </p>
                            <h3 class="fw-bold text-warning mb-0">
                                <?= $pendingPlans; ?>
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