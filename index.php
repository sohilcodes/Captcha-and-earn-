<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Home - Solve Captcha & Earn By Sohil Tips</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- HEADER -->
<div class="header">
    <span class="menu-icon" onclick="openMenu()">&#9776;</span>
    <h2>Captcha & Earn By Sohil Tips</h2>
</div>

<?php include "sidebar.php"; ?>

<div class="home-container">
    <h1>Welcome <?php echo $_SESSION["user"] ?? "Guest"; ?> 👋</h1>

    <p>Earn money by solving captchas.</p>

    <a href="earn.php" class="btn">Start Earning</a>
</div>

<script src="assets/app.js"></script>
</body>
</html>
