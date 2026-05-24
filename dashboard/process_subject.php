<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Validate subject ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Invalid subject selected.";
    header("Location: subjects.php");
    exit;
}

$subject_id = (int) $_GET['id'];

// Fetch subject (with security: user_id check)
$stmt = $conn->prepare("
    SELECT 
        s.id,
        s.subject_name,
        s.subject_code,
        s.instructor,
        s.units,
        s.room,
        s.start_time,
        s.end_time,
        sd.day_name

    FROM schedules s

    INNER JOIN schedule_days sd 
        ON s.day_id = sd.id

    WHERE s.id = ?
      AND sd.user_id = ?

    LIMIT 1
");

// TOTAL NOTES
$notesQuery = $conn->prepare("
    SELECT COUNT(*) AS total_notes
    FROM subject_notes
    WHERE schedule_id = ?
");

$notesQuery->bind_param("i", $subject_id);
$notesQuery->execute();

$totalNotes =
    $notesQuery
    ->get_result()
    ->fetch_assoc()['total_notes'];

// TOTAL TOPICS
$topicsQuery = $conn->prepare("
    SELECT COUNT(*) AS total_topics
    FROM subject_topics
    WHERE schedule_id = ?
");

$topicsQuery->bind_param("i", $subject_id);
$topicsQuery->execute();

$totalTopics =
    $topicsQuery
    ->get_result()
    ->fetch_assoc()['total_topics'];
    
// TOTAL TASKS
$tasksQuery = $conn->prepare("
    SELECT COUNT(*) AS total_tasks
    FROM subject_tasks
    WHERE schedule_id = ?
");

$tasksQuery->bind_param("i", $subject_id);
$tasksQuery->execute();

$totalTasks =
    $tasksQuery
    ->get_result()
    ->fetch_assoc()['total_tasks'];


// COMPLETED TASKS
$completedQuery = $conn->prepare("
    SELECT COUNT(*) AS completed_tasks
    FROM subject_tasks
    WHERE schedule_id = ?
    AND status = 'Completed'
");

$completedQuery->bind_param("i", $subject_id);
$completedQuery->execute();

$completedTasks =
    $completedQuery
    ->get_result()
    ->fetch_assoc()['completed_tasks'];


// PENDING TASKS
$pendingQuery = $conn->prepare("
    SELECT COUNT(*) AS pending_tasks
    FROM subject_tasks
    WHERE schedule_id = ?
    AND status = 'Pending'
");

$pendingQuery->bind_param("i", $subject_id);
$pendingQuery->execute();

$pendingTasks =
    $pendingQuery
    ->get_result()
    ->fetch_assoc()['pending_tasks'];

    
$stmt->bind_param("ii", $subject_id, $user_id);
$stmt->execute();

$result = $stmt->get_result();
$subject = $result->fetch_assoc();

// If subject not found
if (!$subject) {
    $_SESSION['error'] = "Subject not found.";
    header("Location: subjects.php");
    exit;
}
?>