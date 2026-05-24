<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

/* =========================
   PAGINATION
========================= */
$plansLimit = 6;

$plansPage = isset($_GET['page'])
    ? (int) $_GET['page']
    : 1;

if ($plansPage < 1) {
    $plansPage = 1;
}

$plansOffset = ($plansPage - 1) * $plansLimit;

/* =========================
   TOTAL STUDY PLANS
========================= */
$totalStmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM study_plans
    WHERE user_id = ?
");

$totalStmt->bind_param("i", $user_id);
$totalStmt->execute();

$totalResult = $totalStmt->get_result()->fetch_assoc();

$totalPlansPagination = $totalResult['total'] ?? 0;

$totalPages = ceil($totalPlansPagination / $plansLimit);

if ($plansPage > $totalPages && $totalPages > 0) {
    $plansPage = $totalPages;
}

// FETCH ONLY SUBJECTS WITH TOPICS
$subjectsStmt = $conn->prepare("
    SELECT DISTINCT
        schedules.id,
        schedules.subject_name
    FROM schedules
    INNER JOIN subject_topics
        ON subject_topics.schedule_id = schedules.id
    INNER JOIN schedule_days
        ON schedules.day_id = schedule_days.id
    WHERE schedule_days.user_id = ?
    ORDER BY schedules.subject_name ASC
");

$subjectsStmt->bind_param("i", $user_id);
$subjectsStmt->execute();

$subjectsList =
    $subjectsStmt
    ->get_result()
    ->fetch_all(MYSQLI_ASSOC);

// FETCH TOPICS
$topicsStmt = $conn->prepare("
    SELECT
        subject_topics.id,
        subject_topics.topic_name,
        subject_topics.schedule_id
    FROM subject_topics
    INNER JOIN schedules
        ON subject_topics.schedule_id = schedules.id
    INNER JOIN schedule_days
        ON schedules.day_id = schedule_days.id
    WHERE schedule_days.user_id = ?
    ORDER BY subject_topics.topic_name ASC
");

$topicsStmt->bind_param("i", $user_id);
$topicsStmt->execute();

$topicsList =
    $topicsStmt
    ->get_result()
    ->fetch_all(MYSQLI_ASSOC);

// FETCH STUDY PLANS
$plansStmt = $conn->prepare("
    SELECT
        sp.*,
        s.subject_name,
        s.subject_code,
        st.topic_name
    FROM study_plans sp

    LEFT JOIN schedules s
        ON sp.subject_id = s.id

    LEFT JOIN subject_topics st
        ON sp.topic_id = st.id

    WHERE sp.user_id = ?

    ORDER BY
        CASE sp.status
            WHEN 'Pending' THEN 1
            WHEN 'Missed' THEN 2
            WHEN 'Completed' THEN 3
        END,
        sp.study_date ASC

    LIMIT ? OFFSET ?
");

$plansStmt->bind_param(
    "iii",
    $user_id,
    $plansLimit,
    $plansOffset
);
$plansStmt->execute();

$plans = $plansStmt->get_result();

// COUNTS
$totalPlans = 0;
$completedPlans = 0;
$pendingPlans = 0;

$countStmt = $conn->prepare("
    SELECT
        COUNT(*) AS total,
        SUM(status = 'Completed') AS completed,
        SUM(status != 'Completed') AS pending
    FROM study_plans
    WHERE user_id = ?
");

$countStmt->bind_param("i", $user_id);
$countStmt->execute();

$countResult = $countStmt->get_result()->fetch_assoc();

$totalPlans = $countResult['total'] ?? 0;
$completedPlans = $countResult['completed'] ?? 0;
$pendingPlans = $countResult['pending'] ?? 0;
?>