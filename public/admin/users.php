<?php session_start(); if(!isset($_SESSION['admin'])){ header('Location:index.php'); exit; }
$usersFile = __DIR__ . '/../../db/users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : array();
?>
<!DOCTYPE html>
<html><head><title>Users</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="header"><h2>Users</h2></div>
<div class="content card">
  <table width="100%">
    <tr><th>Email</th><th>Wallet</th><th>Today Used</th><th>Plan</th></tr>
    <?php foreach($users as $email=>$u): ?>
      <tr>
        <td><?=htmlspecialchars($email)?></td>
        <td>₹<?=number_format($u['wallet'],2)?></td>
        <td><?=$u['today_used']??0?></td>
        <td><?=isset($u['plan'])?($u['plan']['plan'].' ('.$u['plan']['status'].')'):'Free'?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
</body></html>
