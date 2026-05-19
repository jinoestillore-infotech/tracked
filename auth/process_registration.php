<?php
session_start();
require '../includes/db.php';

$maxAttempts = 3;
$lockoutTime = 600; // 10 minutes

$ip = $_SERVER['REMOTE_ADDR'];
$attemptFile = sys_get_temp_dir() . '/register_' . md5($ip);

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

// reset after cooldown window
if ((time() - $attemptsData['last_attempt']) > $lockoutTime) {
    $attemptsData = [
        'count' => 0,
        'last_attempt' => time()
    ];
}

// block if too many attempts
if ($attemptsData['count'] >= $maxAttempts) {
    $_SESSION['fieldErrors'] = [
        'general' => "Too many registration attempts. Please try again later."
    ];

    $_SESSION['old'] = $_POST;
    header("Location: register.php");
    exit;
}

$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

$fieldErrors = [
    'fullname' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => ''
];


// =====================
// VALIDATION
// =====================

if ($fullname === '') {
    $fieldErrors['fullname'] = "Full name is required.";
}

if ($email === '') {
    $fieldErrors['email'] = "Email is required.";
} else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fieldErrors['email'] = "Email already exists.";
    }
}

if ($password === '') {
    $fieldErrors['password'] = "Password is required.";
} elseif (strlen($password) < 5) {
    $fieldErrors['password'] = "Password must be more than 4 characters.";
}

if ($confirm === '') {
    $fieldErrors['confirm_password'] = "Confirm password is required.";
}

if ($password !== '' && $confirm !== '' && $password !== $confirm) {
    $fieldErrors['confirm_password'] = "Passwords do not match.";
}


// =====================
// CHECK IF HAS ERRORS
// =====================

$hasErrors = false;
foreach ($fieldErrors as $err) {
    if ($err !== '') {
        $hasErrors = true;
        break;
    }
}


// =====================
// IF ERROR → STOP HERE
// =====================

if ($hasErrors) {

    $_SESSION['fieldErrors'] = $fieldErrors;
    $_SESSION['old'] = $_POST;

    header("Location: register.php");
    exit;
}


// =====================
// INSERT (ONLY IF CLEAN)
// =====================

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $fullname, $email, $hashed);

if ($stmt->execute()) {
    if (file_exists($attemptFile)) {
        unlink($attemptFile);
    }

    $_SESSION['success'] = "Account created successfully.";
} else {
    $_SESSION['fieldErrors']['general'] = "Something went wrong.";
}

header("Location: register.php");
exit;
?>