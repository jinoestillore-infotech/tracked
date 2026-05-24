<!-- PAGINATION -->
<?php if ($totalPages > 1): ?>
    <nav class="mt-5">
        <ul class="pagination justify-content-center justify-content-lg-end">

            <!-- Previous -->
            <li class="page-item <?= ($topicsPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?page=<?= $topicsPage - 1; ?>&search=<?= urlencode($search); ?>&subject=<?= urlencode($subjectFilter); ?>">
                    Previous
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($topicsPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link text-dark border-0"
                       href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>&subject=<?= urlencode($subjectFilter); ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= ($topicsPage >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?page=<?= $topicsPage + 1; ?>&search=<?= urlencode($search); ?>&subject=<?= urlencode($subjectFilter); ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>