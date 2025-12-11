<?php session_start();
if(!isset($_SESSION['user'])){ header('Location:login.php'); exit; }
$usersFile = __DIR__ . '/../db/users.json';
$withdrawFile = __DIR__ . '/../db/withdraw.json';
$users = json_decode(file_get_contents($usersFile), true);
$user = $users[$_SESSION['user']];
$msg='';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $amount = floatval($_POST['amount']); $upi = trim($_POST['upi']);
  if($amount <= 0) $msg='Invalid amount';
  elseif($amount > $user['wallet']) $msg='Insufficient balance';
  elseif($amount < 100) $msg='Minimum withdraw is ₹100';
  else{
    $requests = file_exists($withdrawFile) ? json_decode(file_get_contents($withdrawFile), true) : array();
    $requests[] = ['email'=>$_SESSION['user'],'amount'=>$amount,'upi'=>$upi,'status'=>'pending','time'=>date('Y-m-d H:i')];
    file_put_contents($withdrawFile, json_encode($requests, JSON_PRETTY_PRINT));
    $msg='requested';
  }
}
?>
<!DOCTYPE html>
<html><head><title>Withdraw</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="header"><span class="menu-icon" onclick="openMenu()">&#9776;</span><h2>Withdraw</h2></div>
<?php include 'sidebar.php'; ?>
<div class="content">
  <?php if($msg==='requested') echo "<div class='notice'>Withdraw request sent. Admin will process soon.</div>"; elseif($msg) echo "<div class='notice' style='color:red'>$msg</div>"; ?>
  <div class="card">
    <form method="post">
      <input class="input" type="number" name="amount" placeholder="Amount (₹)" required>
      <input class="input" type="text" name="upi" placeholder="UPI ID (for payout)" required>
      <button class="btn" type="submit">Request Withdraw</button>
    </form>
  </div>
</div>
<script src="assets/app.js"></script></body></html>
