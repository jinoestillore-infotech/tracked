<?php

/* Topics Pagination */
$topicsLimit = 6;

$topicsPage = isset($_GET['topics_page'])
    ? (int)$_GET['topics_page']
    : 1;

if ($topicsPage < 1) {
    $topicsPage = 1;
}

$topicsOffset = ($topicsPage - 1) * $topicsLimit;

/* Count Total Topics */
$countStmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM subject_topics
    WHERE schedule_id = ?
");

$countStmt->bind_param("i", $subject['id']);
$countStmt->execute();

$countResult = $countStmt->get_result();
$totalTopics = $countResult->fetch_assoc()['total'];

$totalTopicsPages = ceil($totalTopics / $topicsLimit);

/* Fetch Paginated Topics */
$stmt = $conn->prepare("
    SELECT *
    FROM subject_topics
    WHERE schedule_id = ?
    ORDER BY created_at DESC
    LIMIT ? OFFSET ?
");

$stmt->bind_param(
    "iii",
    $subject['id'],
    $topicsLimit,
    $topicsOffset
);

$stmt->execute();

$topics = $stmt->get_result();

?>

<div class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 'topics') ? 'show active' : '' ?>"
     id="topics">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-dark fw-bold mb-0">
            Topics Tracker
        </h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#addTopicModal">

            <i class="bi bi-plus-lg"></i>
            Add Topic
        </button>
    </div>

    <!-- Topics List -->
    <div class="row g-4">
        <?php if ($topics->num_rows > 0): ?>
            <?php while ($topic = $topics->fetch_assoc()): ?>
                <div class="col-12 col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 subject-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="subject-icon">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <span class="badge rounded-pill
                                        <?=
                                            $topic['mastery_level'] == 'Mastered'
                                            ? 'bg-success'
                                            : (
                                                $topic['mastery_level'] == 'Studying'
                                                ? 'bg-warning text-dark'
                                                : 'bg-light text-dark'
                                            );
                                        ?>">
                                        <?= $topic['mastery_level']; ?>
                                    </span>
                                </div>
                                <h5 class="fw-bold text-light mb-2">
                                    <?= htmlspecialchars($topic['topic_name']); ?>
                                </h5>
                                <p class="text-secondary small mb-0">
                                    <?= htmlspecialchars(
                                        strlen($topic['description']) > 90
                                        ? substr($topic['description'], 0, 90) . '...'
                                        : $topic['description']
                                    ); ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0 mb-2">
                                <div class="d-flex justify-content-between gap-2 mt-1 text-end">
                                    <div>
                                        <small class="text-light opacity-75">
                                            <?= $topic['created_at']; ?>
                                        </small>
                                    </div>
                                    <div>
                                        <!-- OPEN -->
                                        <a href="topic.php?id=<?= $topic['id']; ?>"
                                        class="btn btn-outline-light btn-sm rounded-pill"
                                        title="Open Topic">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                        </a>
                                        <!-- EDIT -->
                                        <button class="btn btn-outline-primary btn-sm rounded-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editTopicModal<?= $topic['id']; ?>"
                                                title="Edit Topic">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- DELETE -->
                                        <a href="process_delete_topic.php?id=<?= $topic['id']; ?>&schedule_id=<?= $subject['id']; ?>"
                                        class="btn btn-outline-danger btn-sm rounded-pill"
                                        onclick="return confirm('Delete this topic?')"
                                        title="Delete Topic">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Edit Topic Modal -->
                <div class="modal fade"
                    id="editTopicModal<?= $topic['id']; ?>"
                    tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0">
                            <form action="process_edit_topic.php"
                                method="POST">
                                <input type="hidden"
                                    name="id"
                                    value="<?= $topic['id']; ?>">
                                <input type="hidden"
                                    name="schedule_id"
                                    value="<?= $subject['id']; ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">
                                        Edit Topic
                                    </h5>
                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Topic Name -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Topic Name
                                        </label>
                                        <input type="text"
                                            name="topic_name"
                                            class="form-control"
                                            value="<?= htmlspecialchars($topic['topic_name']); ?>"
                                            required>
                                    </div>
                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Description
                                        </label>
                                        <textarea name="description"
                                                class="form-control"
                                                rows="4"><?= htmlspecialchars($topic['description']); ?></textarea>
                                    </div>
                                    <!-- Mastery -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Mastery Level
                                        </label>
                                        <select name="mastery_level"
                                                class="form-select">
                                            <option value="Not Started"
                                                <?= $topic['mastery_level'] == 'Not Started' ? 'selected' : ''; ?>>
                                                Not Started
                                            </option>
                                            <option value="Studying"
                                                <?= $topic['mastery_level'] == 'Studying' ? 'selected' : ''; ?>>
                                                Studying
                                            </option>
                                            <option value="Mastered"
                                                <?= $topic['mastery_level'] == 'Mastered' ? 'selected' : ''; ?>>
                                                Mastered
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                            class="btn btn-light"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="btn btn-primary">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php include 'topic_pagination.php'; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4 subject-card">
                    <div class="text-center">
                        <i class="bi bi-book display-5 text-secondary"></i>
                        <h5 class="fw-bold text-light mt-3">
                            No Topics Yet
                        </h5>
                        <p class="text-secondary mb-0">
                            Add your first topic to start building your study workspace.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>