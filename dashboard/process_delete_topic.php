<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['schedule_id'])) {

    $id = (int) $_GET['id'];
    $schedule_id = (int) $_GET['schedule_id'];

    $stmt = $conn->prepare("
        DELETE FROM subject_topics
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Topic deleted successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to delete topic.";
    }

    header("Location: subject.php?id=" . $schedule_id . "&tab=topics");
    exit;
}
?>