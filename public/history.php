<?php session_start(); if(!isset($_SESSION['user'])){ header('Location:login.php'); exit; }
$earnFile = __DIR__ . '/../db/earnings.json';
$earnings = file_exists($earnFile) ? json_decode(file_get_contents($earnFile), true) : array();
$my = array_filter($earnings, fn($e)=> $e['email']===$_SESSION['user']);
?>
<!DOCTYPE html>
<html><head><title>History</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="header"><span class="menu-icon" onclick="openMenu()">&#9776;</span><h2>History</h2></div>
<?php include 'sidebar.php'; ?>
<div class="content card">
  <h3>Earns</h3>
  <?php foreach(array_reverse($my) as $row): ?>
    <div class="log-row"><div><?=htmlspecialchars($row['time'])?></div><div>+₹<?=number_format($row['amount'],2)?></div></div>
  <?php endforeach; ?>
</div>
<script src="assets/app.js"></script></body></html>
