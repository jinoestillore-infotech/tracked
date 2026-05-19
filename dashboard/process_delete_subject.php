<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['day_id'])) {
    $_SESSION['error'] = "Invalid request.";
    header("Location: schedules.php");
    exit;
}

$subject_id = (int) $_GET['id'];
$day_id = (int) $_GET['day_id'];

// Ensure subject belongs to a valid record
$stmt = $conn->prepare("
    DELETE FROM schedules
    WHERE id = ?
");

$stmt->bind_param("i", $subject_id);

if ($stmt->execute()) {

    $_SESSION['success'] =
        "Subject removed successfully.";

} else {

    $_SESSION['error'] =
        "Failed to remove subject.";
}

// Redirect back to the same day page
header("Location: day_schedule.php?id=" . $day_id);
exit;
?>