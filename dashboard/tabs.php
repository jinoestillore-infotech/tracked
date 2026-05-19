    <ul class="nav nav-pills mb-4 gap-2" id="subjectTabs">
        <li class="nav-item">
            <button class="nav-link <?= (!isset($_GET['tab']) || $_GET['tab'] == 'overview') ? 'active' : '' ?>"
                    data-bs-toggle="pill"
                    data-bs-target="#overview">
                Overview
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link <?= (isset($_GET['tab']) && $_GET['tab'] == 'notes') ? 'active' : '' ?>"
                    data-bs-toggle="pill"
                    data-bs-target="#notes">
                Notes
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link <?= (isset($_GET['tab']) && $_GET['tab'] == 'tasks') ? 'active' : '' ?>"
                    data-bs-toggle="pill"
                    data-bs-target="#tasks">
                Tasks
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link <?= (isset($_GET['tab']) && $_GET['tab'] == 'topics') ? 'active' : '' ?>"
                    data-bs-toggle="pill"
                    data-bs-target="#topics">
                Topics
            </button>
        </li>
    </ul>