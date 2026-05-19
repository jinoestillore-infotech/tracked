<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $day_id = (int) $_POST['day_id'];
    // Verify ownership of schedule day
    $user_id = $_SESSION['user']['id'];

    $verify = $conn->prepare("
        SELECT id
        FROM schedule_days
        WHERE id = ?
        AND user_id = ?
    ");

    $verify->bind_param("ii", $day_id, $user_id);
    $verify->execute();

    $verify_result = $verify->get_result();

    if ($verify_result->num_rows === 0) {

        $_SESSION['error'] = "Unauthorized access.";

        header("Location: schedules.php");
        exit;
    }

    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);
    $instructor = trim($_POST['instructor']);
    $units = (int) $_POST['units'];
    $room = trim($_POST['room']);
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Basic Validation
    if (
        empty($subject_name) ||
        empty($start_time) ||
        empty($end_time)
    ) {

        $_SESSION['error'] = "All fields are required.";

        header("Location: day_schedule.php?id=" . $day_id);
        exit;
    }

    // Validate Time
    if ($start_time >= $end_time) {

        $_SESSION['error'] =
            "End time must be after start time.";

        header("Location: day_schedule.php?id=" . $day_id);
        exit;
    }

    /*
    Detect overlapping schedules

    Conflict happens if:
    New start time is before existing end time
    AND
    New end time is after existing start time
    */

    $check = $conn->prepare("
        SELECT id
        FROM schedules
        WHERE day_id = ?
        AND (
            start_time < ?
            AND end_time > ?
        )
    ");

    $check->bind_param(
        "iss",
        $day_id,
        $end_time,
        $start_time
    );

    $check->execute();

    $conflict = $check->get_result();

    if ($conflict->num_rows > 0) {

        $_SESSION['error'] =
            "Schedule conflict detected.";

        header("Location: day_schedule.php?id=" . $day_id);
        exit;
    }

    // Insert Subject Schedule
    $stmt = $conn->prepare("
        INSERT INTO schedules (
            day_id,
            subject_name,
            subject_code,
            instructor,
            units,
            room,
            start_time,
            end_time
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isssisss",
        $day_id,
        $subject_name,
        $subject_code,
        $instructor,
        $units,
        $room,
        $start_time,
        $end_time
    );

    if ($stmt->execute()) {

        $_SESSION['success'] =
            "Subject schedule added successfully.";

    } else {

        $_SESSION['error'] =
            "Something went wrong.";
    }

    // Redirect back to selected day
    header("Location: day_schedule.php?id=" . $day_id);
    exit;
}
?>