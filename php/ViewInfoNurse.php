<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 2){
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

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $myQ = "UPDATE NURSE SET ";
  if(isset($_POST['phone']) && $_POST['phone'] != ""){
    $myQ .= " PHONE = '".$_POST['phone']."'";
  }
  if(isset($_POST['address']) && $_POST['address'] != ""){
    $myQ .= " ADDRESS = '".$_POST['address']."'";
  }
  $myQ .= " WHERE username = '".$_SESSION['username']."'";
  $conn->query($myQ);
}
$myQ = "SELECT * FROM NURSE WHERE username = ";
$myQ .= "'".$_SESSION['username']."'";
$result = $conn->query($myQ);
if($result){
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
  ;
}
else{
  $nurseInfo = "error";
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
    Info
  </h2>
  <?php echo $nurseInfo;
  echo "</br>";
  ?>
  <h2>Scheduled Times</h2>
  <?php
  $myQ = "SELECT * FROM timeslot, scheduledwork WHERE timeslot.TimeID = scheduledwork.TimeID AND EmployeeID = ";
  $myQ .= $_SESSION['id'];
  $result = $conn->query($myQ);
  if($result->num_rows > 0){
    echo "<table> <tr> <th>Date</th><th>Time</th></tr>";
    $row = $result->fetch_assoc();
    while($row != NULL){
      echo "<tr>";
      echo "<th>".$row['Date']."</th>";
      echo "<th>".$row['Start']."</th>";
      echo "</tr>";
      $row = $result->fetch_assoc();
    }
    echo "</table>";
    $conn->close();
  }
   ?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Update Your Info</h2>
    <br>
      Phone Number: <input type="text" name="phone"> <br>
      Address: <input type="text" name="address"> <br>
      <input type="submit" name="submit" value="Update">
      <br>
    </form>


  		<li><a href="nurse.php">Home</a></li>

</body>

</html>
