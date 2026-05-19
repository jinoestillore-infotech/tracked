<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Validate topic id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    $_SESSION['error'] = "Invalid topic.";

    header("Location: subjects.php");
    exit;
}

$topic_id = (int) $_GET['id'];

/*
|--------------------------------------------------------------------------
| FETCH TOPIC
|--------------------------------------------------------------------------
|
| We join:
| - subject_topics
| - schedules
| - schedule_days
|
| This ensures:
| - topic exists
| - belongs to logged in user
| - loads related subject info
|
*/

$stmt = $conn->prepare("
    SELECT
        subject_topics.*,

        schedules.subject_name,
        schedules.subject_code,
        schedules.instructor,
        schedules.room,
        schedules.units,

        schedule_days.day_name

    FROM subject_topics

    INNER JOIN schedules
        ON subject_topics.schedule_id = schedules.id

    INNER JOIN schedule_days
        ON schedules.day_id = schedule_days.id

    WHERE subject_topics.id = ?
    AND schedule_days.user_id = ?
");

$stmt->bind_param(
    "ii",
    $topic_id,
    $user_id
);

$stmt->execute();

$result = $stmt->get_result();

// Topic not found
if ($result->num_rows === 0) {

    $_SESSION['error'] =
        "Topic not found.";

    header("Location: subjects.php");
    exit;
}

$topic = $result->fetch_assoc();

/*
|--------------------------------------------------------------------------
| OPTIONAL FUTURE COUNTS
|--------------------------------------------------------------------------
|
| Ready for:
| - highlights
| - files
| - practice questions
|
*/

// Highlights Count
$highlightStmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM topic_highlights
    WHERE topic_id = ?
");

$highlightStmt->bind_param("i", $topic_id);
$highlightStmt->execute();

$highlightCount =
    $highlightStmt
    ->get_result()
    ->fetch_assoc()['total'];

// Files Count
$fileStmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM topic_files
    WHERE topic_id = ?
");

$fileStmt->bind_param("i", $topic_id);
$fileStmt->execute();

$fileCount =
    $fileStmt
    ->get_result()
    ->fetch_assoc()['total'];


// Questions Count
$questionStmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM topic_questions
    WHERE topic_id = ?
");

$questionStmt->bind_param("i", $topic_id);
$questionStmt->execute();

$questionCount =
    $questionStmt
    ->get_result()
    ->fetch_assoc()['total'];

// FETCH HIGHLIGHTS

?>  