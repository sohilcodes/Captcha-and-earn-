<?php session_start();
// admin credentials (from user)
$adminUser = 'sohilkhan.21';
$adminPass = 'Khansohel143';

if($_SERVER['REQUEST_METHOD']==='POST'){
  if($_POST['user']===$adminUser && $_POST['pass']===$adminPass){
    $_SESSION['admin']=true; header('Location:dashboard.php'); exit;
  } else { $err='Invalid admin'; }
}
?>
<!DOCTYPE html>
<html><head><title>Admin Login</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="header"><h2>Admin Login</h2></div>
<div class="content card">
  <?php if(isset($err)) echo "<p style='color:red'>$err</p>"; ?>
  <form method="post">
    <input class="input" name="user" placeholder="username" required>
    <input class="input" name="pass" placeholder="password" required>
    <button class="btn">Login</button>
  </form>
</div>
</body></html>
