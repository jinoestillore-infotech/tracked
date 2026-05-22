<!-- STUDY PLANS -->
    <div class="row g-4">
        <?php if ($plans->num_rows > 0): ?>
            <?php while ($plan = $plans->fetch_assoc()): ?>
                <?php
                    $today = strtotime(date('Y-m-d'));
                    $studyDate = strtotime($plan['study_date']);
                    $daysLeft =
                        ceil(($studyDate - $today) / 86400);
                    $badgeClass =
                        'bg-success-subtle text-success';
                    $countdown =
                        'Completed';
                    if ($plan['status'] !== 'Completed') {
                        if ($daysLeft < 0) {
                            $badgeClass =
                                'bg-danger-subtle text-danger';
                            $countdown =
                                'Overdue';
                        } elseif ($daysLeft == 0) {
                            $badgeClass =
                                'bg-danger-subtle text-danger';
                            $countdown =
                                'Today';
                        } elseif ($daysLeft <= 2) {
                            $badgeClass =
                                'bg-warning-subtle text-warning';
                            $countdown =
                                $daysLeft . ' day(s) left';
                        } else {
                            $badgeClass =
                                'bg-primary-subtle text-primary';
                            $countdown =
                                $daysLeft . ' day(s) left';
                        }
                    }
                ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 subject-card">
                        <div class="card-body d-flex flex-column">
                            <!-- TOP -->
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <div class="subject-icon flex-shrink-0">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <span class="badge rounded-pill <?= $badgeClass; ?> px-3 py-2 text-wrap">
                                    <?= $countdown; ?>
                                </span>
                            </div>
                            <!-- DETAILS -->
                            <div class="flex-grow-1">
                                <h5 class="fw-bold text-light mb-1 text-break">
                                    <?= htmlspecialchars($plan['subject_name']); ?>
                                </h5>
                                <p class="text-light opacity-75 mb-3 small text-break">
                                    <?= htmlspecialchars($plan['subject_code']); ?>
                                    <?php if ($plan['topic_name']): ?>
                                        : <?= htmlspecialchars($plan['topic_name']); ?>
                                    <?php endif; ?>
                                </p>
                                <div class="subject-details">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-1">
                                        <span class="text-secondary small">
                                            Study Date
                                        </span>
                                        <span class="text-light fw-semibold small text-end">
                                            <?= date('M d, Y', strtotime($plan['study_date'])); ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-1">
                                        <span class="text-secondary small">
                                            Study Time
                                        </span>
                                        <span class="text-light fw-semibold small text-end">
                                            <?= date('g:i A', strtotime($plan['start_time'])); ?>
                                            -
                                            <?= date('g:i A', strtotime($plan['end_time'])); ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <span class="text-secondary small">
                                            Status
                                        </span>
                                        <span class="text-light fw-semibold small text-end">
                                            <?= htmlspecialchars($plan['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FOOTER -->
                        <div class="card-footer border-0 bg-transparent pt-0 mt-2">
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <?php if ($plan['status'] !== 'Completed'): ?>
                                    <a href="process_complete_plan.php?id=<?= $plan['id']; ?>"
                                    class="btn btn-success btn-sm rounded-pill px-3">
                                        <i class="bi bi-check2-circle"></i>
                                        <span class="d-none d-sm-inline">
                                            Complete
                                        </span>
                                    </a>
                                <?php endif; ?>
                                <!-- EDIT -->
                                <button class="btn btn-outline-light btn-sm rounded-pill"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editPlanModal<?= $plan['id']; ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <!-- DELETE -->
                                <a href="process_delete_plan.php?id=<?= $plan['id']; ?>"
                                class="btn btn-outline-danger btn-sm rounded-pill"
                                onclick="return confirm('Delete this study plan?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>

            <!-- EMPTY STATE -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar-event display-4 text-muted"></i>
                        <h4 class="fw-bold mt-3">
                            No Study Plans Yet
                        </h4>
                        <p class="text-muted">
                            Create your first study session plan.
                        </p>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>