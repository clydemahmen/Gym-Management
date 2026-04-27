<?php if(!isset($activePage)) $activePage = ''; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-warning" href="dashboard.php">🏋️ GymTrack</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php if($activePage == 'dashboard') echo 'active text-warning'; ?>" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($activePage == 'members') echo 'active text-warning'; ?>" href="members.php">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($activePage == 'sessions') echo 'active text-warning'; ?>" href="sessions.php">Sessions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($activePage == 'reports') echo 'active text-warning'; ?>" href="reports.php">Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($activePage == 'about') echo 'active text-warning'; ?>" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($activePage == 'developers') echo 'active text-warning'; ?>" href="developers.php">Developers</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-secondary me-3">👤 <?= $_SESSION['user_name'] ?> (<?= $_SESSION['user_role'] ?>)</span>
                <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
            </div>
        </div>
    </div>
</nav>