<?php session_start();
if(!isset($_SESSION['user'])){ header('Location:login.php'); exit; }
$usersFile = __DIR__ . '/../db/users.json';
$earnFile = __DIR__ . '/../db/earnings.json';
$plansFile = __DIR__ . '/../db/plans.json';

$users = json_decode(file_get_contents($usersFile), true);
$earnings = file_exists($earnFile) ? json_decode(file_get_contents($earnFile), true) : array();

$user = $users[$_SESSION['user']];

// reset check
if(!isset($user['last_reset']) || $user['last_reset'] !== date('Y-m-d')){
  $users[$_SESSION['user']]['today_used'] = 0;
  $users[$_SESSION['user']]['last_reset'] = date('Y-m-d');
  file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
  $user = $users[$_SESSION['user']];
}

// determine daily limit
$dailyLimit = 3; // free default
if(isset($user['plan']) && $user['plan']['status']==='active'){
  $dailyLimit = intval($user['plan']['daily_limit']);
}

$canSolve = ($user['today_used'] < $dailyLimit);

// generate captcha code for display
$captchaStr = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),0,6);

$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  // verify
  if(!$canSolve){ $msg='limit'; }
  else{
    $entered = trim($_POST['code']); $real = trim($_POST['realcode']);
    if($entered === $real){
      // random earning 3-9
      $amount = rand(3,9);
      $users[$_SESSION['user']]['wallet'] += $amount;
      $users[$_SESSION['user']]['today_used'] += 1;

      $earnings[] = ['email'=>$_SESSION['user'],'amount'=>$amount,'time'=>date('Y-m-d H:i')];
      file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
      file_put_contents($earnFile, json_encode($earnings, JSON_PRETTY_PRINT));
      $msg = 'success:'.$amount;

      // recompute
      $user = $users[$_SESSION['user']];
      $canSolve = $user['today_used'] < $dailyLimit;
    } else { $msg='wrong'; }
  }
}

?>
<!DOCTYPE html>
<html><head><title>Earn Captcha</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="header"><span class="menu-icon" onclick="openMenu()">&#9776;</span><h2>Earn</h2></div>
<?php include 'sidebar.php'; ?>
<div class="content">
  <?php if($msg==='wrong') echo "<div class='notice'>Wrong code!</div>"; ?>
  <?php if($msg==='limit') echo "<div class='notice'>Limit reached. Please buy a plan.</div>"; ?>
  <?php if(strpos($msg,'success:')===0){ $amt = explode(':',$msg)[1]; echo "<div class='notice'>Correct! You earned ₹$amt</div>"; } ?>

  <div class="card captcha-box">
    <?php if($canSolve): ?>
      <div class="captcha"><?=htmlspecialchars($captchaStr)?></div>
      <form method="post">
        <input type="hidden" name="realcode" value="<?=htmlspecialchars($captchaStr)?>">
        <input class="input" type="text" name="code" placeholder="Enter Captcha" required>
        <button class="btn" type="submit">Submit</button>
      </form>
    <?php else: ?>
      <div class="notice">You have used your daily captchas. Please buy a plan to continue.</div>
      <script>showPlanPopup();</script>
    <?php endif; ?>
  </div>

  <div class="card">
    <p class="small">Daily limit: <?=$dailyLimit?> | Used today: <?=$user['today_used']?></p>
  </div>
</div>
<script src="assets/app.js"></script></body></html>
