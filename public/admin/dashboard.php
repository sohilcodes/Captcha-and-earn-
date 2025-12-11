<?php session_start(); if(!isset($_SESSION['admin'])){ header('Location:index.php'); exit; }
$usersFile = __DIR__ . '/../../db/users.json';
$withdrawFile = __DIR__ . '/../../db/withdraw.json';
$plansFile = __DIR__ . '/../../db/plans.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : array();
$withdraws = file_exists($withdrawFile) ? json_decode(file_get_contents($withdrawFile), true) : array();
$plans = file_exists($plansFile) ? json_decode(file_get_contents($plansFile), true) : array();
?>
<!DOCTYPE html>
<html><head><title>Admin Dashboard</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="header"><h2>Admin Dashboard</h2></div>
<div class="content">
  <div class="card">
    <h3>Quick Actions</h3>
    <a href="users.php" class="btn">Users</a>
    <a href="withdraws.php" class="btn">Withdraw Requests (<?=count($withdraws)?>)</a>
    <a href="plans.php" class="btn">Plan Requests (<?=count(array_filter($plans, fn($p)=>$p['status']==='pending'))?>)</a>
  </div>
</div>
</body></html>
