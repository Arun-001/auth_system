<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav>
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <?php if (basename($_SERVER['PHP_SELF']) !== 'login.php'): ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
                <?php if (basename($_SERVER['PHP_SELF']) !== 'register.php'): ?>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </nav>
    <hr>
