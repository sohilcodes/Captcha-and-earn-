<div id="sidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeMenu()">&times;</a>

    <?php if(isset($_SESSION["user"])): ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="earn.php">Earn Captcha</a>
        <a href="withdraw.php">Withdraw</a>
        <a href="history.php">History</a>
        <hr>
        <a href="logout.php" style="color:red;">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</div>
