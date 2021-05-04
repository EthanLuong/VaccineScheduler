<?php
// Include config file
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
    header("location: login.php");
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
// Define variables and initialize with empty values
$username = $password = $success = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
      $sql = "SELECT username FROM nurse WHERE username = ";
      $sql .= "'".trim($_POST["username"])."'";
      $sql .= " UNION SELECT username FROM admin WHERE username = ";
      $sql .= "'".trim($_POST["username"])."'";
      $sql .= " UNION SELECT username FROM patient WHERE username = ";
      $sql .= "'".trim($_POST["username"])."'";

      echo $sql;
      $result = $conn->query($sql);
      if($result){
        if($result->num_rows > 0){
          $username_err = "This username is already taken.";
        } else{
          $username = trim($_POST["username"]);
        }
      } else{
        $username_err = "Oops! Something went wrong!";
      }

    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }



    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err)){

        $sql = "INSERT INTO admin (username, password) VALUES ";
        $sql .= "('".$username;

        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= "','".$password."')";
        echo $sql;
        $result = $conn->query($sql);
        if($result){
          $success = "Success!";
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <span class="invalid-feedback"><?php echo $success; ?></span>
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
</body>
</html>
