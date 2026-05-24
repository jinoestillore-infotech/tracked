<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: settings.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$question =
    trim($_POST['security_question']);
$answer =
    trim($_POST['security_answer']);
if (empty($question) || empty($answer)) {

    $_SESSION['error'] =
        "All fields are required.";

    header("Location: settings.php");
    exit;
}

// HASH ANSWER
$hashedAnswer =
    password_hash($answer, PASSWORD_DEFAULT);
// UPDATE
$stmt = $conn->prepare("
    UPDATE users
    SET
        security_question = ?,
        security_answer = ?
    WHERE id = ?
");
$stmt->bind_param(
    "ssi",
    $question,
    $hashedAnswer,
    $user_id
);
if ($stmt->execute()) {
    $_SESSION['success'] =
        "Security question updated.";
} else {

    $_SESSION['error'] =
        "Failed to update security question.";
}
header("Location: settings.php");
exit;
?>