<?php
require_once 'init.php';
Auth::check();
$activePage = 'developers';
$pageTitle  = 'Developers';
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-people-fill me-2 text-warning"></i>Meet the Developers</h4>

    <div class="row g-4 mb-4">
        <?php foreach([
            ['Sam Ceremonia','Full-Stack Developer','bi-laptop','primary',
             'Designed the database schema and relationships, developed the dashboard and reports page with JOIN queries, and set up the XAMPP local environment.'],
            ['Kenjie Corcega','Backend Developer','bi-code-slash','success',
             'Built the OOP classes (Database, User, Auth, Member, GymSession), implemented form handling, input validation, session authentication, and password hashing.'],
            ['Clyde Errol Del Valle','UI/UX and Deployment','bi-palette','warning',
             'Designed the Bootstrap UI, built the navbar and layouts, set up the GitHub repository, and deployed the system to InfinityFree.'],
        ] as [$name,$role,$icon,$color,$desc]): ?>
        <div class="col-md-4">
            <div class="card shadow-sm h-100 border-top border-4 border-<?=$color?>">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="bi <?=$icon?> fs-1 text-<?=$color?>"></i></div>
                    <h5 class="fw-bold"><?=$name?></h5>
                    <span class="badge bg-<?=$color?> mb-3"><?=$role?></span>
                    <p class="text-muted small"><?=$desc?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">Project Information</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <?php foreach([
                    ['Subject','ITEL 203 – Web Systems and Technologies'],
                    ['Task','Group Performance Task #3 – Secure OOP PHP Web Application with Relational Database'],
                    ['System','GymTrack – Smart Gym Management System'],
                    ['Section','Information Technology 2B'],
                    ['Date',date('F d, Y')],
                ] as [$label,$val]): ?>
                <tr>
                    <td class="fw-semibold text-muted" style="width:180px"><?=$label?></td>
                    <td><?=$val?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
