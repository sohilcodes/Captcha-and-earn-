<?php session_start();
$usersFile = __DIR__ . '/../db/users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : array();

if($_SERVER['REQUEST_METHOD']==='POST'){
  $email = trim($_POST['email']); $pass = trim($_POST['pass']);
  if(isset($users[$email]) && $users[$email]['password'] === $pass){
    $_SESSION['user']=$email; header('Location:dashboard.php'); exit;
  } else { $err='Invalid credentials'; }
}
?>
<!DOCTYPE html>
<html><head><title>Login</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="header"><span class="menu-icon" onclick="openMenu()">&#9776;</span><h2>Login</h2></div>
<?php include 'sidebar.php'; ?>
<div class="content card">
  <?php if(isset($err)) echo "<p style='color:red'>$err</p>"; ?>
  <form method="post">
    <input class="input" type="email" name="email" placeholder="Email" required>
    <input class="input" type="password" name="pass" placeholder="Password" required>
    <button class="btn" type="submit">Login</button>
  </form>
</div>
<script src="assets/app.js"></script></body></html>
