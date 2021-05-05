<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
    header("location: login.php");
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
  $myQ = "SELECT * FROM PATIENT WHERE SSN = ";
  $myQ .= $_POST['ssn'];
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
  $patientInfo .= "</span>";

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
     <select name="ssn">
         <?php
             $myQ="SELECT FNAME, MI, LNAME, SSN FROM PATIENT";
             $results = $conn->query($myQ);
             while($obj = $results->fetch_object())
                 echo "<option value='".$obj->SSN."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";

             $conn->close();
         ?>
         <input type="submit" name = "submit" value="View">
     </select>
   </form>
   <?php echo $patientInfo?>

 </body>

 </html>
