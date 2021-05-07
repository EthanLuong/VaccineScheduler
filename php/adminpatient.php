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
$table = "";
$patientInfo = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $myQ = "SELECT * FROM PATIENT WHERE UserID = ";
  $myQ .= $_POST['id'];

  $result = $conn->query($myQ);
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
  $myQ .= $_POST['id'];
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

  $myQ = "SELECT * FROM timeslot, scheduledvaccine WHERE timeslot.TimeID = scheduledvaccine.TimeID AND UserID = ";
  $myQ .= $_POST['id'];
  $result = $conn->query($myQ);
  if($result->num_rows > 0){
    $table = "<table> <tr> <th>Date</th><th>Time</th><th>Vaccine</th><th>Dose</th></tr>";
    $row = $result->fetch_assoc();
    while($row != NULL){
      $table .= "<tr>";
      $table .= "<th>".$row['Date']."</th>";
      $table .=  "<th>".$row['Start']."</th>";
      $table .= "<th>".$row['Name']."</th>";
      $table .=  "<th>".$row['Dose']."</th>";
      $table .=  "</tr>";
      $row = $result->fetch_assoc();
    }
    $table .=  "</table>";
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
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
     <h2>View Patient Info</h2>
     <select name="id">
         <?php
             $myQ="SELECT FNAME, MI, LNAME, UserID FROM PATIENT";
             $results = $conn->query($myQ);
             while($obj = $results->fetch_object())
                 echo "<option value='".$obj->UserID."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";

             $conn->close();
         ?>
         <input type="submit" name = "submit" value="View">
     </select>
   </form>
   <?php echo $patientInfo;
   echo "</br>";
   ?>

   <?php
   if($table != ""){
     echo "<h2>Scheduled Appointments</h2>";
   }

   echo $table;

   ?>
<li><a href="index.php">Home</a></li>
 </body>

 </html>
