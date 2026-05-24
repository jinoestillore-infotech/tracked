<?php
session_start();
require '../includes/db.php';

$maxAttempts = 5;
$lockoutTime = 60; // seconds

$ip = $_SERVER['REMOTE_ADDR'];

$attemptFile = sys_get_temp_dir() . '/login_' . md5($ip);

$attemptsData = [
    'count' => 0,
    'last_attempt' => time()
];

if (file_exists($attemptFile)) {

    $data = json_decode(file_get_contents($attemptFile), true);

    if (is_array($data)) {
        $attemptsData = $data;
    }
}

$fieldErrors = [
    'email' => '',
    'password' => ''
];

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (
    $attemptsData['count'] >= $maxAttempts &&
    (time() - $attemptsData['last_attempt']) < $lockoutTime
) {

    $_SESSION['fieldErrors'] = [
        'email' => "Too many login attempts. Please try again in 1 minute.",
        'password' => ''
    ];

    $_SESSION['old'] = $_POST;

    header("Location: login.php");
    exit;
}

// =====================
// VALIDATION
// =====================
if ($email === '') {
    $fieldErrors['email'] = "Email is required.";
}

if ($password === '') {
    $fieldErrors['password'] = "Password is required.";
}

// =====================
// CHECK USER ONLY IF NO BASIC ERRORS
// =====================
if ($email !== '' && $password !== '') {

    $stmt = $conn->prepare("SELECT id, fullname, email, password, profile_picture FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if (!$user || !password_verify($password, $user['password'])) {

        $attemptsData['count'] += 1;
        $attemptsData['last_attempt'] = time();

        file_put_contents($attemptFile, json_encode($attemptsData));

        $fieldErrors['email'] = "Invalid email or password.";
    }
}

// =====================
// CHECK ERRORS
// =====================
$hasErrors = false;
foreach ($fieldErrors as $err) {
    if ($err !== '') {
        $hasErrors = true;
        break;
    }
}

// =====================
// ERROR → BACK TO LOGIN
// =====================
if ($hasErrors) {

    $_SESSION['fieldErrors'] = $fieldErrors;
    $_SESSION['old'] = $_POST;

    header("Location: login.php");
    exit;
}

// =====================
// SUCCESS LOGIN
// =====================
if (file_exists($attemptFile)) {
    unlink($attemptFile);
}

session_regenerate_id(true);
$_SESSION['user'] = [
    'id' => $user['id'],
    'fullname' => $user['fullname'],
    'email' => $user['email'],
    'profile_picture' => $user['profile_picture']
];

header("Location: ../dashboard/index.php");
exit;