<?php session_start();
if(!isset($_SESSION['user'])){ header('Location:login.php'); exit; }
$plansFile = __DIR__ . '/../db/plans.json';
$usersFile = __DIR__ . '/../db/users.json';
$plans = file_exists($plansFile) ? json_decode(file_get_contents($plansFile), true) : array();
$users = json_decode(file_get_contents($usersFile), true);

$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $plan = $_POST['plan']; // '50' or '100'
  $entry = [
    'email'=>$_SESSION['user'],
    'plan'=>$plan,
    'status'=>'pending',
    'requested_at'=>date('Y-m-d H:i')
  ];
  $plans[] = $entry;
  file_put_contents($plansFile, json_encode($plans, JSON_PRETTY_PRINT));
  $msg='requested';
}
?>
<!DOCTYPE html>
<html><head><title>Buy Plan</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="header"><span class="menu-icon" onclick="openMenu()">&#9776;</span><h2>Buy Plan</h2></div>
<?php include 'sidebar.php'; ?>
<div class="content">
  <?php if($msg==='requested') echo "<div class='notice'>Plan request submitted. Admin will approve soon.</div>"; ?>
  <div class="card">
    <h3>Available Plans</h3>
    <div class="log-row"><div>₹50 — 15 days — 10 captchas/day</div><div><form method="post"><input type="hidden" name="plan" value="50"><button class="btn">Request ₹50</button></form></div></div>
    <div class="log-row"><div>₹100 — 30 days — 20 captchas/day</div><div><form method="post"><input type="hidden" name="plan" value="100"><button class="btn">Request ₹100</button></form></div></div>
  </div>
</div>
<script src="assets/app.js"></script></body></html>
