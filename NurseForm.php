<html>
<body>
<!-- COVID Vaccine Patient Form -->
<h1>Add a new Nurse</h1>
<?php
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
    Address: <input type="text" name="address"> <br>
    </select><br>
    <input type="submit" value="Add Nurse!">
</form>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $myQ="INSERT INTO NURSE(FNAME,MI,LNAME,AGE,PHONE,GENDER,ADDRESS) VALUES('";

        $myQ .= $_POST["fname"]."','";
        $myQ .= $_POST["mi"]."','";
        $myQ .= $_POST["lname"]."','";
        $myQ .= $_POST["age"]."','";
        $myQ .= $_POST["phone"]."',";
        if($_POST["sex"] == "M"){
        $myQ .= "1".",'";
        } elseif ($_POST["sex"] == "F"){
        $myQ .= "0".",'";
        } else{
        $myQ .= "NULL".",'";
        }

        $myQ .= $_POST["address"]."')";
        echo "Query to execute: " . $myQ . "<br>";
        if($conn->query($myQ)) echo "The new patient added successfully!";
        else echo "Error: " . $conn->error;
    }

    // Step 3: Terminate Connection
    $conn->close();
?>
</body>
</html>
