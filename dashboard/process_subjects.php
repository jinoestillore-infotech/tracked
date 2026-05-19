<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$limit = 6;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$countStmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM (
        SELECT s.subject_code
        FROM schedules s
        INNER JOIN schedule_days sd
            ON s.day_id = sd.id
        WHERE sd.user_id = ?
        GROUP BY s.subject_code
    ) as grouped_subjects
");

$countStmt->bind_param("i", $user_id);
$countStmt->execute();

$countResult = $countStmt->get_result();
$totalSubjects = $countResult->fetch_assoc()['total'];

$totalPages = ceil($totalSubjects / $limit);

$stmt = $conn->prepare("
    SELECT
        s.id,
        s.subject_name,
        s.subject_code,
        s.instructor,
        s.units,
        s.room,

        GROUP_CONCAT(
            DISTINCT CONCAT(
                sd.day_name,
                ' ',
                TIME_FORMAT(s.start_time, '%h:%i %p'),
                '-',
                TIME_FORMAT(s.end_time, '%h:%i %p')
            )
            SEPARATOR ', '
        ) AS schedule_summary

    FROM schedules s

    INNER JOIN schedule_days sd
        ON s.day_id = sd.id

    WHERE sd.user_id = ?

    GROUP BY
        s.subject_name,
        s.subject_code,
        s.instructor,
        s.units,
        s.room

    ORDER BY s.subject_name ASC

    LIMIT ? OFFSET ?
");

$stmt->bind_param("iii", $user_id, $limit, $offset);
$stmt->execute();
$subjects = $stmt->get_result();
?>