<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $schedule_id = (int) $_POST['schedule_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: subject.php?id=" . $schedule_id);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO subject_notes (schedule_id, title, content)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("iss", $schedule_id, $title, $content);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Note added successfully.";
    } else {
        $_SESSION['error'] = "Failed to add note.";
    }

    header("Location: subject.php?id=" . $schedule_id . "&tab=notes");
    exit;
}