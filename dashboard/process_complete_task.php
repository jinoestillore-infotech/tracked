<?php

session_start();
date_default_timezone_set('Asia/Manila');

require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = (int) $_GET['id'];
$schedule_id = (int) $_GET['subject_id'];
$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("
    UPDATE subject_tasks
    SET status = 'Completed'
    WHERE id = ?
");

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

require '../includes/update_streak.php';
updateUserStreak($conn, $user_id);

    $_SESSION['success'] =
        "Task marked as completed.";

} else {

    $_SESSION['error'] =
        "Failed to update task.";
}

header("Location: subject.php?id=" . $schedule_id . "&tab=tasks");
exit;
?>