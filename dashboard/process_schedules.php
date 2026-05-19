<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Fetch schedule days
$stmt = $conn->prepare("
    SELECT 
        schedule_days.*,
        COUNT(schedules.id) AS subject_count
    FROM schedule_days
    LEFT JOIN schedules 
        ON schedules.day_id = schedule_days.id
    WHERE schedule_days.user_id = ?
    GROUP BY schedule_days.id
    ORDER BY FIELD(schedule_days.day_name,
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    )
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$days = $stmt->get_result();

?>