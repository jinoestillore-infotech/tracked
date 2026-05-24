<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Get total subjects of the logged-in user
$user_id = $_SESSION['user']['id'];

/* FETCH LATEST USER DATA */
$userStmt = $conn->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$userStmt->bind_param(
    "i",
    $user_id
);

$userStmt->execute();

$user = $userStmt->get_result()->fetch_assoc();

$current_streak = $user['current_streak'] ?? 0;

if ($current_streak >= 100) {

    $streak_rank = "Legendary Learner";
    $streak_icon = "bi-fire";
    $streak_color = "text-danger";

} elseif ($current_streak >= 30) {

    $streak_rank = "Gold Scholar";
    $streak_icon = "bi-trophy";
    $streak_color = "text-warning";

} elseif ($current_streak >= 7) {

    $streak_rank = "Silver Scholar";
    $streak_icon = "bi-patch-check";
    $streak_color = "text-info";

} elseif ($current_streak >= 3) {

    $streak_rank = "Bronze Scholar";
    $streak_icon = "bi-award";
    $streak_color = "text-warning";

} else {

    $streak_rank = "Beginner";
    $streak_icon = "bi-stars";
    $streak_color = "text-secondary";
}

/* Total Subjects */
$stmt = $conn->prepare("
    SELECT COUNT(DISTINCT s.subject_name) AS total_subjects
    FROM schedules s
    INNER JOIN schedule_days d ON s.day_id = d.id
    WHERE d.user_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

$total_subjects = $data['total_subjects'];

/* Total Topics */
$topicStmt = $conn->prepare("
    SELECT COUNT(st.id) AS total_topics

    FROM subject_topics st

    INNER JOIN schedules s
        ON st.schedule_id = s.id

    INNER JOIN schedule_days d
        ON s.day_id = d.id

    WHERE d.user_id = ?
");

$topicStmt->bind_param("i", $user_id);
$topicStmt->execute();

$topicResult = $topicStmt->get_result();
$topicData = $topicResult->fetch_assoc();

$total_topics = $topicData['total_topics'];

/* Today Subject */
$currentDay = date('l');

$todayStmt = $conn->prepare("
    SELECT COUNT(s.id) AS today_subjects

    FROM schedules s

    INNER JOIN schedule_days d
        ON s.day_id = d.id

    WHERE d.user_id = ?
    AND d.day_name = ?
");

$todayStmt->bind_param(
    "is",
    $user_id,
    $currentDay
);

$todayStmt->execute();

$todayResult = $todayStmt->get_result();
$todayData = $todayResult->fetch_assoc();

$today_subjects =
    $todayData['today_subjects'] ?? 0;
?>