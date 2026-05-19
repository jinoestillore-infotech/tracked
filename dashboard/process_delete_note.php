<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = (int) $_GET['id'];
$schedule_id = (int) $_GET['subject_id'];

$stmt = $conn->prepare("DELETE FROM subject_notes WHERE id = ?");
$stmt->bind_param("i", $id);

$stmt->execute();

$_SESSION['success'] = "Note deleted.";

header("Location: subject.php?id=" . $schedule_id . "&tab=notes");
exit;