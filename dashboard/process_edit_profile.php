<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user = $_SESSION['user'];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = trim($_POST['fullname']);
    $profile_picture = $user['profile_picture'];

    /* =========================
       VALIDATION
    ========================= */

    if (empty($fullname)) {
        $error = "Full name is required.";
    }

    /* =========================
       IMAGE UPLOAD
    ========================= */

    if (empty($error) && !empty($_FILES['profile_picture']['name'])) {
        $file = $_FILES['profile_picture'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed)) {
            $error = "Invalid image format.";
        } else {
            $newName = time() . '_' . uniqid() . '.' . $ext;
            $uploadPath = "../uploads/profile/" . $newName;
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $profile_picture = $newName;
            }
        }
    }

    /* =========================
       UPDATE DATABASE
    ========================= */

    if (empty($error)) {
        $stmt = $conn->prepare("
            UPDATE users
            SET fullname = ?, profile_picture = ?
            WHERE id = ?
        ");
        $stmt->bind_param(
            "ssi",
            $fullname,
            $profile_picture,
            $user['id']
        );
        if ($stmt->execute()) {
            $_SESSION['user']['fullname'] = $fullname;
            $_SESSION['user']['profile_picture'] = $profile_picture;
            $_SESSION['success'] = "Profile updated successfully.";
            header("Location: index.php"); 
            exit;
        } else {
            $_SESSION['error'] = "Failed to update profile.";
        }
    }
}