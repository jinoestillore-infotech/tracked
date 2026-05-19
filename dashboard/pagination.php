<!-- Subjects Grid -->
     <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center justify-content-lg-end">

                <!-- Previous -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link text-dark border-0"
                    href="?page=<?= $page - 1; ?>">
                        Previous
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link text-dark border-0"
                        href="?page=<?= $i; ?>">
                            <?= $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next -->
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link text-dark border-0"
                    href="?page=<?= $page + 1; ?>">
                        Next
                    </a>
                </li>

            </ul>
        </nav>
    <?php endif; ?>