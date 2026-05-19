<?php
/* Tasks Pagination */
$tasksLimit = 4;
$tasksPage = isset($_GET['tasks_page'])
    ? (int)$_GET['tasks_page']
    : 1;

if ($tasksPage < 1) {
    $tasksPage = 1;
}

$tasksOffset = ($tasksPage - 1) * $tasksLimit;

/* Count Total Tasks */
$countStmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM subject_tasks
    WHERE schedule_id = ?
");

$countStmt->bind_param("i", $subject['id']);
$countStmt->execute();

$countResult = $countStmt->get_result();
$totalTasks = $countResult->fetch_assoc()['total'];

$totalTasksPages = ceil($totalTasks / $tasksLimit);

/* Fetch Paginated Tasks */
$stmt = $conn->prepare("
    SELECT *
    FROM subject_tasks
    WHERE schedule_id = ?
    ORDER BY due_date ASC
    LIMIT ? OFFSET ?
");

$stmt->bind_param(
    "iii",
    $subject['id'],
    $tasksLimit,
    $tasksOffset
);

$stmt->execute();

$tasks = $stmt->get_result();
?>

<div class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 'tasks') ? 'show active' : '' ?>"
     id="tasks">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-dark fw-bold mb-0">
            Assignments / Tasks
        </h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#addTaskModal">

            <i class="bi bi-plus-lg"></i>
            Add Task
        </button>
    </div>
    <?php if ($tasks->num_rows > 0): ?>
        <div class="row g-3">
            <?php while ($task = $tasks->fetch_assoc()): ?>
                <?php
                    $today = new DateTime();
                    $due = new DateTime($task['due_date']);
                    $diff = $today->diff($due)->days;
                    // overdue
                    if ($due < $today && $task['status'] != 'Completed') {
                        $priority = "Overdue";
                        $badgeClass = "bg-dark border";
                    }
                    // completed
                    elseif ($task['status'] == 'Completed') {
                        $priority = "Completed";
                        $badgeClass = "bg-success";
                    }
                    // due today
                    elseif ($diff == 0) {
                        $priority = "Due Today";
                        $badgeClass = "bg-danger";
                    }
                    // high priority
                    elseif ($diff <= 1) {
                        $priority = "High Priority";
                        $badgeClass = "bg-danger";
                    }
                    // medium
                    elseif ($diff <= 3) {
                        $priority = "Medium Priority";
                        $badgeClass = "bg-warning text-dark";
                    }
                    // low
                    else {
                        $priority = "Low Priority";
                        $badgeClass = "bg-primary";
                    }   
                    ?>
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card border-0 shadow-sm h-100 subject-card p-2 m-0 w-100">
                        <div class="card-body d-flex flex-column">
                            <!-- HEADER -->
                            <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-light mb-2 text-break">
                                        <?= htmlspecialchars($task['title']); ?>
                                    </h6>
                                </div>
                                <div>
                                    <span class="badge rounded-pill <?= $badgeClass; ?> flex-shrink-0 mb-2">
                                        <?= $priority; ?>
                                    </span>
                                </div>
                            </div>
                                <p class="text-secondary mb-2 text-break">
                                    <?= htmlspecialchars(mb_strimwidth($task['description'], 0, 110, '...')) ?>
                                    <?php if (mb_strlen($task['description']) > 110): ?>
                                        <span class="text-info small">
                                            view to see more
                                        </span>
                                    <?php endif; ?>
                                </p>
                            <!-- STATUS -->
                            <small class="mt-1
                                <?php
                                    if ($task['status'] == 'Completed') {
                                        echo "text-success";
                                    } elseif ($due < $today) {
                                        echo "text-danger";
                                    } elseif ($diff == 0) {
                                        echo "text-warning";
                                    } else {
                                        echo "text-light";
                                    }
                                ?>
                            ">
                                <?php
                                    if ($task['status'] == 'Completed') {
                                        echo "Task completed.";
                                    } elseif ($due < $today) {
                                        echo "Overdue.";
                                    } elseif ($diff == 0) {
                                        echo "Due today.";
                                    } else {
                                        echo $diff . " day(s) remaining.";
                                    }
                                ?>
                            </small>
                            <!-- FOOTER -->
                            <div class="mt-auto pt-3 d-flex justify-content-between align-items-center gap-2 flex-wrap">
                                <small class="text-light opacity-75">
                                    Due:
                                    <?= date("F d, Y", strtotime($task['due_date'])); ?>
                                </small>
                                <div class="d-flex gap-1 flex-wrap">
                                    <!-- COMPLETE -->
                                    <?php if ($task['status'] == 'Pending'): ?>
                                        <a href="process_complete_task.php?id=<?= $task['id']; ?>&subject_id=<?= $subject['id']; ?>"
                                        class="btn btn-outline-success btn-sm rounded-pill"
                                        title="Complete Task">
                                            <i class="bi bi-check-lg"></i>
                                        </a>
                                    <?php endif; ?>
                                    <!-- EDIT -->
                                    <?php if ($task['status'] == 'Pending'): ?>
                                        <button class="btn btn-outline-primary btn-sm rounded-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editTask<?= $task['id']; ?>"
                                                title="Edit Task">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    <?php endif; ?>
                                    <!-- DELETE -->
                                    <a href="process_delete_task.php?id=<?= $task['id']; ?>&subject_id=<?= $subject['id']; ?>"
                                    class="btn btn-outline-danger btn-sm rounded-pill"
                                    onclick="return confirm('Delete this task?')"
                                    title="Delete Task">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- EDIT TASK MODAL -->
                    <div class="modal fade"
                        id="editTask<?= $task['id']; ?>"
                        tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content border-0">
                                <form action="process_edit_task.php" method="POST" data-loading-form>
                                    <input type="hidden"
                                        name="id"
                                        value="<?= $task['id']; ?>">

                                    <input type="hidden"
                                        name="schedule_id"
                                        value="<?= $subject['id']; ?>">

                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">
                                            Edit Task
                                        </h5>
                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Title
                                            </label>
                                            <input type="text"
                                                name="title"
                                                class="form-control"
                                                value="<?= htmlspecialchars($task['title']); ?>"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Description
                                            </label>
                                            <textarea name="description"
                                                    class="form-control"
                                                    rows="4"
                                                    required><?= htmlspecialchars($task['description']); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Due Date
                                            </label>
                                            <input type="date"
                                                name="due_date"
                                                class="form-control"
                                                value="<?= $task['due_date']; ?>"
                                                min="<?= date('Y-m-d') ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-light"
                                                data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary"
                                                data-loading-button>
                                            <span class="btn-text">
                                                Update Task
                                            </span>
                                            <span class="spinner-border spinner-border-sm d-none"></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php include 'task_pagination.php'; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm p-4 subject-card">
                <div class="text-center">
                    <i class="bi bi-check2-square display-5 text-secondary"></i>
                    <h5 class="fw-bold text-light mt-3">
                        No Tasks Yet
                    </h5>
                    <p class="text-secondary mb-0">
                        No assignments or tasks yet. Add your first task to stay organized.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>