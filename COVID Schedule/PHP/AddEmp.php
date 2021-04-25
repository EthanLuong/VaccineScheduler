<html>
<body>
<!-- Create a web page to add new employees -->
<h1>Add a new Employee</h1>
<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpwd = "root";
    $dbname = "Company";

    // Step 1: connect to DB
    $conn = new mysqli($dbhost,$dbuser,$dbpwd,$dbname);
    if($conn->connect_error) 
    {
        echo "Error: could not connect to the DB";
        exit;
    }
?>
<form action="AddEmp.php" method="post">
    SSN: <input type="text" name="ssn"><br>
    First Name: <input type="text" name="fname">
    MI: <input type="text" name="mi">
    Last Name: <input type="text" name="lname"> <br>
    Gender:
        <select name="sex">
            <option value="F">Female</option>
            <option value="M">Male</option>
            <option value="O">Others</option>
        </select><br>
    Address: <input type="text" name="address"> <br>
    Department:
    <select name="dno">
        <?php
        $myQ="SELECT DNAME, DNUMBER FROM DEPT";
        $results = $conn->query($myQ);
        while($obj = $results->fetch_object())
            echo "<option value='".$obj->DNUMBER."'>". $obj->DNAME ."</option>";
        ?>
    </select><br>
    Supervisor:
    <select name="supssn">
        <?php
        $myQ="SELECT FNAME, MI, LNAME, SSN FROM EMP";
        $results = $conn->query($myQ);
        while($obj = $results->fetch_object())
            echo "<option value='".$obj->SSN."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";
        ?>
    </select><br>
    <input type="submit" value="Add user!">
</form>

<?php
    if($_POST["fname"])
    {
        $myQ="INSERT INTO EMP(SSN,FNAME,MI,LNAME,SEX,ADDRESS,DNO,SUPSSN) VALUES('";
        $myQ .= $_POST["ssn"]."','";
        $myQ .= $_POST["fname"]."','";
        $myQ .= $_POST["mi"]."','";
        $myQ .= $_POST["lname"]."','";
        $myQ .= $_POST["sex"]."','";
        $myQ .= $_POST["address"]."',";
        $myQ .= $_POST["dno"].",'";
        $myQ .= $_POST["supssn"]."')";
        echo "Query to execute: " . $myQ . "<br>";
        if($conn->query($myQ)) echo "The new user added successfully!";
        else echo "Error: " . $conn->error;
    }

    // Step 3: Terminate Connection
    $conn->close();
?>
</body>
</html>