<?php session_start();
$usersFile = __DIR__ . '/../db/users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : array();

if($_SERVER['REQUEST_METHOD']==='POST'){
  $email = trim($_POST['email']);
  $pass = trim($_POST['pass']);
  if($email && $pass){
    if(isset($users[$email])){ $err='User already exists'; }
    else{
      $users[$email] = [
        'password'=>$pass,
        'wallet'=>0.0,
        'today_used'=>0,
        'last_reset'=>date('Y-m-d'),
        'plan'=>null
      ];
      file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
      $_SESSION['user']=$email; header('Location:dashboard.php'); exit;
    }
  } else { $err='Enter details'; }
}
?>
<!DOCTYPE html>
<html><head><title>Register</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="header"><span class="menu-icon" onclick="openMenu()">&#9776;</span><h2>Register</h2></div>
<?php include 'sidebar.php'; ?>
<div class="content card">
  <?php if(isset($err)) echo "<p style='color:red'>$err</p>"; ?>
  <form method="post">
    <input class="input" type="email" name="email" placeholder="Email" required>
    <input class="input" type="password" name="pass" placeholder="Password" required>
    <button class="btn" type="submit">Register</button>
  </form>
</div>
<script src="assets/app.js"></script></body></html>
