<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Captcha Pro - Home</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="header">
    <span class="menu-icon" onclick="openMenu()">&#9776;</span>
    <h2>Captcha & Earn By Sohil Tips </h2>
</div>

<?php include "sidebar.php"; ?>

<div class="content">
    <h1>Earn Money by Solving Captchas</h1>

    <?php if(isset($_SESSION["user"])): ?>
        <p>Welcome back, <?= $_SESSION["user"] ?> 👋</p>
        <a href="dashboard.php" class="btn">Go to Dashboard</a>
    <?php else: ?>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
    <?php endif; ?>
</div>

<script src="assets/app.js"></script>
</body>
</html>
