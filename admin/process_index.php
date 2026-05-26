<?php
require 'admin_auth.php';
require '../includes/db.php';

/* TOTAL USERS */
$userStmt = $conn->prepare("
    SELECT COUNT(id) AS total_users
    FROM users
");

$userStmt->execute();
$userResult =
    $userStmt->get_result()->fetch_assoc();
$total_users =
    $userResult['total_users'] ?? 0;


/* ACTIVE USERS
   Users with streak greater than 0
*/
$activeStmt = $conn->prepare("
    SELECT COUNT(id) AS active_users
    FROM users
    WHERE current_streak > 0
");

$activeStmt->execute();
$activeResult =
    $activeStmt->get_result()->fetch_assoc();
$active_users =
    $activeResult['active_users'] ?? 0;

/* REGULAR USERS
   Users with learning content/activity
*/

$regularStmt = $conn->prepare("
    SELECT COUNT(DISTINCT u.id) AS regular_users
    FROM users u
    LEFT JOIN schedule_days d
        ON u.id = d.user_id
    LEFT JOIN schedules s
        ON d.id = s.day_id
    LEFT JOIN subject_topics st
        ON s.id = st.schedule_id
    LEFT JOIN study_plans sp
        ON u.id = sp.user_id
    WHERE
        s.id IS NOT NULL
        OR st.id IS NOT NULL
        OR sp.id IS NOT NULL
");

$regularStmt->execute();
$regularResult =
    $regularStmt->get_result()->fetch_assoc();
$regular_users =
    $regularResult['regular_users'] ?? 0;
?>