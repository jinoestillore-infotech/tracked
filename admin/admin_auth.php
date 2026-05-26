<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['user']['role'] !== 'admin') {

    header("Location: ../dashboard/index.php");
    exit;
}
?>