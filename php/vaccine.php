<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
    header("location: index.php");
    exit;
}
require_once "config.php";

$vaccineInfo = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  switch($_POST['submit']){
      case "Update":
      $myQ = "INSERT INTO VACCINE(NAME, COMPANY, AVAILIBILITY, ONHOLD) VALUES ";
      $myQ .= "('".$_POST['name']."','".$_POST['company']."',".$_POST['doses'].",0)";

      $conn->query($myQ);
      break;
      case "View":
      if(isset($_POST['vaccinename'])){
        $myQ = "SELECT * FROM VACCINE WHERE NAME = '";
        $myQ .= $_POST['vaccinename']."'";
        $result = $conn->query($myQ);
        $row = $result->fetch_assoc();
        $vaccineInfo = "<span><b>Name: </b>";
        $vaccineInfo .= $row['Name'];
        $vaccineInfo .= "<br><b>Company: </b>";
        $vaccineInfo .= $row['Company'];
        $vaccineInfo .= "<br><b>Availibility: </b>";
        $vaccineInfo .= $row['Availibility'];
        $vaccineInfo .= "<br><b>On Hold: </b>";
        $vaccineInfo .= $row['OnHold'];
      }
      break;
      case "Add":
      if(isset($_POST['addname']) & isset($_POST['adddoses']) && is_numeric($_POST['adddoses'])){
        $myQ = "UPDATE VACCINE SET AVAILIBILITY = AVAILIBILITY + ";
        $myQ .= $_POST['adddoses']." WHERE NAME = '";
        $myQ .= $_POST['addname']."'";
        $conn->query($myQ);
      }
      break;
      case "Set":
      if(isset($_POST['setname']) & isset($_POST['setdoses']) && is_numeric($_POST['setdoses'])){
        $myQ = "UPDATE VACCINE SET AVAILIBILITY = ";
        $myQ .= $_POST['setdoses']." WHERE NAME = '";
        $myQ .= $_POST['setname']."'";
        $conn->query($myQ);
      }
      break;

  }

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
    <li><a href="admin.php">Home</a></li>
    <li><a href="NurseForm.php">Add Nurse</a></li>
    <li><a href="NurseUpdate.php">View/Update Nurse Info</a></li>
    <li><a href="adminpatient.php">View/Update Patient Info</a></li>
    <li><a class="active" href="vaccine.php">Update Vaccine Info</a></li>
    <li><a href="TimeSlot.php">Add Time Slot</a></li>
    <li><a href="AdminForm.php">Add New Admin</a></li>
    <li><a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a></li>
  </ul>
  <div class="wrapper">
  <h2 class="navmargin">
    View Vaccine Info
  </h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <select name="vaccinename">
      <option disabled selected value> -- select an option -- </option>
      <?php
          $myQ="SELECT NAME FROM VACCINE";
          $results = $conn->query($myQ);
          while($obj = $results->fetch_object())
              echo "<option value='".$obj->NAME."'>".$obj->NAME."</option>";
      ?>
    </select>
    <input class="button" id="submit" type="submit" name = "submit" value="View">
  </form>
  <?php echo $vaccineInfo?>
  <h2>Add new Vaccine</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">
      Name: <input type="text" name="name"><br>
      </div>
      <div class="form-group">
      Company: <input type="text" name="company"> <br>
    </div>
      <div class="form-group">
      Doses: <input type="text" name="doses"> <br>
    </div>
      <br>
      <input type="submit" name = "submit" value="Update">
    </form>

    <h2>Add doses</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
      <select name="addname">
        <option disabled selected value> -- select an option -- </option>
        <?php
            $myQ="SELECT NAME FROM VACCINE";
            $results = $conn->query($myQ);
            while($obj = $results->fetch_object())
                echo "<option value='".$obj->NAME."'>".$obj->NAME."</option>";
        ?>
      </select><input class="button" id="submit" type="submit" name = "submit" value="Add"><br>
    </div>
      Doses: <input type="text" name="adddoses"> <br>

    </form>

    <h2>Set Doses</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
      <select name="setname">
        <option disabled selected value> -- select an option -- </option>
        <?php
            $myQ="SELECT NAME FROM VACCINE";
            $results = $conn->query($myQ);
            while($obj = $results->fetch_object())
                echo "<option value='".$obj->NAME."'>".$obj->NAME."</option>";
        ?>
      </select>
      <input class="button" id="submit"type="submit" name = "submit" value="Set"> </br>
    </div>
      Doses: <input type="text" name="setdoses"> <br>

    </form>
      </div>
</body>

</html>
