<?php if ($totalFilesPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center justify-content-lg-end">

            <!-- Previous -->
            <li class="page-item <?= ($filesPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $topic['id']; ?>&tab=files&files_page=<?= $filesPage - 1; ?>">
                    Previous
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalFilesPages; $i++): ?>
                <li class="page-item <?= ($filesPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link text-dark border-0"
                       href="?id=<?= $topic['id']; ?>&tab=files&files_page=<?= $i; ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= ($filesPage >= $totalFilesPages) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $topic['id']; ?>&tab=files&files_page=<?= $filesPage + 1; ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>