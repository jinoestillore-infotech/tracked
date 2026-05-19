<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = (int) $_GET['id'];
$schedule_id = (int) $_GET['subject_id'];

$stmt = $conn->prepare("
    DELETE FROM subject_tasks
    WHERE id = ?
");

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    $_SESSION['success'] =
        "Task deleted successfully.";

} else {

    $_SESSION['error'] =
        "Failed to delete task.";
}

header("Location: subject.php?id=" . $schedule_id . "&tab=tasks");
exit;
?>