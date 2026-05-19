<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if (
    isset($_GET['id']) &&
    isset($_GET['topic_id'])
) {

    $id = (int) $_GET['id'];
    $topic_id = (int) $_GET['topic_id'];

    // Delete question
    $stmt = $conn->prepare("
        DELETE FROM topic_questions
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Question deleted successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to delete question.";
    }

    header("Location: topic.php?id=" . $topic_id . "&tab=questions");
    exit;
}
?>