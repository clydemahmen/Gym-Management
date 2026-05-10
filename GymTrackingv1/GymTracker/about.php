<?php
require_once 'init.php';
$auth->check();
$activePage = 'about';
$pageTitle  = 'About';
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">
    <h4 class="fw-bold mb-4">About the Project</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h6 class="card-title fw-bold border-bottom pb-2">Project Title</h6>
            <p class="mb-0"><strong>GymTrack – Smart Gym Management System</strong></p>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h6 class="card-title fw-bold border-bottom pb-2">Purpose of the System</h6>
            <p class="mb-0">GymTrack is a web-based system that allows gym staff to manage members, record gym sessions, monitor revenue, and track which staff member processed each transaction.</p>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h6 class="card-title fw-bold border-bottom pb-2">System Features</h6>
            <ul style="padding-left: 20px; line-height: 2;">
                <li>Secure login and logout with session and password hashing</li>
                <li>Add, Edit, Delete Members (CRUD)</li>
                <li>Add, Edit, Delete Sessions (CRUD)</li>
                <li>Dashboard with statistics</li>
                <li>Reports page using JOIN queries</li>
                <li>Search and filter records</li>
                <li>Revenue tracking</li>
                <li>OOP PHP Architecture</li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h6 class="card-title fw-bold border-bottom pb-2">Technologies Used</h6>
            <ul style="padding-left: 20px; line-height: 2;">
                <li><strong>PHP (OOP)</strong> – Server-side scripting with classes</li>
                <li><strong>MySQL</strong> – Relational database with Foreign Keys</li>
                <li><strong>Bootstrap 5</strong> – UI Design</li>
                <li><strong>HTML5 / CSS3</strong> – Page structure and styling</li>
                <li><strong>XAMPP</strong> – Local development server</li>
                <li><strong>Visual Studio Code</strong> – Code editor</li>
                <li><strong>GitHub</strong> – Version control</li>
                <li><strong>InfinityFree</strong> – Deployment</li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h6 class="card-title fw-bold border-bottom pb-2">File Structure</h6>
            <pre>gym-system/
├── init.php
├── login.php
├── logout.php
├── navbar.php
├── dashboard.php
├── members.php
├── member_create.php
├── member_edit.php
├── member_delete.php
├── sessions.php
├── session_create.php
├── session_edit.php
├── session_delete.php
├── reports.php
├── about.php
├── developers.php
├── database.sql
└── classes/
    ├── Database.php
    ├── User.php
    ├── Auth.php
    ├── Member.php
    └── GymSession.php</pre>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="card-title fw-bold border-bottom pb-2">Database Relationships</h6>
            <pre>users (id, name, username, password, role)
  |
  +--> sessions (user_id FK) <-- members (id, full_name, membership_type, status)

One user (staff) -> MANY sessions
One member       -> MANY sessions</pre>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>