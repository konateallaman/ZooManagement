<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_start();
require "./connection/connect.inc.php";


if (isset($_POST['Visitor_registration'])) {
    require_once "./connection/connect.inc.php"; // Use either mysqli or PDO consistently
    $Fname = $_POST['CustFname'];
    $Lname = $_POST['CustLname'];
    $Email = $_POST['CustEmail'];
    $Password = $_POST['password'];
    $DOB = $_POST['CustDOB'];
    $Vdate = $_POST['visit_date'];
    // Generate unique ID
    $id = mt_rand(100000, 999999); // generate a random number between 100000 and 999999

    // Validate user input
    if (empty($Fname) || empty($Lname) || empty($Email) || empty($Password) || empty($DOB) || empty($Vdate)) {
        echo '<div style="background-color:white;"><h4 style="color:red;">Please, fill up all the fields !</h4></div>';
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo '<div style="background-color:white;"><h4 style="color:red;">Please enter a valid email address.</h4></div>';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $DOB)) {
        echo '<div style="background-color:white;"><h4 style="color:red;">Please enter a date in the format YYYY-MM-DD.</h4></div>';
    } elseif (strlen($Password) < 8) {
        echo '<div style="background-color:white;"><h4 style="color:red;">Password must be at least 8 characters long.</h4></div>';
    } else {
        // Hash the password
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    try {
        // Use prepared statements with parameterized queries to prevent SQL injection
        $sql = "INSERT INTO visitors (CustID,CustFname,CustLname,CustEmail,password,CustDOB,visit_date) VALUES(?,?,?,?,?,?,?)";
        if (isset($conn)) {
            $stmt = $conn->prepare($sql);
        }
        $stmt->bind_param("sssssss", $id, $Fname, $Lname, $Email, $hashedPassword, $DOB, $Vdate);
        $result = $stmt->execute();
        if ($result) {
            echo '<div style="background-color:white;"><h4 style="color:greenyellow;">Registered Successfully</h4></div>';
        } 
        //else {
           // echo '<div style="background-color:white;"><h4 style="color:red;">Something Went Wrong</h4></div>';
           // echo '<div style="background-color:white;"><h4 style="color:red;">Error: ' . $stmt->error . '</h4></div>';

        //}
    } catch (mysqli_sql_exception $e) {
    echo '<div style="background-color:white;"><h4 style="color:red;">' . $e->getMessage() . '</h4></div>';

        
    }
     $stmt->close();
    $conn->close();
    }
   
}


?>

