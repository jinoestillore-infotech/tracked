<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];
    $schedule_id = (int) $_POST['schedule_id'];

    $topic_name = trim($_POST['topic_name']);
    $description = trim($_POST['description']);
    $mastery_level = $_POST['mastery_level'];

    // Validation
    if (empty($topic_name)) {

        $_SESSION['error'] =
            "Topic name is required.";

        header("Location: topic.php?id=" . $id);
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE subject_topics
        SET
            topic_name = ?,
            description = ?,
            mastery_level = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssi",
        $topic_name,
        $description,
        $mastery_level,
        $id
    );

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Topic updated successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to update topic.";
    }

    header("Location: subject.php?id=" . $schedule_id . "&tab=topics");
    exit;
}
?>