<html>
    <body>
        <?php
            $coursename = "Database System";
            
            if($coursename == "")
            {
                echo "<h1>Welcome to course default!</h1>";
            }
            else
                echo "<h1>Welcome to course " . $coursename . "!...</h1>";
        ?>
    </body>
</html>