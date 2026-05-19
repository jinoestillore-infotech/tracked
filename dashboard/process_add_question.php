<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    // Insert question
    $stmt = $conn->prepare("
        INSERT INTO topic_questions (
            topic_id,
            question,
            answer
        )
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param(
        "iss",
        $topic_id,
        $question,
        $answer
    );

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Practice question added successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to add question.";
    }

    header("Location: topic.php?id=" . $topic_id . "&tab=questions");
    exit;
}
?>