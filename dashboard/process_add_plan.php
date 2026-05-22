<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: study_planner.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$subject_id = $_POST['subject_id'];
$topic_id = $_POST['topic_id'];
$study_date = $_POST['study_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$notes = trim($_POST['notes']);
$status = "Pending";

// VALIDATION
if (
    empty($subject_id) ||
    empty($topic_id) ||
    empty($study_date) ||
    empty($start_time) ||
    empty($end_time)
) {

    $_SESSION['error'] =
        "Please fill in all required fields.";

    header("Location: study_planner.php");
    exit;
}

// TIME VALIDATION
if ($start_time >= $end_time) {

    $_SESSION['error'] =
        "End time must be after start time.";

    header("Location: study_planner.php");
    exit;
}

// INSERT
$stmt = $conn->prepare("
    INSERT INTO study_plans
    (
        user_id,
        subject_id,
        topic_id,
        study_date,
        start_time,
        end_time,
        status,
        notes
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "iiisssss",
    $user_id,
    $subject_id,
    $topic_id,
    $study_date,
    $start_time,
    $end_time,
    $status,
    $notes
);

if ($stmt->execute()) {

    $_SESSION['success'] =
        "Study plan added successfully.";

} else {

    $_SESSION['error'] =
        "Failed to add study plan.";
}

header("Location: study_planner.php");
exit;
?>