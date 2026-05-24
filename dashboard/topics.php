<?php
require 'process_topics.php';

$pageTitle = "Topics - TrackEd";
include '../includes/header.php';
?>

<link href="../assets/css/topics.css" rel="stylesheet">

</head>
<body>

<div class="container py-4">
    <!-- HEADER -->
    <div class="welcome-card mb-3">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <a href="index.php"
                   class="btn btn-light btn-sm mb-3 rounded-pill p-2">
                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
                <h2 class="fw-bold text-white mb-2 lh-sm">
                    Topics Explorer
                </h2>
                <p class="mb-0 text-light opacity-75 small">
                    Browse, search, and manage all your learning topics across subjects.
                </p>
            </div>

            <div class="col-12 col-lg-4 text-lg-end">
                <span class="badge bg-light px-3 py-2 rounded-pill text-dark">
                    <?= $result->num_rows ?> Topics Found
                </span>
            </div>
        </div>
    </div>

    <!-- SEARCH + FILTER -->
    <form method="GET" class="mb-4 mt-5">
        <div class="row justify-content-end g-3">
            <div class="col-lg-4">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search topics..."
                    value="<?= htmlspecialchars($search) ?>"
                >
            </div>
            <div class="col-lg-3">
                <select name="subject" class="form-select">
                    <option value="">
                        All Subjects
                    </option>
                    <?php while($subject = $subjectResult->fetch_assoc()): ?>
                        <option
                            value="<?= $subject['subject_code'] ?>"
                            <?= $subjectFilter === $subject['subject_code'] ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($subject['subject_code']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-lg-1 d-grid">
                <button class="btn btn-primary rounded-4 fw-semibold">
                    Go
                </button>
            </div>
        </div>
    </form>

    <!-- TOPICS GRID -->
    <div class="row g-4">
        <?php if($result->num_rows > 0): ?>
            <?php while($topic = $result->fetch_assoc()): ?>
                <?php
                    $masteryClass = match($topic['mastery_level']) {
                        'Mastered' => 'mastered',
                        'Studying' => 'studying',
                        default => 'not-started'
                    };
                    $statusClass = match($topic['status']) {
                        'Completed' => 'completed',
                        'Ongoing' => 'ongoing',
                        default => 'upcoming'
                    };
                ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card topic-card shadow-sm border-0 h-100 rounded-4">
                        <div class="card-body d-flex flex-column p-4">
                            <!-- HEADER -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary px-3 py-2 rounded-pill">
                                    <?= htmlspecialchars($topic['subject_code']) ?>
                                </span>
                                <span class="status-badge <?= $statusClass ?> px-3 py-2 rounded-pill">
                                    <?= htmlspecialchars($topic['status']) ?>
                                </span>
                            </div>
                            <!-- TITLE -->
                            <h4 class="text-light fw-bold mb-1">
                                <?= htmlspecialchars($topic['topic_name']) ?>
                            </h4>
                            <!-- SUBJECT -->
                            <p class="text-info small mb-3">
                                <?= htmlspecialchars($topic['subject_name']) ?>
                            </p>
                            <!-- DESCRIPTION -->
                            <p class="text-secondary mb-4 flex-grow-1">
                                <?= htmlspecialchars($topic['description']) ?>
                            </p>
                            <!-- STATS -->
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="topic-meta-box text-center">
                                        <div class="topic-label text-light">
                                            Files
                                        </div>
                                        <div class="topic-value text-light">
                                            <?= $topic['total_files'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="topic-meta-box text-center">
                                        <div class="topic-label text-light">
                                            Questions
                                        </div>
                                        <div class="topic-value text-light">
                                            <?= $topic['total_questions'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FOOTER -->
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="badge <?= $masteryClass ?> px-3 py-2 rounded-pill">
                                    <?= htmlspecialchars($topic['mastery_level']) ?>
                                </span>
                                <a
                                    href="topic.php?id=<?= $topic['id'] ?>"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-4"
                                >
                                    Open Topic
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php include 'topics_pagination.php'; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-book display-5 text-secondary"></i>
                        <h4 class="fw-bold mb-2">
                            No Topics Found
                        </h4>
                        <p class="text-muted mb-0">
                            Try another search keyword or create a new topic.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>