<!-- TOPIC TABS -->
    <ul class="nav nav-pills mb-4 gap-2">
        <li class="nav-item">
            <a class="nav-link <?= (!isset($_GET['tab']) || $_GET['tab'] == 'overview') ? 'active' : ''; ?>"
               href="?id=<?= $topic['id']; ?>&tab=overview">
                Overview
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (isset($_GET['tab']) && $_GET['tab'] == 'highlights') ? 'active' : ''; ?>"
               href="?id=<?= $topic['id']; ?>&tab=highlights">
                Highlights
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (isset($_GET['tab']) && $_GET['tab'] == 'files') ? 'active' : ''; ?>"
               href="?id=<?= $topic['id']; ?>&tab=files">
                Files
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (isset($_GET['tab']) && $_GET['tab'] == 'questions') ? 'active' : ''; ?>"
               href="?id=<?= $topic['id']; ?>&tab=questions">
                Practice Questions
            </a>
        </li>
    </ul>
