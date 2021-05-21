<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
    header("location: index.php");
    exit;
}
require_once "config.php";
if($conn->connect_error)
{
    echo "Error: could not connect to the DB";
    exit;
}
$nurseInfo = "";
$table = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  switch($_POST['submit']){
    case "View":
    if(isset($_POST['empID'])){
      $myQ = "SELECT * FROM NURSE WHERE EMPLOYEEID = ";
      $myQ .= $_POST['empID'];
      $result = $conn->query($myQ);
      $row = $result->fetch_assoc();
      $nurseInfo = "<span><b>Name: </b>";
      $nurseInfo .= $row['FName']." ".$row['MI']." ".$row['LName'];
      $nurseInfo .= "<br><b>Age: </b>";
      $nurseInfo .= $row['Age'];
      $nurseInfo .= "<br><b>Phone Number: </b>";
      $nurseInfo .= $row['Phone'];
      $nurseInfo .= "<br><b>Address: </b>";
      $nurseInfo .= $row['Address'];
      $nurseInfo .= "<br><b>Gender: </b>";
      if($row['Gender'] == NULL){
        $nurseInfo .= "Other";
      }
      elseif($row['Gender'] == 1){
        $nurseInfo .= "Male";
      }
      elseif($row['Gender'] == 0){
        $nurseInfo .= "Female";
      }
      $nurseInfo .= "</span>";
      $myQ = "SELECT * FROM timeslot, scheduledwork WHERE timeslot.TimeID = scheduledwork.TimeID AND EmployeeID = ";
      $myQ .= $_POST['empID'];
      $result = $conn->query($myQ);
      if($result->num_rows > 0){
        $table = "<table> <tr> <th>Date</th><th>Time</th></tr>";
        $row = $result->fetch_assoc();
        while($row != NULL){
          $table .= "<tr>";
          $table .= "<th>".$row['Date']."</th>";
          $table .=  "<th>".$row['Start']."</th>";
          $table .=  "</tr>";
          $row = $result->fetch_assoc();
        }
        $table .=  "</table>";
      }

    }

    break;
    case "Delete";
    if(isset($_POST['delID']))
    {
    $myQ = "DELETE FROM NURSE WHERE EMPLOYEEID = ";
    $myQ .= $_POST['delID'];
    $conn->query($myQ);
    }
    break;
    case "Update";
    if(isset($_POST['upID']))
    {
    $myQ = "UPDATE NURSE SET ";
    if(isset($_POST['fname']) && $_POST['fname'] != ""){
      $myQ .= "FNAME = '".$_POST['fname']."'";
    }
    if(isset($_POST['mi']) && $_POST['mi'] != ""){
      $myQ .= " MI = '".$_POST['mi']."'";
    }
    if(isset($_POST['lname']) && $_POST['lname'] != ""){
      $myQ .= " LNAME = '".$_POST['lname']."'";
    }
    if(isset($_POST['age']) && $_POST['age'] != ""){
      $myQ .= " AGE = ".$_POST['age'];
    }
    if(isset($_POST['phone']) && $_POST['phone'] != ""){
      $myQ .= " PHONE = '".$_POST['phone']."'";
    }
    if(isset($_POST['sex']) && $_POST['sex'] != ""){
      $myQ .= " GENDER = ";
      if($_POST["sex"] == "M"){
      $myQ .= "1";
      } elseif ($_POST["sex"] == "F"){
      $myQ .= "0";
      } else{
      $myQ .= "NULL";
      }
    }
    if(isset($_POST['address']) && $_POST['address'] != ""){
      $myQ .= " ADDRESS = '".$_POST['address']."'";
    }
    $myQ .= " WHERE EMPLOYEEID = ".$_POST['upID'];
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
    <li><a class="active" href="NurseUpdate.php">View/Update Nurse Info</a></li>
    <li><a href="adminpatient.php">View/Update Patient Info</a></li>
    <li><a href="vaccine.php">Update Vaccine Info</a></li>
    <li><a href="TimeSlot.php">Add Time Slot</a></li>
    <li><a href="AdminForm.php">Add New Admin</a></li>
    <li><a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a></li>
  </ul>
  <div class="wrapper">


  <h2 class="navmargin">
    View Nurse Info
  </h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <select name="empID">
      <option disabled selected value> -- select an option -- </option>
        <?php
            $myQ="SELECT FNAME, MI, LNAME, EMPLOYEEID FROM NURSE";
            $results = $conn->query($myQ);
            while($obj = $results->fetch_object())
                echo "<option value='".$obj->EMPLOYEEID."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";
        ?>
    </select>
    <input class="button" id="submit"type="submit" name = "submit" value="View">
  </form>
  <?php echo $nurseInfo;
  echo "</br>";
  echo $table;

  ?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Delete Nurse</h2>
    <select name="delID">
      <option disabled selected value> -- select an option -- </option>
        <?php
            $myQ="SELECT FNAME, MI, LNAME, EMPLOYEEID FROM NURSE";
            $results = $conn->query($myQ);
            while($obj = $results->fetch_object())
                echo "<option value='".$obj->EMPLOYEEID."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";


        ?>
        <input class="button" id="submit"type="submit" name = "submit" value="Delete">
    </select>
  </form>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Update Nurse</h2>
    <div class="form-group">
    <select name="upID">
      <option disabled selected value> -- select an option -- </option>
        <?php
            $myQ="SELECT FNAME, MI, LNAME, EMPLOYEEID FROM NURSE";
            $results = $conn->query($myQ);
            while($obj = $results->fetch_object())
                echo "<option value='".$obj->EMPLOYEEID."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";

            $conn->close();
        ?>
        <input type="submit" class="button" id="submit" name="submit" value="Update">
    </select></div>
    <div class="form-group">
      First Name: <input type="text" name="fname">
      MI: <input type="text" name="mi">
      Last Name: <input type="text" name="lname"> <br>
    </div>
    <div class="form-group">
      Age: <input type="text" name="age"> <br>
</div>
<div class="form-group">
      Phone Number: <input type="text" name="phone"> <br>
    </div>
    <div class="form-group">
      Gender:
          <select name="sex">
              <option disabled selected value> -- select an option -- </option>
              <option value="F">Female</option>
              <option value="M">Male</option>
              <option value="O">Others</option>
          </select><br>
        </div>
        <div class="form-group">
      Address: <input type="text" name="address">
      </div> <br>
      <br>
    </form>
  </div>
</body>

</html>
