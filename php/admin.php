<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
    header("location: index.php");
    exit;
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
  <ul>
    <li><a class="active" href="admin.php">Home</a></li>
    <li><a href="NurseForm.php">Add Nurse</a></li>
    <li><a href="NurseUpdate.php">View/Update Nurse Info</a></li>
    <li><a href="adminpatient.php">View/Update Patient Info</a></li>
    <li><a href="vaccine.php">Update Vaccine Info</a></li>
    <li><a href="TimeSlot.php">Add Time Slot</a></li>
    <li><a href="AdminForm.php">Add New Admin</a></li>
    <li><a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a></li>
  </ul>
  <div class="wrapper navmargin">
  <?php echo "<h2>Welcome ".$_SESSION['username']."</h2>"?>
</div>
</body>

</html>
