<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {

    $_SESSION['error'] =
        "Invalid study plan.";

    header("Location: study_planner.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$plan_id = (int) $_GET['id'];


// FETCH PLAN
$planStmt = $conn->prepare("
    SELECT
        id,
        topic_id,
        status
    FROM study_plans
    WHERE id = ?
    AND user_id = ?
");

$planStmt->bind_param(
    "ii",
    $plan_id,
    $user_id
);

$planStmt->execute();

$planResult =
    $planStmt->get_result();


// CHECK IF EXISTS
if ($planResult->num_rows === 0) {

    $_SESSION['error'] =
        "Study plan not found.";

    header("Location: study_planner.php");
    exit;
}

$plan =
    $planResult->fetch_assoc();


// CHECK IF ALREADY COMPLETED
if ($plan['status'] === 'Completed') {
    require '../includes/topic_mastery.php';
    updateTopicMastery($conn, $topic_id);
    $_SESSION['error'] =
        "Study plan already completed.";

    header("Location: study_planner.php");
    exit;
}


// UPDATE STUDY PLAN
$updateStmt = $conn->prepare("
    UPDATE study_plans
    SET status = 'Completed'
    WHERE id = ?
    AND user_id = ?
");

$updateStmt->bind_param(
    "ii",
    $plan_id,
    $user_id
);


// SUCCESS
if ($updateStmt->execute()) {

    // AUTO UPDATE TOPIC MASTERY
    if (!empty($plan['topic_id'])) {

        $topicStmt = $conn->prepare("
            UPDATE subject_topics
            SET mastery_level = 'Studying'
            WHERE id = ?
            AND mastery_level = 'Not Started'
        ");

        $topicStmt->bind_param(
            "i",
            $plan['topic_id']
        );

        $topicStmt->execute();
    }

    $_SESSION['success'] =
        "Study plan marked as completed.";

} else {

    $_SESSION['error'] =
        "Failed to complete study plan.";
}

header("Location: study_planner.php");
exit;
?>