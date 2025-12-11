<?php
session_start();

$usersFile = "../db/users.json";
$earnFile = "../db/earnings.json";

$users = json_decode(file_get_contents($usersFile), true);
$earnings = json_decode(file_get_contents($earnFile), true);

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$captcha = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 6);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["code"] == $_POST["realcode"]) {

        // add wallet
        $email = $_SESSION["user"];
        $users[$email]["wallet"] += 10;

        // save log
        $earnings[] = [
            "email" => $email,
            "amount" => 10,
            "time" => date("d-m-Y H:i")
        ];

        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
        file_put_contents($earnFile, json_encode($earnings, JSON_PRETTY_PRINT));

        $msg = "Correct! ₹10 added.";
    } else {
        $msg = "Wrong code!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Earn</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="header">
    <span class="menu-icon" onclick="openMenu()">&#9776;</span>
    <h2>Earn Captcha</h2>
</div>

<?php include "sidebar.php"; ?>

<div class="home-container">
    
    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>

    <div class="captcha-box">
        <h2><?php echo $captcha; ?></h2>

        <form method="POST">
            <input type="hidden" name="realcode" value="<?php echo $captcha; ?>">
            <input type="text" name="code" placeholder="Enter Captcha" required>

            <button class="btn">Submit</button>
        </form>
    </div>

</div>

<script src="assets/app.js"></script>
</body>
</html>
