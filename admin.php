<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
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
    ADMIN WELCOME PAGE
  </h2>
  <a href="NurseForm.php">Add Nurse</a>
  <a href="NurseUpdate.php">Nurses</a>
  <a href="adminpatient.php">View Patient Info</a>
  <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</body>

</html>
