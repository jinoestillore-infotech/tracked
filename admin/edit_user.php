<?php
require 'admin_auth.php';
require '../includes/db.php';

if (!isset($_GET['id'])) {

    header("Location: index.php");
    exit;
}

$user_id = (int) $_GET['id'];

/* FETCH USER */
$stmt = $conn->prepare("
    SELECT
        id,
        fullname,
        email,
        role,
        current_streak,
        longest_streak
    FROM users
    WHERE id = ?
");

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$result =
    $stmt->get_result();

/* USER NOT FOUND */
if ($result->num_rows === 0) {

    $_SESSION['error'] =
        "User not found.";

    header("Location: index.php");
    exit;
}

$user =
    $result->fetch_assoc();


/* UPDATE USER */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname =
        trim($_POST['fullname']);
    $email =
        trim($_POST['email']);
    $role =
        trim($_POST['role']);
    $current_streak =
        (int) $_POST['current_streak'];
    $longest_streak =
        (int) $_POST['longest_streak'];
    $updateStmt = $conn->prepare("
        UPDATE users
        SET
            fullname = ?,
            email = ?,
            role = ?,
            current_streak = ?,
            longest_streak = ?
        WHERE id = ?
    ");

    $updateStmt->bind_param(
        "sssiii",
        $fullname,
        $email,
        $role,
        $current_streak,
        $longest_streak,
        $user_id
    );

    if ($updateStmt->execute()) {
        $_SESSION['success'] =
            "User updated successfully.";
    } else {
        $_SESSION['error'] =
            "Failed to update user.";
    }

    header("Location: user_management.php");
    exit;
}

$pageTitle = "Edit User";
include '../includes/header.php';
?>

<link href="../assets/css/settings.css" rel="stylesheet">

</head>
<body>
<div class="container py-4">
    <!-- HEADER -->
    <div class="welcome-card mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-lg-4
                        order-1 order-lg-2
                        text-start text-lg-end mb-3 mb-lg-0">
                <a href="index.php"
                   class="btn btn-light btn-sm rounded-pill px-3 py-2">
                    <i class="bi bi-arrow-left"></i>
                    Back to Admin
                </a>
            </div>
            <div class="col-12 col-lg-8 order-2 order-lg-1">
                <h2 class="fw-bold text-white mb-2">
                    Edit User
                </h2>
                <p class="text-light opacity-75 mb-0 small">
                    Manage user information and permissions.
                </p>
            </div>
        </div>
    </div>

    <!-- FORM -->
    <div class="card col-12 col-md-6 mx-auto border shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST">
                <!-- FULLNAME -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Full Name
                    </label>
                    <input type="text"
                           name="fullname"
                           class="form-control"
                           value="<?= htmlspecialchars($user['fullname']); ?>"
                           required>
                </div>
                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Email
                    </label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?= htmlspecialchars($user['email']); ?>"
                           required>
                </div>
                <!-- ROLE -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Role
                    </label>
                    <select name="role"
                            class="form-select"
                            required>
                        <option value="student"
                            <?= $user['role'] === 'student' ? 'selected' : ''; ?>>
                            Student
                        </option>
                        <option value="admin"
                            <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>
                            Admin
                        </option>
                    </select>
                </div>

                <!-- CURRENT STREAK -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Current Streak
                    </label>
                    <input type="number"
                           name="current_streak"
                           class="form-control"
                           value="<?= $user['current_streak']; ?>"
                           min="0">
                </div>

                <!-- LONGEST STREAK -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Longest Streak
                    </label>
                    <input type="number"
                           name="longest_streak"
                           class="form-control"
                           value="<?= $user['longest_streak']; ?>"
                           min="0">
                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save me-1"></i>
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>