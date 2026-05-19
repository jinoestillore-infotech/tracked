<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: schedules.php");
    exit;
}

$id = (int) $_GET['id'];

// Get subject data
$stmt = $conn->prepare("
    SELECT * FROM schedules
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$subject = $stmt->get_result()->fetch_assoc();

if (!$subject) {
    header("Location: schedules.php");
    exit;
}

?>