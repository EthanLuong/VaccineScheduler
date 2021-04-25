<html>
<body>

<form action="DB1.php" method="post">
    Name of the department: <input type="text" name="dpt"/>
    <input type="submit" value="Apply!"/>
</form>

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
    
    //echo "Successfully connected to the DB server <br>";

    // Step 2: Issue SQL Queries
    // Retreive the information of all employee of the department
    // specified by the user
    if(!$_POST["dpt"]) $myQ = "select * from emp";
    else $myQ = "select emp.* from emp join dept on dno=dnumber where dname='". $_POST["dpt"] . "'";
    $results = $conn->query($myQ);
    echo $results->num_rows;

    echo "<table border='1'>";
    foreach($results as $r)
    {
        echo "<tr>";
            foreach($r as $c) echo "<td>" . $c . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Step 3: Terminate connection
    $conn->close();
?>
</body>
</html>