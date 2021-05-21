<?php
include('login.php'); // Includes Login Script

if(isset($_SESSION['login_user'])){
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cumberland AC Championship Admin & Statistician Login</title>
  <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">
</head>
<body>
<div id="main">
<h1>Cumberland AC Championship Admin & Statistician Login</h1>
<div id="login">
<h2>Login Form</h2>
<form action="" method="post">
<label>Username :</label>
<input id="name" name="username" placeholder="username" type="text">
<label>Password :</label>
<input id="password" name="password" placeholder="**********" type="password">
<input name="submit" type="submit" value=" Login ">
<span><?php echo $error; ?></span>
</form>
</div>
</div>
</body>
</html>