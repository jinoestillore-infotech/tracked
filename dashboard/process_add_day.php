<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['user']['id'];
    $day_name = trim($_POST['day_name']);

    // Check if already exists
    $check = $conn->prepare("
        SELECT id FROM schedule_days
        WHERE user_id = ? AND day_name = ?
    ");

    $check->bind_param("is", $user_id, $day_name);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Day already added.";
        header("Location: schedules.php");
        exit;
    }

    // Insert day
    $stmt = $conn->prepare("
        INSERT INTO schedule_days (user_id, day_name)
        VALUES (?, ?)
    ");

    $stmt->bind_param("is", $user_id, $day_name);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Schedule day added successfully.";
    } else {
        $_SESSION['error'] = "Something went wrong.";
    }

    header("Location: schedules.php");
    exit;
}
?>