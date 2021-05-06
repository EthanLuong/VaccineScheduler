<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
    header("location: index.php");
    exit;
}
$dbhost = "localhost";
$dbuser = "root";
$dbpwd = "MySQLServer";
$dbname = "Vaccination";

$conn = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
if($conn->connect_error)
{
    echo "Error: could not connect to the DB";
    exit;
}
$nurseInfo = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  switch($_POST['submit']){
    case "view":
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

    }

    break;
    case "Delete";
    $myQ = "DELETE FROM NURSE WHERE EMPLOYEEID = ";
    $myQ .= $_POST['delID'];
    $conn->query($myQ);
    break;
    case "Update";
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
    break;
  }
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
    View Nurse Info
  </h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <select name="empID">
        <?php
            $myQ="SELECT FNAME, MI, LNAME, EMPLOYEEID FROM NURSE";
            $results = $conn->query($myQ);
            while($obj = $results->fetch_object())
                echo "<option value='".$obj->EMPLOYEEID."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";
        ?>
    </select>
    <input type="submit" name = "submit" value="view">
  </form>
  <?php echo $nurseInfo?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Delete Nurse</h2>
    <select name="delID">
        <?php
            $myQ="SELECT FNAME, MI, LNAME, EMPLOYEEID FROM NURSE";
            $results = $conn->query($myQ);
            while($obj = $results->fetch_object())
                echo "<option value='".$obj->EMPLOYEEID."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";


        ?>
        <input type="submit" name = "submit" value="Delete">
    </select>
  </form>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Update Nurse</h2>
    <select name="upID">
        <?php
            $myQ="SELECT FNAME, MI, LNAME, EMPLOYEEID FROM NURSE";
            $results = $conn->query($myQ);
            while($obj = $results->fetch_object())
                echo "<option value='".$obj->EMPLOYEEID."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";

            $conn->close();
        ?>
        <input type="submit" name = "submit" value="Update">
    </select>
    <br>
      First Name: <input type="text" name="fname">
      MI: <input type="text" name="mi">
      Last Name: <input type="text" name="lname"> <br>
      Age: <input type="text" name="age"> <br>
      Phone Number: <input type="text" name="phone"> <br>
      Gender:
          <select name="sex">
              <option disabled selected value> -- select an option -- </option>
              <option value="F">Female</option>
              <option value="M">Male</option>
              <option value="O">Others</option>
          </select><br>
      Address: <input type="text" name="address"> <br>
      <br>
    </form>
  <a href="admin.php">Home</a>
  <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</body>

</html>
