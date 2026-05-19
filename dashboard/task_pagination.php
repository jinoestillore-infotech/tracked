<?php if ($totalTasksPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center justify-content-lg-end">

            <!-- Previous -->
            <li class="page-item <?= ($tasksPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $subject['id']; ?>&tab=tasks&tasks_page=<?= $tasksPage - 1; ?>">
                    Previous
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalTasksPages; $i++): ?>
                <li class="page-item <?= ($tasksPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link text-dark border-0"
                       href="?id=<?= $subject['id']; ?>&tab=tasks&tasks_page=<?= $i; ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= ($tasksPage >= $totalTasksPages) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $subject['id']; ?>&tab=tasks&tasks_page=<?= $tasksPage + 1; ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>