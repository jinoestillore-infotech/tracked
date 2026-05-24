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
                                    <div class="text-light bg-secondary py-2 px-3 rounded-2 mt-2">
                                        <?= htmlspecialchars($plan['notes'] ?? '') ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FOOTER -->
                        <div class="card-footer border-0 bg-transparent pt-0 mt-2">
                            <div class="d-flex flex-wrap gap-2 justify-content-end mb-2">
                                <?php
                                $currentDateTime = strtotime(date('Y-m-d H:i:s'));
                                $planStart = strtotime(
                                    $plan['study_date'] . ' ' . $plan['start_time']
                                );
                                $planEnd = strtotime(
                                    $plan['study_date'] . ' ' . $plan['end_time']
                                );
                                $canComplete =
                                    $currentDateTime >= $planStart;
                                ?>
                                <?php if ($plan['status'] !== 'Completed'): ?>
                                    <?php if ($canComplete): ?>
                                        <a href="process_complete_plan.php?id=<?= $plan['id']; ?>"
                                        class="btn btn-success btn-sm rounded-pill px-3">
                                            <i class="bi bi-check2-circle"></i>
                                            Complete
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm rounded-pill px-3"
                                                disabled>
                                            <i class="bi bi-lock"></i>
                                            Locked
                                        </button>
                                    <?php endif; ?>
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
                    <!-- EDIT PLAN MODAL -->
                    <div class="modal fade" id="editPlanModal<?= $plan['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered mt-2">
                            <div class="modal-content border-0">
                                <form action="process_edit_plan.php"
                                    method="POST"
                                    data-loading-form>
                                    <input type="hidden"
                                        name="id"
                                        value="<?= $plan['id']; ?>">
                                    <div class="modal-header border-0">
                                        <div class="modal-icon">
                                            <i class="bi bi-pencil-square"></i>
                                        </div>
                                        <h5 class="modal-title fw-bold ms-1">
                                            Edit Study Plan
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <!-- SUBJECT -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Subject
                                            </label>
                                            <select name="subject_id"
                                                    class="form-select"
                                                    required>
                                                <option value="<?= $plan['subject_id']; ?>">
                                                    <?= htmlspecialchars($plan['subject_name']); ?>
                                                </option>
                                                <?php foreach ($subjectsList as $subject): ?>
                                                    <option value="<?= $subject['id']; ?>">
                                                        <?= htmlspecialchars($subject['subject_name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- TOPIC -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Topic
                                            </label>
                                            <select name="topic_id"
                                                    class="form-select">
                                                <option value="<?= $plan['topic_id']; ?>">
                                                    <?= htmlspecialchars($plan['topic_name'] ?? 'Select Topic'); ?>
                                                </option>
                                            </select>
                                        </div>
                                        <!-- DATE -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Study Date
                                            </label>
                                            <input type="date"
                                                name="study_date"
                                                class="form-control"
                                                value="<?= $plan['study_date']; ?>"
                                                required>

                                        </div>
                                        <!-- TIME -->
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    Start Time
                                                </label>
                                                <input type="time"
                                                    name="start_time"
                                                    class="form-control"
                                                    value="<?= $plan['start_time']; ?>"
                                                    required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">
                                                    End Time
                                                </label>
                                                <input type="time"
                                                    name="end_time"
                                                    class="form-control"
                                                    value="<?= $plan['end_time']; ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <!-- NOTES -->
                                        <div class="mb-1 mt-3">
                                            <label class="form-label fw-semibold">
                                                Notes
                                            </label>
                                            <textarea name="notes"
                                                    class="form-control"
                                                    rows="3"><?= htmlspecialchars($plan['notes'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button"
                                                class="btn btn-light rounded-pill border"
                                                data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary rounded-pill"
                                                data-loading-button>
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php include 'study_planner_pagination.php'; ?>
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