<?php if ($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center justify-content-lg-end">

            <!-- PREVIOUS -->
            <li class="page-item <?= ($plansPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link"
                   href="?page=<?= $plansPage - 1; ?>">
                    Previous
                </a>
            </li>

            <!-- PAGE NUMBERS -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($plansPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link"
                       href="?page=<?= $i; ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- NEXT -->
            <li class="page-item <?= ($plansPage >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link"
                   href="?page=<?= $plansPage + 1; ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>