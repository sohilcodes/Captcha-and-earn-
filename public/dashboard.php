<?php session_start();
if(!isset($_SESSION['user'])){ header('Location:login.php'); exit; }
$usersFile = __DIR__ . '/../db/users.json';
$users = json_decode(file_get_contents($usersFile), true);
$user = $users[$_SESSION['user']];

// daily reset
if(!isset($user['last_reset']) || $user['last_reset'] !== date('Y-m-d')){
  $users[$_SESSION['user']]['today_used'] = 0;
  $users[$_SESSION['user']]['last_reset'] = date('Y-m-d');
  file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
  $user = $users[$_SESSION['user']];
}

?>
<!DOCTYPE html>
<html><head><title>Dashboard</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="header"><span class="menu-icon" onclick="openMenu()">&#9776;</span><h2>Dashboard</h2></div>
<?php include 'sidebar.php'; ?>
<div class="content">
  <div class="card">
    <h3>Your Wallet: ₹<?=number_format($user['wallet'],2)?></h3>
    <p class="small">Today used: <?=$user['today_used']?> captchas</p>
    <p class="small">Plan: <?=($user['plan']? $user['plan']['plan'].' ('.htmlspecialchars($user['plan']['status']).')' : 'Free')?></p>
    <a class="btn" href="earn.php">Solve Captcha</a>
    <a class="btn" href="plan.php">Buy Plan</a>
  </div>

  <div class="card">
    <h3>Quick Links</h3>
    <a href="history.php">Earnings History</a><br>
    <a href="withdraw.php">Withdraw</a>
  </div>
</div>
<script src="assets/app.js"></script></body></html>
