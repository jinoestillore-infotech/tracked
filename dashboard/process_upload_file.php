<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $topic_id = (int) $_POST['topic_id'];

    // Check if file exists
    if (!isset($_FILES['file'])) {

        $_SESSION['error'] =
            "No file uploaded.";

        header("Location: topic.php?id=" . $topic_id . "&tab=files");
        exit;
    }

    $file = $_FILES['file'];

    // File info
    $originalName = $file['name'];
    $tmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // Validate upload error
    if ($fileError !== 0) {

        $_SESSION['error'] =
            "Failed to upload file.";

        header("Location: topic.php?id=" . $topic_id . "&tab=files");
        exit;
    }

    // Allowed extensions
    $allowed = [
        'pdf',
        'doc',
        'docx',
        'ppt',
        'pptx',
        'jpg',
        'jpeg',
        'png',
        'jfif'
    ];

    // Get extension
    $extension = strtolower(
        pathinfo(
            $originalName,
            PATHINFO_EXTENSION
        )
    );

    // Validate extension
    if (!in_array($extension, $allowed)) {

        $_SESSION['error'] =
            "Invalid file type.";

        header("Location: topic.php?id=" . $topic_id . "&tab=files");
        exit;
    }

    // Max size = 10MB
    if ($fileSize > 10 * 1024 * 1024) {

        $_SESSION['error'] =
            "File size exceeds 10MB.";

        header("Location: topic.php?id=" . $topic_id . "&tab=files");
        exit;
    }

    // Generate unique filename
    $newFileName =
        uniqid('topic_', true)
        . '.'
        . $extension;

    // Upload directory
    $uploadDir =
        '../uploads/topic_files/';

    // Create directory if missing
    if (!is_dir($uploadDir)) {

        mkdir(
            $uploadDir,
            0777,
            true
        );
    }

    // Final path
    $destination =
        $uploadDir . $newFileName;

    // Move uploaded file
    if (!move_uploaded_file($tmpName, $destination)) {

        $_SESSION['error'] =
            "Failed to save uploaded file.";

        header("Location: topic.php?id=" . $topic_id . "&tab=files");
        exit;
    }

    /*
    Save path for browser access

    Remove ../ because topic.php
    is already inside dashboard/
    */

    $dbPath =
        'uploads/topic_files/'
        . $newFileName;

    // Save to database
    $stmt = $conn->prepare("
        INSERT INTO topic_files (
            topic_id,
            file_name,
            file_path
        )
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param(
        "iss",
        $topic_id,
        $originalName,
        $dbPath
    );

    if ($stmt->execute()) {
    require '../includes/topic_mastery.php';
    updateTopicMastery($conn, $topic_id);
        $_SESSION['success'] =
            "File uploaded successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to save file in database.";
    }

    header("Location: topic.php?id=" . $topic_id . "&tab=files");
    exit;
}
?>