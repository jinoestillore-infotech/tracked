<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $topic_id = (int) $_POST['topic_id'];
    $content = trim($_POST['content']);

    if (empty($content)) {

        $_SESSION['error'] =
            "Highlight content is required.";

        header("Location: topic.php?id=" . $topic_id . "&tab=highlights");
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO topic_highlights (
            topic_id,
            content
        )
        VALUES (?, ?)
    ");

    $stmt->bind_param(
        "is",
        $topic_id,
        $content
    );

    if ($stmt->execute()) {
    require '../includes/topic_mastery.php';
    updateTopicMastery($conn, $topic_id);
        $_SESSION['success'] =
            "Highlight added successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to add highlight.";
    }

    header("Location: topic.php?id=" . $topic_id . "&tab=highlights");
    exit;
}

?>