<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];
    $day_id = (int) $_POST['day_id'];

    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);
    $instructor = trim($_POST['instructor']);
    $units = (int) $_POST['units'];
    $room = trim($_POST['room']);
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Basic validation
    if (empty($subject_name) || empty($start_time) || empty($end_time)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: edit_subject.php?id=" . $id);
        exit;
    }

    // Time validation
    if ($start_time >= $end_time) {
        $_SESSION['error'] = "End time must be after start time.";
        header("Location: edit_subject.php?id=" . $id);
        exit;
    }

    /*
    Conflict check (exclude current subject)
    Prevent overlapping schedules in same day
    */
    $check = $conn->prepare("
        SELECT id FROM schedules
        WHERE day_id = ?
        AND id != ?
        AND (
            start_time < ?
            AND end_time > ?
        )
    ");

    $check->bind_param(
        "iiss",
        $day_id,
        $id,
        $end_time,
        $start_time
    );

    $check->execute();

    $conflict = $check->get_result();

    if ($conflict->num_rows > 0) {
        $_SESSION['error'] = "Schedule conflict detected.";
        header("Location: edit_subject.php?id=" . $id);
        exit;
    }

    // Update subject
    $stmt = $conn->prepare("
        UPDATE schedules
        SET subject_name = ?,
            subject_code = ?,
            instructor = ?,
            units = ?,
            room = ?,
            start_time = ?,
            end_time = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssisssi",
        $subject_name,
        $subject_code,
        $instructor,
        $units,
        $room,
        $start_time,
        $end_time,
        $id
    );

    if ($stmt->execute()) {
        $_SESSION['success'] = "Subject updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update subject.";
    }

    // Redirect back to day page
    header("Location: day_schedule.php?id=" . $day_id);
    exit;
}
?>