<html>
<!-- Give 10% raise to a specific employee -->
<body>
<h1>Promotion</h1>
<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpwd = "MySQLServer";
    $dbname = "Company";

    // Step 1: connect to DB
    $conn = new mysqli($dbhost,$dbuser,$dbpwd,$dbname);
    if($conn->connect_error) 
    {
        echo "Error: could not connect to the DB";
        exit;
    }
?>
<form action="Promote.php" method="post">
Select an employee for the Raise: 
<select name="empssn">
    <?php
        $myQ="SELECT FNAME, MI, LNAME, SSN FROM EMP";
        $results = $conn->query($myQ);
        while($obj = $results->fetch_object())
            echo "<option value='".$obj->SSN."'>". $obj->FNAME ." ".$obj->MI." ".$obj->LNAME ."</option>";
    ?>
</select>
<input type="submit" value="Raise Salary by 10%"/>
</form>
<?php
    //Step 2
    // Update the salary of employee by 10%
    if($_POST["empssn"])
    {   
        $myQ = "update EMP set SALARY = salary * 1.1 WHERE ssn =" . $_POST["empssn"];
        if($conn->query($myQ)) echo "Salary raised successfully!";
        else echo "Error: " . $conn->error; 
    }

    // Step 3: Terminate
    $conn->close();
?>
</body>
</html>