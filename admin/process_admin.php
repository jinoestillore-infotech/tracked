<?php
/* PAGINATION */
$limit = 5;

$page =
    isset($_GET['page'])
    ? (int) $_GET['page']
    : 1;

if ($page < 1) {
    $page = 1;
}

$offset =
    ($page - 1) * $limit;


/* TOTAL USERS FOR PAGINATION */
$countStmt = $conn->prepare("
    SELECT COUNT(id) AS total
    FROM users
");

$countStmt->execute();

$countResult =
    $countStmt->get_result()->fetch_assoc();

$total_records =
    $countResult['total'];

$total_pages =
    ceil($total_records / $limit);


/* USERS LIST */
$usersStmt = $conn->prepare("
    SELECT
        id,
        fullname,
        email,
        profile_picture,
        role,
        current_streak,
        created_at
    FROM users
    ORDER BY created_at DESC
    LIMIT ?, ?
");

$usersStmt->bind_param(
    "ii",
    $offset,
    $limit
);

$usersStmt->execute();

$users =
    $usersStmt->get_result();
?>