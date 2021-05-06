<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 2){
    header("location: index.php");
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
  <li><a href="ViewInfoNurse.php">View Info</a></li>
  <li><a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a></li>
</body>

</html>
