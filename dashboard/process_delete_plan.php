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

$id = (int) $_GET['id'];
$user_id = $_SESSION['user']['id'];

// DELETE ONLY USER OWNED PLAN
$stmt = $conn->prepare("
    DELETE FROM study_plans
    WHERE id = ?
    AND user_id = ?
");

$stmt->bind_param(
    "ii",
    $id,
    $user_id
);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {

        $_SESSION['success'] =
            "Study plan deleted successfully.";

    } else {

        $_SESSION['error'] =
            "Study plan not found.";
    }

} else {

    $_SESSION['error'] =
        "Failed to delete study plan.";
}

header("Location: study_planner.php");
exit;
?>