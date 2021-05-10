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
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$myQ = "INSERT INTO timeslot(Date, Start) VALUES";
$myQ .= "('".$_POST['date']."','".$_POST['time']."')";
echo $myQ;
$result = $conn->query($myQ);
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
    Add Time Slot
  </h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      Date (YYYY-MM-DD): <input type="text" name="date"><br>
      Time (HH:MM:SS): <input type="text" name="time">
<input type="submit" class="btn btn-primary" value="Submit">
    </form>
  <li><a href="index.php">Home</a></li>
</body>

</html>
