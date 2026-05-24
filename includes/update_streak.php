<?php
date_default_timezone_set('Asia/Manila');
function updateUserStreak($conn, $user_id)
{
    // =====================================
    // STREAK SYSTEM
    // =====================================
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $streakStmt = $conn->prepare("
        SELECT
            current_streak,
            longest_streak,
            last_study_date
        FROM users
        WHERE id = ?
    ");
    $streakStmt->bind_param(
        "i",
        $user_id
    );
    $streakStmt->execute();
    $streakData =
        $streakStmt->get_result()->fetch_assoc();
    $current_streak =
        $streakData['current_streak'];
    $longest_streak =
        $streakData['longest_streak'];
    $last_study_date =
        $streakData['last_study_date'];
    // PREVENT MULTIPLE STREAKS SAME DAY
    if ($last_study_date !== $today) {
        // CONTINUE STREAK
        if ($last_study_date === $yesterday) {
            $current_streak++;
        } else {
            // RESET STREAK
            $current_streak = 1;
        }
        // UPDATE LONGEST
        if ($current_streak > $longest_streak) {
            $longest_streak =
                $current_streak;
        }
        // SAVE STREAK
        $saveStmt = $conn->prepare("
            UPDATE users
            SET
                current_streak = ?,
                longest_streak = ?,
                last_study_date = ?
            WHERE id = ?
        ");
        $saveStmt->bind_param(
            "iisi",
            $current_streak,
            $longest_streak,
            $today,
            $user_id
        );
        $saveStmt->execute();
    }
    // =====================================
    // END STREAK SYSTEM
    // =====================================
}
?>