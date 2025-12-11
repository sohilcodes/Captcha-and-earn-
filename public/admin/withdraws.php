<?php session_start(); if(!isset($_SESSION['admin'])){ header('Location:index.php'); exit; }
$withdrawFile = __DIR__ . '/../../db/withdraw.json';
$usersFile = __DIR__ . '/../../db/users.json';
$withdraws = file_exists($withdrawFile)? json_decode(file_get_contents($withdrawFile), true):[];

// approve endpoint
if(isset($_GET['action']) && $_GET['action']==='approve' && isset($_GET['id'])){
  $i=intval($_GET['id']); if(isset($withdraws[$i])){ $withdraws[$i]['status']='approved'; file_put_contents($withdrawFile,json_encode($withdraws,JSON_PRETTY_PRINT)); }
}
?>
<!DOCTYPE html>
<html><head><title>Withdraws</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="header"><h2>Withdraw Requests</h2></div>
<div class="content card">
  <?php foreach($withdraws as $i=>$w): ?>
    <div class="log-row"><div><?=htmlspecialchars($w['email'])?> — ₹<?=number_format($w['amount'],2)?></div>
    <div><?=htmlspecialchars($w['status'])?> <?php if($w['status']==='pending'): ?> <a href="?action=approve&id=<?=$i?>">Approve</a><?php endif; ?></div></div>
  <?php endforeach; ?>
</div>
</body></html>
