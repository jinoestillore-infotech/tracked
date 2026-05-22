<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: study_planner.php");
    exit;
}

$id = $_POST['id'];
$user_id = $_SESSION['user']['id'];

$subject_id = $_POST['subject_id'];
$topic_id = $_POST['topic_id'];

$study_date = $_POST['study_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$notes = trim($_POST['notes']);


// VALIDATION
if (
    empty($subject_id) ||
    empty($study_date) ||
    empty($start_time) ||
    empty($end_time)
) {
    $_SESSION['error'] = "Please fill in all required fields.";
    header("Location: study_planner.php");
    exit;
}

// TIME CHECK
if ($start_time >= $end_time) {
    $_SESSION['error'] = "Invalid time range.";
    header("Location: study_planner.php");
    exit;
}

// UPDATE
$stmt = $conn->prepare("
    UPDATE study_plans
    SET
        subject_id = ?,
        topic_id = ?,
        study_date = ?,
        start_time = ?,
        end_time = ?,
        notes = ?
    WHERE id = ? AND user_id = ?
");

$stmt->bind_param(
    "iissssii",
    $subject_id,
    $topic_id,
    $study_date,
    $start_time,
    $end_time,
    $notes,
    $id,
    $user_id
);

if ($stmt->execute()) {
    $_SESSION['success'] = "Study plan updated successfully.";
} else {
    $_SESSION['error'] = "Failed to update study plan.";
}

header("Location: study_planner.php");
exit;
?>