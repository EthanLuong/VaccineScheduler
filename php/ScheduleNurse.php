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
$form = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	switch($_POST["submit"]){
		case "Select":
		$myQ = "SELECT * FROM timeslot WHERE DATE = ";
		$myQ .= "'".$_POST["date"]."' AND TimeID NOT IN (SELECT scheduledwork.TimeID FROM scheduledwork,timeslot WHERE scheduledwork.TimeID = timeslot.TimeID AND EmployeeID = ".$_SESSION['id'].")";
		$myQ .= " AND NumNurses < 12";

		$result = $conn->query($myQ);
    if($result->num_rows > 0){
      $form = '';
      $row = $result->fetch_assoc();
      while($row != NULL){
        $form .= '<input type="radio" name="d" value = "';
        $form .= $row['TimeID'].'">'.$row['Start']."</br>";
        $row = $result->fetch_assoc();
      }
      $form .= '<input type="submit" name="submit" value="Schedule">';

    }else{
      $form = "<h2>No Available Slots This Day</h2>";
    }
		break;
    case "Schedule":
    $myQ = "INSERT INTO SCHEDULEDWORK(EMPLOYEEID, TIMEID) VALUES";
    $myQ .= "(".$_SESSION['id'].",".$_POST['d'].")";

    $conn->query($myQ);
    $myQ = "UPDATE timeslot SET NumNurses = NumNurses + 1 WHERE TimeID = ".$_POST['d'];

    $conn->query($myQ);
    break;
    case "Cancel":
    $myQ = "DELETE FROM scheduledwork WHERE TimeID = ".$_POST['f']." AND EmployeeID = ".$_SESSION['id'];
    $conn->query($myQ);
    $myQ = "UPDATE timeslot SET NumNurses = NumNurses - 1 WHERE TimeID = ".$_POST['f'];
    $conn->query($myQ);
	}
}

?>

<html>
<head>
<title>Schedule your time slot below</title>
</head>



<body>

<FORM METHOD ="POST" ACTION ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<h2>Select Date</h2>
	<select name="date">

			<?php
					$myQ="SELECT distinct Date FROM timeslot WHERE Date >= CURRENT_DATE() ORDER BY DATE";
					$results = $conn->query($myQ);
					while($obj = $results->fetch_object())
							echo "<option value='".$obj->Date."'>".$obj->Date."</option>";

			?>
			<input type="submit" name="submit" value="Select">
	</select>
</FORM>
<FORM METHOD ="POST" ACTION ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<?php echo $form?>
</FORM>

<h2>Cancel Scheduled Time</h2>
<FORM METHOD ="POST" ACTION ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <?php
    $myQ = "SELECT * FROM scheduledwork,timeslot WHERE scheduledwork.TimeID = timeslot.TimeID AND EmployeeID = ".$_SESSION["id"];
    $result = $conn->query($myQ);
    if($result->num_rows > 0){

      while($row = $result->fetch_assoc()){
        echo '<input type="radio" name="f" value = "'.$row['TimeID'].'">'.$row['Date']." ".$row['Start']."</br>";
      }

    } else{
      echo "<h3>No Scheduled Times</h2>";
    }
    $conn->close();
  ?>
  <input type="submit" name="submit" value="Cancel">
</FORM>
<li><a href="index.php">Home</a></li>

</body>
</html>
