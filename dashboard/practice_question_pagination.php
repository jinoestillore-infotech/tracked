<?php if ($totalQuestionsPages > 1): ?> 
    <nav class="mt-4">
        <ul class="pagination justify-content-center justify-content-lg-end">

            <!-- Previous -->
            <li class="page-item <?= ($questionsPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $topic['id']; ?>&tab=questions&questions_page=<?= $questionsPage - 1; ?>">
                    Previous
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalQuestionsPages; $i++): ?>
                <li class="page-item <?= ($questionsPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link text-dark border-0"
                       href="?id=<?= $topic['id']; ?>&tab=questions&questions_page=<?= $i; ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= ($questionsPage >= $totalQuestionsPages) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $topic['id']; ?>&tab=questions&questions_page=<?= $questionsPage + 1; ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>