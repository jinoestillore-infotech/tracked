<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user = $_SESSION['user'];

$search = trim($_GET['search'] ?? '');
$subjectFilter = trim($_GET['subject'] ?? '');


/* =========================
   PAGINATION
========================= */
$topicsLimit = 9;

$topicsPage = isset($_GET['page'])
    ? (int) $_GET['page']
    : 1;

if ($topicsPage < 1) {
    $topicsPage = 1;
}

$topicsOffset = ($topicsPage - 1) * $topicsLimit;

/* =========================
   SUBJECT FILTER DROPDOWN
========================= */
$subjectQuery = $conn->prepare("
    SELECT DISTINCT s.subject_code
    FROM schedules s
    JOIN schedule_days sd ON s.day_id = sd.id
    WHERE sd.user_id = ?
    ORDER BY s.subject_code ASC
");

$subjectQuery->bind_param("i", $user['id']);
$subjectQuery->execute();
$subjectResult = $subjectQuery->get_result();

/* =========================
   COUNT TOTAL TOPICS
========================= */
$countSql = "
    SELECT COUNT(DISTINCT st.id) AS total

    FROM subject_topics st

    JOIN schedules s
        ON st.schedule_id = s.id

    JOIN schedule_days sd
        ON s.day_id = sd.id

    WHERE sd.user_id = ?
";

$countParams = [$user['id']];
$countTypes = "i";

if (!empty($search)) {

    $countSql .= "
        AND (
            st.topic_name LIKE ?
            OR st.description LIKE ?
            OR s.subject_code LIKE ?
            OR s.subject_name LIKE ?
        )
    ";

    $searchParam = "%{$search}%";

    $countParams[] = $searchParam;
    $countParams[] = $searchParam;
    $countParams[] = $searchParam;
    $countParams[] = $searchParam;

    $countTypes .= "ssss";
}

if (!empty($subjectFilter)) {

    $countSql .= " AND s.subject_code = ? ";

    $countParams[] = $subjectFilter;
    $countTypes .= "s";
}

$countStmt = $conn->prepare($countSql);
$countStmt->bind_param($countTypes, ...$countParams);
$countStmt->execute();

$countResult = $countStmt->get_result();
$totalTopics = $countResult->fetch_assoc()['total'];

$totalPages = ceil($totalTopics / $topicsLimit);

/* =========================
   MAIN TOPICS QUERY
========================= */
$sql = "
    SELECT
        st.*,
        s.subject_name,
        s.subject_code,

        COUNT(DISTINCT tf.id) AS total_files,
        COUNT(DISTINCT tq.id) AS total_questions

    FROM subject_topics st

    JOIN schedules s
        ON st.schedule_id = s.id

    JOIN schedule_days sd
        ON s.day_id = sd.id

    LEFT JOIN topic_files tf
        ON st.id = tf.topic_id

    LEFT JOIN topic_questions tq
        ON st.id = tq.topic_id

    WHERE sd.user_id = ?
";

$params = [$user['id']];
$types = "i";

if (!empty($search)) {

    $sql .= "
        AND (
            st.topic_name LIKE ?
            OR st.description LIKE ?
            OR s.subject_code LIKE ?
            OR s.subject_name LIKE ?
        )
    ";

    $searchParam = "%{$search}%";

    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;

    $types .= "ssss";
}

if (!empty($subjectFilter)) {

    $sql .= " AND s.subject_code = ? ";

    $params[] = $subjectFilter;
    $types .= "s";
}

$sql .= "
    GROUP BY st.id
    ORDER BY st.created_at DESC
    LIMIT ? OFFSET ?
";

$params[] = $topicsLimit;
$params[] = $topicsOffset;

$types .= "ii";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();