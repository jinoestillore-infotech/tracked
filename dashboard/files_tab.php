<?php

/* Files Pagination */
$filesLimit = 6;

$filesPage = isset($_GET['files_page'])
    ? (int)$_GET['files_page']
    : 1;

if ($filesPage < 1) {
    $filesPage = 1;
}

$filesOffset = ($filesPage - 1) * $filesLimit;

/* Count Total Files */
$countStmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM topic_files
    WHERE topic_id = ?
");

$countStmt->bind_param("i", $topic_id);
$countStmt->execute();

$countResult = $countStmt->get_result();
$totalFiles = $countResult->fetch_assoc()['total'];

$totalFilesPages = ceil($totalFiles / $filesLimit);

/* Fetch Paginated Files */
$fileStmt = $conn->prepare("
    SELECT *
    FROM topic_files
    WHERE topic_id = ?
    ORDER BY uploaded_at DESC
    LIMIT ? OFFSET ?
");

$fileStmt->bind_param(
    "iii",
    $topic_id,
    $filesLimit,
    $filesOffset
);

$fileStmt->execute();

$files = $fileStmt->get_result();

?>

<!-- FILES -->
<div class="tab-pane fade <?= (isset($_GET['tab']) && $_GET['tab'] == 'files') ? 'show active' : ''; ?>"
     id="files">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-dark fw-bold mb-0">
            Learning Files
        </h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#uploadFileModal">
            <i class="bi bi-upload"></i>
            Upload File
        </button>
    </div>
    <!-- Files Grid -->
    <div class="row g-4">
        <?php if ($files->num_rows > 0): ?>
            <?php while ($file = $files->fetch_assoc()): ?>
                <?php
                    $extension = strtolower(
                        pathinfo(
                            $file['file_name'],
                            PATHINFO_EXTENSION
                        )
                    );
                    $icon = 'bi-file-earmark';
                    if ($extension == 'pdf') {
                        $icon = 'bi-file-earmark-pdf';
                    } elseif (
                        $extension == 'doc' ||
                        $extension == 'docx'
                    ) {
                        $icon = 'bi-file-earmark-word';
                    } elseif (
                        $extension == 'ppt' ||
                        $extension == 'pptx'
                    ) {
                        $icon = 'bi-file-earmark-ppt';
                    } elseif (
                        in_array($extension,
                        ['jpg','jpeg','png','gif'])
                    ) {
                        $icon = 'bi-file-earmark-image';
                    }
                ?>
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm subject-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="subject-icon">
                                        <i class="bi <?= $icon; ?>"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-light mb-1">
                                            <?= htmlspecialchars($file['file_name']); ?>
                                        </h6>
                                        <small class="text-secondary">
                                            Uploaded
                                            <?= date(
                                                "M d, Y",
                                                strtotime($file['uploaded_at'])
                                            ); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div></div>
                        </div>
                        <div class="card-footer border-0">
                            <!-- Buttons -->
                            <div class="d-flex flex-wrap gap-2">
                                <!-- View -->
                                <?php
                                    $previewable = in_array(
                                        $extension,
                                        ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'jfif']
                                    );
                                ?>
                                <?php if ($previewable): ?>
                                    <!-- View -->
                                    <a href="/student-tracker/<?= htmlspecialchars($file['file_path']); ?>"
                                    target="_blank"
                                    class="btn btn-primary btn-sm rounded-pill px-3">
                                        <i class="bi bi-eye"></i>
                                        View
                                    </a>
                                <?php endif; ?>
                                <!-- Download -->
                                <a href="/student-tracker/<?= htmlspecialchars($file['file_path']); ?>"
                                   download
                                   class="btn btn-outline-light btn-sm rounded-pill px-3">
                                    <i class="bi bi-download"></i>
                                    Download
                                </a>
                                <!-- Delete -->
                                <a href="process_delete_file.php?id=<?= $file['id']; ?>&topic_id=<?= $topic['id']; ?>"
                                   class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                   onclick="return confirm('Delete this file?')">
                                    <i class="bi bi-trash"></i>
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php include 'file_pagination.php'; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4 subject-card">
                    <div class="text-center">
                        <i class="bi bi-folder2-open display-5 text-secondary"></i>
                        <h5 class="fw-bold text-light mt-3">
                            No Files Uploaded
                        </h5>
                        <p class="text-secondary mb-0">
                            Upload reviewers, PDFs, PPTs, and study materials.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>