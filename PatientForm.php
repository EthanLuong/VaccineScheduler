<html>
<body>
<!-- COVID Vaccine Patient Form -->
<h1>Register New Account</h1>
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
    $username = $password = $success = "";
    $username_err = $password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } else {
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
            $password = password_hash($password, PASSWORD_DEFAULT);
            $myQ="INSERT INTO PATIENT(SSN,FNAME,MI,LNAME,AGE,PHONE,GENDER,RACE,OCCUPATION,ADDRESS,HISTORY, USERNAME, PASSWORD) VALUES";
            $myQ .= "('".$_POST["ssn"]."','";
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
            $myQ .= $_POST["race"]."','";
            $myQ .= $_POST["occupation"]."','";
            $myQ .= $_POST["address"]."','";
            $myQ .= $_POST["history"]."','";
            $myQ .= $username."','";


            $myQ .= $password."')";
            ;
            $result = $conn->query($myQ);
            if($result){
              $success = "Success!";
            }
        }

        // Close connection


    }
    $conn->close();
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            <option value="W">Caucasian</option>
        </select><br>
    Occupation: <input type="text" name="occupation"> <br>
    Address: <input type="text" name="address"> <br>
    Medical History: <input type="text" name="history"> <br>
  <h2>Sign Up</h2>
  <p>Please fill this form to create an account.</p>
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
      <p>Already have an account? <a href="index.php">Login here</a>.</p>
</form>

</body>
</html>
