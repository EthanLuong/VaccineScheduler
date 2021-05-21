<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
    header("location: index.php");
    exit;
}

require_once "config.php";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$myQ = "INSERT INTO timeslot(Date, Start) VALUES";
$myQ .= "('".$_POST['date']."','".$_POST['time']."')";
echo $myQ;
$result = $conn->query($myQ);
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
    <li><a href="admin.php">Home</a></li>
    <li><a href="NurseForm.php">Add Nurse</a></li>
    <li><a href="NurseUpdate.php">View/Update Nurse Info</a></li>
    <li><a href="adminpatient.php">View/Update Patient Info</a></li>
    <li><a href="vaccine.php">Update Vaccine Info</a></li>
    <li><a class="active" href="TimeSlot.php">Add Time Slot</a></li>
    <li><a href="AdminForm.php">Add New Admin</a></li>
    <li><a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a></li>
  </ul>
  <div class="wrapper">

  <h2 class="navmargin">
    Add Time Slot
  </h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">
      Date (YYYY-MM-DD): <input type="text" name="date"><br>
    </div>
    <div class="form-group">
      Time (HH:MM:SS): <input type="text" name="time">
    </div>
<input class="button" id="submit" type="submit" class="btn btn-primary" value="Submit">
    </form>
    </div>
</body>

</html>
