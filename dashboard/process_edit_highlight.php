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

    $content = trim($_POST['content']);

    if (empty($content)) {

        $_SESSION['error'] =
            "Highlight content is required.";

        header("Location: topic.php?id=" . $topic_id . "&tab=highlights");
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE topic_highlights
        SET content = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "si",
        $content,
        $id
    );

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Highlight updated successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to update highlight.";
    }

    header("Location: topic.php?id=" . $topic_id . "&tab=highlights");
    exit;
}
?>