<?php

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../auth/login.php");
    exit;
}

if (
    isset($_GET['id']) &&
    isset($_GET['topic_id'])
) {

    $id = (int) $_GET['id'];
    $topic_id = (int) $_GET['topic_id'];

    // Fetch file first
    $stmt = $conn->prepare("
        SELECT *
        FROM topic_files
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {

        $_SESSION['error'] =
            "File not found.";

        header("Location: topic.php?id=" . $topic_id . "&tab=files");
        exit;
    }

    $file = $result->fetch_assoc();

    // Physical file path
    $physicalPath =
        '../' . $file['file_path'];

    // Delete physical file
    if (file_exists($physicalPath)) {

        unlink($physicalPath);
    }

    // Delete DB record
    $delete = $conn->prepare("
        DELETE FROM topic_files
        WHERE id = ?
    ");

    $delete->bind_param("i", $id);

    if ($delete->execute()) {

        $_SESSION['success'] =
            "File deleted successfully.";

    } else {

        $_SESSION['error'] =
            "Failed to delete file.";
    }

    header("Location: topic.php?id=" . $topic_id . "&tab=files");
    exit;
}
?>