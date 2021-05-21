<html>
<link rel="stylesheet" href="style.css">
<body>
<!-- COVID Vaccine Patient Form -->
<ul>
  <li><a href="admin.php">Home</a></li>
  <li><a class="active" href="NurseForm.php">Add Nurse</a></li>
  <li><a href="NurseUpdate.php">View/Update Nurse Info</a></li>
  <li><a href="adminpatient.php">View/Update Patient Info</a></li>
  <li><a href="vaccine.php">Update Vaccine Info</a></li>
  <li><a href="TimeSlot.php">Add Time Slot</a></li>
  <li><a href="AdminForm.php">Add New Admin</a></li>
  <li><a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a></li>
</ul>
<div class="wrapper">


<h2 class="navmargin">Add a new Nurse</h2>
<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["access"] !== 3){
    header("location: index.php");
    exit;
}
  require_once "config.php";
    if($conn->connect_error)
    {
        echo "Error: could not connect to the DB";
        exit;
    }
    $username = $password = $success = "";
    $username_err = $password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } else{
          $sql = "SELECT username FROM nurse WHERE username = ";
          $sql .= "'".trim($_POST["username"])."'";
          $sql .= " UNION SELECT username FROM admin WHERE username = ";
          $sql .= "'".trim($_POST["username"])."'";
          $sql .= " UNION SELECT username FROM patient WHERE username = ";
          $sql .= "'".trim($_POST["username"])."'";

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
            $myQ="INSERT INTO NURSE(FNAME,MI,LNAME,AGE,PHONE,GENDER,ADDRESS, USERNAME, PASSWORD) VALUES";

            $myQ .= "('".$_POST["fname"]."','";
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

            $myQ .= $_POST["address"]."','";
            $myQ .= $username."','";
            $myQ .= $password."')";

            ;
            $result = $conn->query($myQ);
            if($result){
              $success = "Success!";
            }
        }


        // echo "Query to execute: " . $myQ . "<br>";
        // if($conn->query($myQ)) echo "The new patient added successfully!";
        // else echo "Error: " . $conn->error;
    }

    // Step 3: Terminate Connection
    $conn->close();
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="form-group">
    First Name: <input type="text" name="fname">
    MI: <input type="text" name="mi">
    Last Name: <input type="text" name="lname"> <br>
  </div>
  <div class="form-group">
    Age: <input type="text" name="age"> <br>
  </div>
  <div class="form-group">
    Phone Number: <input type="text" name="phone"> <br>
  </div>
  <div class="form-group">
    Gender:
        <select name="sex">
            <option value="F">Female</option>
            <option value="M">Male</option>
            <option value="O">Others</option>
        </select><br>
      </div>
      <div class="form-group">
    Address: <input type="text" name="address"> <br>
  </div>
    <br>

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
        <input class="button" id="submit" type="submit" class="btn btn-primary" value="Submit">
        <span class="invalid-feedback"><?php echo $success; ?></span>
    </div>
</form>
</div>
</body>
</html>
