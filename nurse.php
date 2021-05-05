<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 2){
    header("location: login.php");
    exit;
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
  <h2>
    NURSE WELCOME PAGE
  </h2>
  <a href="ViewInfoNurse.php">View Info</a>
  <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</body>

</html>
