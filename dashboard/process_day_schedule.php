<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: schedules.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$day_id = (int) $_GET['id'];

// Get selected day
$stmt = $conn->prepare("
    SELECT * FROM schedule_days
    WHERE id = ? AND user_id = ?
");

$stmt->bind_param("ii", $day_id, $user_id);
$stmt->execute();

$day = $stmt->get_result()->fetch_assoc();

if (!$day) {
    header("Location: schedules.php");
    exit;
}

// Get schedules ordered by time
$schedules = $conn->prepare("
    SELECT * FROM schedules
    WHERE day_id = ?
    ORDER BY start_time ASC
");

$schedules->bind_param("i", $day_id);
$schedules->execute();

$scheduleResult = $schedules->get_result();


?>