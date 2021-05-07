
<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] != 2){
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

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  switch($_POST['submit']){
    case "Select":
    $id = $_POST['id'];
    $myQ = "SELECT timeslot.TimeID, vaccine.Name, Dose FROM scheduledvaccine, timeslot, vaccine WHERE scheduledvaccine.TimeID = timeslot.TimeID AND scheduledvaccine.Name = vaccine.Name AND scheduledvaccine.UserID = ".$id;

    echo "</br>";
    $result = $conn->query($myQ);
    $row = $result->fetch_assoc();
    $myQ = "INSERT INTO vaccinehistory(EmployeeID, TimeID, Name, Dose, UserID) VALUES";
    $myQ .= "(".$_SESSION['id'].",".$row['TimeID'].",'".$row['Name']."','".$row['Dose']."',".$id.")";

      $result = $conn->query($myQ);
      echo "</br>";
    // $result = $conn->query($myQ);
    $myQ = "UPDATE vaccine SET OnHold = OnHold - 1 WHERE Name = '".$row['Name']."'";

      $result = $conn->query($myQ);
      echo "</br>";
    $myQ = "DELETE FROM scheduledvaccine WHERE UserID = ".$id;

      $result = $conn->query($myQ);
      echo "</br>";

    break;
  }
}
?>


<head>
<title>Schedule your time slot below</title>
</head>



<body>

<FORM METHOD ="POST" ACTION ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<h2>Record Patient Vaccinated</h2>
	<select name="id">

			<?php
					$myQ="SELECT FName, MI, LName, patient.UserID FROM scheduledvaccine, patient WHERE scheduledvaccine.UserID = patient.UserID ";
					$results = $conn->query($myQ);
					while($obj = $results->fetch_object())
							echo "<option value='".$obj->UserID."'>".$obj->FName." ".$obj->MI." ".$obj->LName."</option>";

			?>
	</select>
<input type="submit" name="submit" value="Select">
</FORM>
<li><a href="index.php">Home</a></li>
</body>
</html>
