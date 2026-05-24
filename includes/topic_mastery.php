<?php

function updateTopicMastery($conn, $topic_id)
{
    // COUNT HIGHLIGHTS
    $highlightStmt = $conn->prepare("
        SELECT COUNT(*) AS total
        FROM topic_highlights
        WHERE topic_id = ?
    ");

    $highlightStmt->bind_param(
        "i",
        $topic_id
    );

    $highlightStmt->execute();

    $highlightResult =
        $highlightStmt->get_result()->fetch_assoc();

    $highlightCount =
        $highlightResult['total'] ?? 0;



    // COUNT FILES
    $fileStmt = $conn->prepare("
        SELECT COUNT(*) AS total
        FROM topic_files
        WHERE topic_id = ?
    ");

    $fileStmt->bind_param(
        "i",
        $topic_id
    );

    $fileStmt->execute();

    $fileResult =
        $fileStmt->get_result()->fetch_assoc();

    $fileCount =
        $fileResult['total'] ?? 0;



    // COUNT QUESTIONS
    $questionStmt = $conn->prepare("
        SELECT COUNT(*) AS total
        FROM topic_questions
        WHERE topic_id = ?
    ");

    $questionStmt->bind_param(
        "i",
        $topic_id
    );

    $questionStmt->execute();

    $questionResult =
        $questionStmt->get_result()->fetch_assoc();

    $questionCount =
        $questionResult['total'] ?? 0;



    // DETERMINE MASTERY
    if (
        $highlightCount >= 5 &&
        $fileCount >= 6 &&
        $questionCount >= 7
    ) {

        $mastery =
            "Mastered";

    } else {

        $mastery =
            "Studying";
    }



    // UPDATE TOPIC
    $updateStmt = $conn->prepare("
        UPDATE subject_topics
        SET mastery_level = ?
        WHERE id = ?
    ");

    $updateStmt->bind_param(
        "si",
        $mastery,
        $topic_id
    );

    $updateStmt->execute();
}
?>