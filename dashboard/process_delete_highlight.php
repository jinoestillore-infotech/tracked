<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['topic_id'])) {

    $id = (int) $_GET['id'];
    $topic_id = (int) $_GET['topic_id'];

    $stmt = $conn->prepare("
        DELETE FROM topic_highlights
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Highlight deleted successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to delete highlight.";
    }

    header("Location: topic.php?id=" . $topic_id . "&tab=highlights");
    exit;
}
?>