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
    <link rel="stylesheet" href="style.css">
</head>

<body>
  <ul>
    <li><a class="active" href="nurse.php">Home</a></li>
    <li><a href="ViewInfoNurse.php">View Info</a></li>
    <li><a href="RecordVaccine.php">Record Completed Vaccine</a></li>
    <li><a href="ScheduleNurse.php">Schedule Work</a></li>
    <li><a href="logout.php">Sign Out of Your Account</a></li>
  </ul>

</body>
<div class="wrapper navmargin">
<?php echo "<h2>Welcome ".$_SESSION['username']."</h2>"?>
</div>

</html>
