<?php if ($totalNotesPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center justify-content-lg-end">

            <!-- Previous -->
            <li class="page-item <?= ($notesPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $subject['id']; ?>&tab=notes&notes_page=<?= $notesPage - 1; ?>">
                    Previous
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalNotesPages; $i++): ?>
                <li class="page-item <?= ($notesPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link text-dark border-0"
                       href="?id=<?= $subject['id']; ?>&tab=notes&notes_page=<?= $i; ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= ($notesPage >= $totalNotesPages) ? 'disabled' : ''; ?>">
                <a class="page-link text-dark border-0"
                   href="?id=<?= $subject['id']; ?>&tab=notes&notes_page=<?= $notesPage + 1; ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>
<?php endif; ?>