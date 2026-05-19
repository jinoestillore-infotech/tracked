<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $schedule_id = (int) $_POST['schedule_id'];

    $topic_name = trim($_POST['topic_name']);
    $description = trim($_POST['description']);
    $mastery_level = $_POST['mastery_level'];

    // Validation
    if (empty($topic_name)) {

        $_SESSION['error'] =
            "Topic name is required.";

        header("Location: subject.php?id=" . $schedule_id . "&tab=topics");
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO subject_topics (
            schedule_id,
            topic_name,
            description,
            mastery_level
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isss",
        $schedule_id,
        $topic_name,
        $description,
        $mastery_level
    );

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Topic added successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to add topic.";
    }

    header("Location: subject.php?id=" . $schedule_id . "&tab=topics");
    exit;
}
?>