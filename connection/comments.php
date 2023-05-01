<?php
ob_start();

require_once "./connection/connect.inc.php";

// Retrieve the form data
$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['comment'];

// Insert the comment into the database
$sql = "INSERT INTO comments (name, email, comment_text, likes) VALUES ('$name', '$email', '$comment', 0)";
$result = mysqli_query($conn, $sql);

// Check if the insertion was successful
if ($result) {
    // Redirect back to the page
    header('Location: index.php');
    exit();
} else {
    // Display an error message
    echo 'Error: ' . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);







?>
