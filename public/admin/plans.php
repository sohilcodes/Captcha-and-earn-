<?php session_start(); if(!isset($_SESSION['admin'])){ header('Location:index.php'); exit; }
$plansFile = __DIR__ . '/../../db/plans.json';
$usersFile = __DIR__ . '/../../db/users.json';
$plans = file_exists($plansFile)? json_decode(file_get_contents($plansFile), true):[];
$users = json_decode(file_get_contents($usersFile), true);

if(isset($_GET['action']) && isset($_GET['id'])){
  $id=intval($_GET['id']); if(isset($plans[$id])){
    if($_GET['action']==='approve'){
      // activate plan on user
      $p = $plans[$id];
      $email = $p['email'];
      $days = $p['plan']==='50'?15:30;
      $daily = $p['plan']==='50'?10:20;
      $users[$email]['plan'] = [
        'plan'=>$p['plan'], 'status'=>'active', 'start'=>date('Y-m-d'), 'expire'=>date('Y-m-d', strtotime("+{$days} days")), 'daily_limit'=>$daily
      ];
      $plans[$id]['status']='approved';
      file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
      file_put_contents($plansFile, json_encode($plans, JSON_PRETTY_PRINT));
    } elseif($_GET['action']==='reject'){
      $plans[$id]['status']='rejected'; file_put_contents($plansFile,json_encode($plans,JSON_PRETTY_PRINT));
    }
  }
}
?>
<!DOCTYPE html>
<html><head><title>Plan Requests</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="header"><h2>Plan Requests</h2></div>
<div class="content card">
  <?php foreach($plans as $i=>$p): ?>
    <div class="log-row"><div><?=htmlspecialchars($p['email'])?> — ₹<?=$p['plan']?> — <?=htmlspecialchars($p['status']??'pending')?></div>
    <div>
      <?php if(($p['status']??'pending')==='pending'): ?>
        <a href="?action=approve&id=<?=$i?>">Approve</a> |
        <a href="?action=reject&id=<?=$i?>">Reject</a>
      <?php else: ?>
        <?=htmlspecialchars($p['status'])?>
      <?php endif; ?>
    </div></div>
  <?php endforeach; ?>
</div>
</body></html>
