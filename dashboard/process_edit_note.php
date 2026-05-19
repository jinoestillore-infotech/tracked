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

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: subject.php?id=" . $schedule_id . "&tab=notes");
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE subject_notes
        SET title = ?, content = ?
        WHERE id = ?
    ");

    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Note updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update note.";
    }

    header("Location: subject.php?id=" . $schedule_id . "&tab=notes");
    exit;
}