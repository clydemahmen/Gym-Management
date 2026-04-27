<?php
require_once 'init.php';

if($auth->isLoggedIn()){
    header("Location: dashboard.php");
    exit();
}

$error = '';

if(isset($_POST['login'])){
    if($_POST['username'] && $_POST['password']){
        if($auth->login($_POST['username'], $_POST['password'])){
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GymTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: darkblue;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

<div class="card shadow" style="width: 400px;">
    <div class="card-body p-5">

        <div class="text-center mb-4">
            <h3 class="fw-bold">🏋️ GymTrack</h3>
            <p class="text-muted">Gym Management System</p>
        </div>

        <?php if($error != ''): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" name="login" class="btn btn-warning w-100">Login</button>
        </form>

        <p class="text-center text-muted mt-3">Default: <strong>admin</strong> / <strong>admin123</strong></p>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>