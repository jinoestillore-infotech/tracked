<?php

/* Questions Pagination */
$questionsLimit = 6;

$questionsPage = isset($_GET['questions_page'])
    ? (int)$_GET['questions_page']
    : 1;

if ($questionsPage < 1) {
    $questionsPage = 1;
}

$questionsOffset = ($questionsPage - 1) * $questionsLimit;

/* Count Total Questions */
$countStmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM topic_questions
    WHERE topic_id = ?
");

$countStmt->bind_param("i", $topic_id);
$countStmt->execute();

$countResult = $countStmt->get_result();
$totalQuestions = $countResult->fetch_assoc()['total'];

$totalQuestionsPages = ceil($totalQuestions / $questionsLimit);

/* Fetch Paginated Questions */
$questionStmt = $conn->prepare("
    SELECT *
    FROM topic_questions
    WHERE topic_id = ?
    ORDER BY created_at DESC
    LIMIT ? OFFSET ?
");

$questionStmt->bind_param(
    "iii",
    $topic_id,
    $questionsLimit,
    $questionsOffset
);

$questionStmt->execute();

$questions = $questionStmt->get_result();

?>

<!-- PRACTICE QUESTIONS -->
<div class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 'questions') ? 'show active' : ''; ?>"
     id="questions">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-dark fw-bold mb-0">
            Practice Questions
        </h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#addQuestionModal">
            <i class="bi bi-plus-lg"></i>
            Add Question
        </button>
    </div>
    <!-- Questions -->
    <div class="row g-4">
        <?php if ($questions->num_rows > 0): ?>
            <?php while ($question = $questions->fetch_assoc()): ?>
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm subject-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="subject-icon">
                                        <i class="bi bi-patch-question"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-light mb-1">
                                            Practice Question
                                        </h6>
                                        <small class="text-secondary">
                                            <?= date(
                                                "M d, Y",
                                                strtotime($question['created_at'])
                                            ); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <!-- Question -->
                            <div class="mb-1 mt-2">
                                <small class="text-secondary d-block mb-2">
                                    Question
                                </small>
                                <p class="text-light fw-semibold mb-0">
                                    <?= nl2br(htmlspecialchars($question['question'])); ?>
                                </p>
                            </div>
                            <button class="btn btn-outline-light btn-sm rounded-pill m-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewAnswerModal<?= $question['id']; ?>"
                                    title="Reveal Answer">
                                <i class="bi bi-eye"></i>
                                Reveal Answer
                            </button>
                        </div>
                        <div class="card-footer border-0 m-0 mb-1">
                            <!-- Actions -->
                            <div class="d-flex flex-wrap justify-content-end gap-2">
                                <!-- Edit -->
                                <button class="btn btn-outline-light btn-sm rounded-pill"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editQuestionModal<?= $question['id']; ?>"
                                        title="Edit Answer">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <!-- Delete -->
                                <a href="process_delete_question.php?id=<?= $question['id']; ?>&topic_id=<?= $topic['id']; ?>"
                                   class="btn btn-outline-danger btn-sm rounded-pill"
                                   onclick="return confirm('Delete this question?')"
                                   title="Delete Answer">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Modal -->
                <div class="modal fade"
                     id="editQuestionModal<?= $question['id']; ?>"
                     tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0">
                            <form action="process_edit_question.php"
                                  method="POST"
                                  data-loading-form>
                                <input type="hidden"
                                       name="id"
                                       value="<?= $question['id']; ?>">
                                <input type="hidden"
                                       name="topic_id"
                                       value="<?= $topic['id']; ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">
                                        Edit Question
                                    </h5>
                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Question
                                        </label>
                                        <textarea name="question"
                                                  class="form-control"
                                                  rows="3"
                                                  required><?= htmlspecialchars($question['question']); ?></textarea>
                                    </div>
                                    <div>
                                        <label class="form-label fw-semibold">
                                            Answer
                                        </label>
                                        <textarea name="answer"
                                                  class="form-control"
                                                  rows="4"
                                                  required><?= htmlspecialchars($question['answer']); ?></textarea>
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
                                                Save Changes
                                        </span>
                                        <span class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- View Answer Modal -->
                <div class="modal fade"
                    id="viewAnswerModal<?= $question['id']; ?>"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <!-- Header -->
                            <div class="modal-header border-0 pb-0">
                                <div>
                                    <h5 class="modal-title fw-bold mb-1">
                                        Practice Question
                                    </h5>
                                    <small class="text-muted">
                                        Review your answer
                                    </small>
                                </div>
                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"></button>
                            </div>
                            <!-- Body -->
                            <div class="modal-body pt-3">
                                <!-- Question -->
                                <div class="p-3 rounded-4 bg-light mb-3">
                                    <small class="text-muted d-block mb-2">
                                        Question
                                    </small>
                                    <p class="mb-0 fw-semibold text-dark">
                                        <?= nl2br(htmlspecialchars($question['question'])); ?>
                                    </p>
                                </div>
                                <!-- Answer -->
                                <div class="p-3 rounded-4 border">
                                    <small class="text-muted d-block mb-2">
                                        Answer
                                    </small>
                                    <p class="mb-0 text-dark">
                                        <?= nl2br(htmlspecialchars($question['answer'])); ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Footer -->
                            <div class="modal-footer border-0 pt-0">
                                <button type="button"
                                        class="btn btn-primary rounded-pill px-4"
                                        data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php include 'practice_question_pagination.php'; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4 subject-card">
                    <div class="text-center">
                        <i class="bi bi-patch-question display-5 text-secondary"></i>
                        <h5 class="fw-bold text-light mt-3">
                            No Practice Questions Yet
                        </h5>
                        <p class="text-secondary mb-0">
                            Add questions to test your understanding.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>