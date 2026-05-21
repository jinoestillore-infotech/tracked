<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Get total subjects of the logged-in user
$user_id = $_SESSION['user']['id'];

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
?>