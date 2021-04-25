<?php
    $name = "default user";
    if($_POST["fname"]) $name = $_POST["fname"] . " " . $_POST["lname"];
    echo "<h2>Welcome " . $name ."</h2>";
?>