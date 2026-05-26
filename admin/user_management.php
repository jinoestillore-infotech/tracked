<?php
require '../includes/db.php';
include 'process_index.php';
include 'process_admin.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

// CHECK IF ADMIN
if ($_SESSION['user']['role'] !== 'admin') {

    $_SESSION['error'] =
        "Access denied.";

    header("Location: ../dashboard/index.php");
    exit;
}

$pageTitle = "TrackEd - Admin Dashboard";
include '../includes/header.php';
?>


<link href="../assets/css/admin_dashboard.css" rel="stylesheet">

</head>
<body>

<div class="container py-4">
    <!-- HEADER -->
    <div class="welcome-card mb-4">
        <div class="row align-items-center">
            <!-- BUTTON -->
            <div class="col-12 col-lg-4
                        order-1 order-lg-2
                        text-start text-lg-end mb-3 mb-lg-0">
                <a href="../index.php"
                   class="btn btn-light btn-sm rounded-pill px-3 py-2">

                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
            <!-- TITLE -->
            <div class="col-12 col-lg-8 order-2 order-lg-1">
                <h2 class="fw-bold text-white mb-2">
                    User Management
                </h2>
                <p class="text-light opacity-75 mb-0 small">
                    Monitor TrackEd users
                </p>
            </div>
        </div>
    </div>

    <div class="card border shadow-sm rounded-4 mt-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    Users Management
                </h5>
            </div>
            <div class="table-responsive table-scroll">
                <table class="table align-middle">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Streak</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                        <tr>
                            <!-- USER -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <?php if (!empty($user['profile_picture'])): ?>
                                        <img
                                            src="../uploads/profile/<?= htmlspecialchars($user['profile_picture']); ?>"
                                            class="rounded-circle"
                                            width="45"
                                            height="45"
                                            style="object-fit: cover;"
                                        >
                                    <?php else: ?>
                                        <i class="bi bi-person-circle fs-3"></i>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($user['fullname']); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- EMAIL -->
                            <td>
                                <?= htmlspecialchars($user['email']); ?>
                            </td>
                            <!-- ROLE -->
                            <td>
                                <span class="badge bg-primary">
                                    <?= ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <!-- STREAK -->
                            <td>
                                🔥 <?= $user['current_streak']; ?>
                            </td>
                            <!-- JOINED -->
                            <td>
                                <?= date('M d, Y', strtotime($user['created_at'])); ?>
                            </td>
                            <!-- ACTIONS -->
                            <td>
                                <!-- EDIT -->
                                <a href="edit_user.php?id=<?= $user['id']; ?>"
                                class="btn btn-sm btn-warning rounded-pill">

                                    <i class="bi bi-pencil"></i>
                                </a>
                                <!-- DELETE -->
                                <a href="delete_user.php?id=<?= $user['id']; ?>"
                                class="btn btn-sm btn-danger rounded-pill"
                                onclick="return confirm('Delete this user?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <!-- PAGINATION -->
                <div class="d-flex justify-content-center mt-4">
                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : ''; ?>">
                                    <a class="page-link"
                                    href="?page=<?= $i; ?>">

                                        <?= $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>