<?php if ($totalTopicsPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center justify-content-lg-end">

            <!-- Previous -->
            <li class="page-item <?= ($topicsPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $subject['id']; ?>&tab=topics&topics_page=<?= $topicsPage - 1; ?>">
                    Previous
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalTopicsPages; $i++): ?>
                <li class="page-item <?= ($topicsPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link text-dark border-0"
                       href="?id=<?= $subject['id']; ?>&tab=topics&topics_page=<?= $i; ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= ($topicsPage >= $totalTopicsPages) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $subject['id']; ?>&tab=topics&topics_page=<?= $topicsPage + 1; ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>