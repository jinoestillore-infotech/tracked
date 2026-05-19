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
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];

    // Validation
    if (
        empty($title) ||
        empty($description) ||
        empty($due_date)
    ) {

        $_SESSION['error'] = "All fields are required.";

        header("Location: subject.php?id=" . $schedule_id . "&tab=tasks");
        exit;
    }

    $today = date('Y-m-d');

    if ($due_date < $today) {

        $_SESSION['error'] = "Due date cannot be in the past.";

        header("Location: subject.php?id=" . $schedule_id . "&tab=tasks");
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO subject_tasks (
            schedule_id,
            title,
            description,
            due_date
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isss",
        $schedule_id,
        $title,
        $description,
        $due_date
    );

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Task added successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to add task.";
    }

    header("Location: subject.php?id=" . $schedule_id . "&tab=tasks");
    exit;
}
?>