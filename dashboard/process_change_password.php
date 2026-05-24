<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: settings.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$current =
    $_POST['current_password'];
$new =
    $_POST['new_password'];
$confirm =
    $_POST['confirm_password'];

// VALIDATION
if (
    empty($current) ||
    empty($new) ||
    empty($confirm)
) {
    $_SESSION['error'] =
        "All fields are required.";
    header("Location: settings.php");
    exit;
}

if ($new !== $confirm) {
    $_SESSION['error'] =
        "Passwords do not match.";
    header("Location: settings.php");
    exit;
}

// FETCH USER
$stmt = $conn->prepare("
    SELECT password
    FROM users
    WHERE id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user =
    $stmt->get_result()->fetch_assoc();

// VERIFY CURRENT PASSWORD
if (
    !password_verify(
        $current,
        $user['password']
    )
) {

    $_SESSION['error'] =
        "Current password is incorrect.";

    header("Location: settings.php");
    exit;
}

// HASH NEW PASSWORD
$newPassword =
    password_hash($new, PASSWORD_DEFAULT);
// UPDATE PASSWORD
$updateStmt = $conn->prepare("
    UPDATE users
    SET password = ?
    WHERE id = ?
");

$updateStmt->bind_param(
    "si",
    $newPassword,
    $user_id
);
if ($updateStmt->execute()) {
    $_SESSION['success'] =
        "Password updated successfully.";
} else {
    $_SESSION['error'] =
        "Failed to update password.";
}

header("Location: settings.php");
exit;
?>