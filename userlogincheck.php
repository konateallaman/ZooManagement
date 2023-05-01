<?php
ob_start();
session_start();
require "./connection/connect.inc.php";


if (isset($_POST['login'])) {
    $Email = $_POST['CustEmail'];
    $Password = $_POST['password'];
    $LoginAs = $_POST['loginAs']; // Get the value of the loginAs field

    // Determine which table to search based on the login type
    if ($LoginAs == 'user') {
        $table = 'visitors';
        $redirectUrl = 'WelcomePage.php'; // Redirect to user welcome page
    } else if ($LoginAs == 'admin') {
        $table = 'admin';
       $redirectUrl = 'AdminMenu.php'; // Redirect to admin welcome page
    }

    // Get hashed password from database
    $query = "SELECT password FROM $table WHERE CustEmail='$Email'";
    if (isset($conn)) {
        $result = mysqli_query($conn, $query);
    }
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];

    // Compare hashed passwords
    if (password_verify($Password, $hashedPassword)) {
        // User is logged in
        
        $_SESSION['CustEmail'] = $Email; // Set session variable
       
        header("Location: $redirectUrl"); // Redirect to appropriate welcome page
        exit;
    } else {
        // Invalid login credentials
        echo '<br><br><div class="alert alert-danger" ><strong><h6 style="text-align: center;">Invalid login credentials. Please <a href="UserLogin.php"> try again</a></h6></strong></div>';
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

