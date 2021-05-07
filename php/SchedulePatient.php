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
$form = "";
$form2 = "";
$show = False;
$scheduled = False;
$history = False;
$myQ = "SELECT * FROM scheduledvaccine WHERE UserID = ".$_SESSION['id'];
$result = $conn->query($myQ);
if($result->num_rows > 0){
	$scheduled = True;
}

$myQ = "SELECT * FROM vaccinehistory WHERE UserID = ".$_SESSION['id'];
$result = $conn->query($myQ);
if($result->num_rows > 0){
	$history = True;
}


if($_SERVER["REQUEST_METHOD"] == "POST")
{
	switch($_POST["submit"]){
		case "Select":
		$myQ = "SELECT * FROM timeslot WHERE DATE >= CURDATE() AND DATE = ";
		$myQ .= "'".$_POST["date"]."' AND TimeID NOT IN (SELECT scheduledvaccine.TimeID FROM scheduledvaccine,timeslot WHERE scheduledvaccine.TimeID = timeslot.TimeID AND UserID = ".$_SESSION['id'].")";
		$myQ .= " AND NumNurses * 10 > NumPatients AND NumPatients < 100";
		$result = $conn->query($myQ);
    if($result->num_rows > 0){
			$show = True;
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
		if($history){
			$myQ = "SELECT vaccine.Name FROM vaccinehistory, vaccine WHERE vaccinehistory.Name = vaccine.Name AND Availibility > 0 AND UserID = ".$_SESSION['id'];
			$result = $conn->query($myQ);
			if($result->num_rows > 0){
				$row = $result->fetch_assoc();
				$form2 = '<select name="vaccine">';
				$form2 .= "<option value='".$row['Name']."'>".$row['Name']."</option>";
				$form2 .= '</select>';
			}
			else{
				$form2 = "<h2>No Vaccines available</h2>";
				$form = "";
			}

		}else{
			$myQ="SELECT distinct Name FROM Vaccine WHERE Availibility > 0";
			$results = $conn->query($myQ);
			if($results->num_rows > 0){
				$form2 = '<select name="vaccine">';
				while($obj = $results->fetch_object())
						$form2 .= "<option value='".$obj->Name."'>".$obj->Name."</option>";
				$form2 .= '</select>';
			}else{
				$form2 = "<h2>No Vaccines available</h2>";
				$form = "";
			}
		}


		break;
    case "Schedule":
		$dose = '1';
		if($history){
			$dose = '2';
		}

    $myQ = "INSERT INTO scheduledvaccine(UserID, TIMEID, Name, Dose) VALUES";
    $myQ .= "(".$_SESSION['id'].",".$_POST['d'].",'".$_POST['vaccine']."','".$dose."')";

    $conn->query($myQ);
    $myQ = "UPDATE timeslot SET NumPatients = NumPatients + 1 WHERE TimeID = ".$_POST['d'];
    $conn->query($myQ);
		$myQ = "UPDATE vaccine SET Availibility = Availibility - 1, OnHold = OnHold + 1 WHERE Name = '".$_POST['vaccine']."'";
		$conn->query($myQ);
		header("Refresh:0");
    break;
    case "Cancel":
		$myQ = "SELECT Name FROM scheduledvaccine WHERE UserID = ".$_SESSION['id'];
		$result = $conn->query($myQ);
		$row = $result->fetch_assoc();
    $myQ = "DELETE FROM scheduledvaccine WHERE TimeID = ".$_POST['f']." AND UserID = ".$_SESSION['id'];
    $conn->query($myQ);
    $myQ = "UPDATE timeslot SET NumPatients = NumPatients - 1 WHERE TimeID = ".$_POST['f'];
    $conn->query($myQ);
		$myQ = "UPDATE vaccine SET Availibility = Availibility + 1, OnHold = OnHold - 1 WHERE Name = '".$row['Name']."'";
		$conn->query($myQ);
		header("Refresh:0");

	}

}

?>

<html>
<head>
<title>Schedule your time slot below</title>
</head>



<body>

<FORM METHOD ="POST" ACTION ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<?php
	if(!$scheduled){
		echo "<h2>Select Date</h2>
		<select name='date'>";
		$myQ="SELECT distinct Date FROM timeslot WHERE Date >= CURRENT_DATE() ORDER BY DATE";
		$results = $conn->query($myQ);
		while($obj = $results->fetch_object())
				echo "<option value='".$obj->Date."'>".$obj->Date."</option>";
	}



			?>
			<?php
			if(!$scheduled){
				echo '</select>
			<input type="submit" name="submit" value="Select">';
			}

			?>

</FORM>
<FORM METHOD ="POST" ACTION ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<?php
if($show){
	echo $form2;
}
echo $form;
?>
</FORM>


<FORM METHOD ="POST" ACTION ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  <?php
		if($scheduled){
			echo "<h2>Cancel Scheduled Time</h2>";
		}
    $myQ = "SELECT * FROM scheduledvaccine,timeslot WHERE scheduledvaccine.TimeID = timeslot.TimeID AND UserID = ".$_SESSION["id"];
    $result = $conn->query($myQ);
    if($result->num_rows > 0){

      while($row = $result->fetch_assoc()){
        echo '<input type="radio" name="f" value = "'.$row['TimeID'].'">'.$row['Date']." ".$row['Start']."</br>";
      }

    } else{
      echo "<h3>No Scheduled Times</h2>";
    }
    $conn->close();
		if($scheduled){
			echo '<input type="submit" name="submit" value="Cancel">';
		}

  ?>

</FORM>
<li><a href="index.php">Home</a></li>
</body>
</html>
