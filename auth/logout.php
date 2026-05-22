<?php
session_start();

// Clear all session variables
$_SESSION = [];

// Store flash message first
$_SESSION['success'] = "Logged out successfully!";

// Clear user-specific session data
unset($_SESSION['user_id']);
unset($_SESSION['username']);

// Destroy session cookie (important for full logout)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Redirect to landing page
header("Location: login.php?logout=success");
exit;