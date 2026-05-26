<?php
session_start();
require 'admin_auth.php';
require '../includes/db.php';

if (!isset($_GET['id'])) {

    $_SESSION['error'] =
        "Invalid user.";

    header("Location: index.php");
    exit;
}

$user_id = (int) $_GET['id'];
$admin_id = $_SESSION['user']['id'];

/* PREVENT SELF DELETE */
if ($user_id === $admin_id) {

    $_SESSION['error'] =
        "You cannot delete your own account.";

    header("Location: index.php");
    exit;
}

/* DELETE USER */
$stmt = $conn->prepare("
    DELETE FROM users
    WHERE id = ?
");

$stmt->bind_param(
    "i",
    $user_id
);

if ($stmt->execute()) {

    $_SESSION['success'] =
        "User deleted successfully.";

} else {

    $_SESSION['error'] =
        "Failed to delete user.";
}

header("Location: index.php");
exit;
?>