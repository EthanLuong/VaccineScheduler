<html>
<body>
<!-- COVID Vaccine Patient Form -->
<h1>Add a new Nurse</h1>
<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpwd = "root";
    $dbname = "Patient"
    
    $conn = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
    if($conn->connect_error)
    {
        echo "Error: could not connect to the DB";
        exit;
    }
?>

<form action="NurseForm.php" method="post">
    First Name: <input type="text" name="fname">
    MI: <input type="text" name="mi">
    Last Name: <input type="text" name="lname"> <br>
    Age: <input type="text" name="age"> <br>
    Phone Number: <input type="text" name="phone"> <br>
    Gender:
        <select name="sex">
            <option value="F">Female</option>
            <option value="M">Male</option>
            <option value="O">Others</option>
        </select><br>
    EmployeeID: <input type="text" name="EmployeeID"> <br>
    Address: <input type="text" name="address"> <br>
    </select><br>
    <input type="submit" value="Add Nurse!">
</form>

<?php
    if($_POST["fname"])
    {
        $myQ="INSERT INTO NURSE(FNAME,MI,LNAME,AGE,PHONE,SEX,RACE,OCCUPATION,ADDRESS,HISTORY) VALUES('";

        $myQ .= $_POST["fname"]."','";
        $myQ .= $_POST["mi"]."','";
        $myQ .= $_POST["lname"]."','";
        $myQ .= $_POST["age"]."','";
        $myQ .= $_POST["phone"]."','";
        $myQ .= $_POST["sex"]."','";
        $myQ .= $_POST["occupation"]."','";
        $myQ .= $_POST["address"]."',";
        $myQ .= $_POST["history"]."'";
        echo "Query to execute: " . $myQ . "<br>";
        if($conn->query($myQ)) echo "The new patient added successfully!";
        else echo "Error: " . $conn->error;
    }

    // Step 3: Terminate Connection
    $conn->close();
?>
</body>
</html>
