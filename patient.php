<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 1){
    header("location: index.php");
    exit;
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
  <h1 style="color:red;">Patient's <h1 style ="color:blue;" >WELCOME PAGE</h1>
  <div id="footer">
	<ul>
		<li><a href="ViewInfoPatient.php">View Info</a></li>
		<li><a href="logout.php">Sign Out of Your Account</a></li>
	</ul>
  </div>


</body>

</html>
