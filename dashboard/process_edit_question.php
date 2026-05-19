<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];
    $topic_id = (int) $_POST['topic_id'];

    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);

    // Validation
    if (
        empty($question) ||
        empty($answer)
    ) {

        $_SESSION['error'] =
            "All fields are required.";

        header("Location: topic.php?id=" . $topic_id . "&tab=questions");
        exit;
    }

    // Update question
    $stmt = $conn->prepare("
        UPDATE topic_questions
        SET question = ?,
            answer = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssi",
        $question,
        $answer,
        $id
    );

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Question updated successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to update question.";
    }

    header("Location: topic.php?id=" . $topic_id . "&tab=questions");
    exit;
}
?>