<html>
<body>
<!-- COVID Vaccine Patient Form -->
<h1>Add a new Employee</h1>
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

<form action="PatientForm.php" method="post">
    SSN: <input type="text" name="ssn"><br>
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
    Race:
        <select name="race">
            <option value="A">Asian</option>
            <option value="AA">African-American</option>
            <option value="NA">Native-American</option>
            <option value="PI">Pacific Islander</option>
            <option value="W">White</option>
        </select><br>
    Occupation: <input type="text" name="occupation"> <br>
    Address: <input type="text" name="address"> <br>
    Medical History: <input type="text" name="history"> <br>
    </select><br>
    <input type="submit" value="Add user!">
</form>

<?php
    if($_POST["fname"])
    {
        $myQ="INSERT INTO PATIENT(SSN,FNAME,MI,LNAME,AGE,PHONE,GENDER,RACE,OCCUPATION,ADDRESS,HISTORY) VALUES('";
        $myQ .= $_POST["ssn"]."','";
        $myQ .= $_POST["fname"]."','";
        $myQ .= $_POST["mi"]."','";
        $myQ .= $_POST["lname"]."','";
        $myQ .= $_POST["age"]."','";
        $myQ .= $_POST["phone"]."',";
        if($_POST["sex"] == "M"){
        $myQ .= "1"."','";
        } elseif ($_POST["sex"] == "F"){
        $myQ .= "0"."','";
        } else{
        $myQ .= "NULL".",'";
        }
        $myQ .= $_POST["race"]."','";
        $myQ .= $_POST["occupation"]."','";
        $myQ .= $_POST["address"]."','";
        $myQ .= $_POST["history"]."')";
        echo "Query to execute: " . $myQ . "<br>";
        if($conn->query($myQ)) echo "The new patient added successfully!";
        else echo "Error: " . $conn->error;
    }

    // Step 3: Terminate Connection
    $conn->close();
?>
</body>
</html>
