<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 1){
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
$patientInfo = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $myQ = "UPDATE PATIENT SET ";
  if(isset($_POST['phone']) && $_POST['phone'] != ""){
    $myQ .= " PHONE = '".$_POST['phone']."'";
  }
  if(isset($_POST['address']) && $_POST['address'] != ""){
    $myQ .= " ADDRESS = '".$_POST['address']."'";
  }
  if(isset($_POST['occupation']) && $_POST['occupation'] != ""){
    $myQ .= " OCCUPATION = '".$_POST['occupation']."'";
  }
  $myQ .= " WHERE username = '".$_SESSION['username']."'";
  ;
  $conn->query($myQ);


}
$myQ = "SELECT * FROM PATIENT WHERE username = ";
$myQ .= "'".$_SESSION['username']."'";
$result = $conn->query($myQ);
if($result){
  $row = $result->fetch_assoc();
  $patientInfo = "<span><b>Name: </b>";
  $patientInfo .= $row['FName']." ".$row['MI']." ".$row['LName'];
  $patientInfo .= "<br><b>Age: </b>";
  $patientInfo .= $row['Age'];
  $patientInfo .= "<br><b>Phone Number: </b>";
  $patientInfo .= $row['Phone'];
  $patientInfo .= "<br><b>Address: </b>";
  $patientInfo .= $row['Address'];
  $patientInfo .= "<br><b>Gender: </b>";
  if($row['Gender'] == NULL){
    $patientInfo .= "Other";
  }
  elseif($row['Gender'] == 1){
    $patientInfo .= "Male";
  }
  elseif($row['Gender'] == 0){
    $patientInfo .= "Female";
  }
  $patientInfo .= "</span>";
  ;
}
$patientInfo .= "<br><b>Occupation: </b>";
$patientInfo .= $row['Occupation'];
$patientInfo .= "<br><b>History: </b>";
$patientInfo .= $row['History'];
$patientInfo .= "<br><b>Race: </b>";
switch($row['Race']){
  case "A":
  $patientInfo .= "Asian";
  break;
  case "AA":
  $patientInfo .= "African-American";
  break;
  case "NA":
  $patientInfo .= "Native-American";
  break;
  case "PI":
  $patientInfo .= "Pacific Islander";
  break;
  case "W":
  $patientInfo .= "Caucasian";
  break;
}
$patientInfo .= "</span></br>";
$myQ = "SELECT nurse.FName, nurse.MI, nurse.LName, Date, Start, Name, Dose FROM vaccinehistory, nurse, timeslot WHERE vaccinehistory.TimeID = timeslot.TimeID AND vaccinehistory.EmployeeID = nurse.EmployeeID AND UserID = ";
$myQ .= $_SESSION['id'];
$result = $conn->query($myQ);
if($result->num_rows > 0){
  $patientInfo .= "<h2>History</h2><table> <tr> <th>Nurse</th><th>Date</th><th>Time</th><th>Vaccine</th><th>Dose</th></tr>";
  while($row = $result->fetch_assoc()){
    $patientInfo.= "<tr>";
    $patientInfo.= "<th>".$row['FName']." ".$row['MI']." ".$row['LName']."</th>";
    $patientInfo.= "<th>".$row['Date']."</th>";
    $patientInfo.= "<th>".$row['Start']."</th>";
    $patientInfo.= "<th>".$row['Name']."</th>";
    $patientInfo.= "<th>".$row['Dose']."</th>";
    $patientInfo.= "</tr>";
  }
  $patientInfo .= "</table></br>";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <style type="text/css">
  #navlist li
    {
    display: inline;
    list-style-type: none;
    padding-right: 20px;
    }
  </style>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
  <h2>
    Info
  </h2>
  <?php echo $patientInfo ?>
  <h2>Scheduled Times</h2>
  <?php
  echo "</br>";
  $myQ = "SELECT * FROM timeslot, scheduledvaccine WHERE timeslot.TimeID = scheduledvaccine.TimeID AND UserID = ";
  $myQ .= $_SESSION['id'];

  $result = $conn->query($myQ);
  if($result->num_rows > 0){
    echo "<table> <tr> <th>Date</th><th>Time</th><th>Vaccine</th><th>Dose</th></tr>";
    $row = $result->fetch_assoc();
    while($row != NULL){
      echo "<tr>";
      echo "<th>".$row['Date']."</th>";
      echo "<th>".$row['Start']."</th>";
      echo "<th>".$row['Name']."</th>";
      echo "<th>".$row['Dose']."</th>";
      echo "</tr>";
      $row = $result->fetch_assoc();
    }
    echo "</table></br>";



    $conn->close();
  }
   ?>
  <h2>Update Your Info</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  Phone Number: <input type="text" name="phone"> <br>
  Occupation: <input type="text" name="occupation"> <br>
  Address: <input type="text" name="address"> <br>
  <input type="submit" name="submit" value="Update">
  </form>


  <div id="navcontainer">
	<ul id="navlist">
		<li><a href="patient.php">Home</a></li>
		<li><a href="logout.php">Sign Out of Your Account</a></li>
	</ul>
  </div>

</body>
</body>

</html>
