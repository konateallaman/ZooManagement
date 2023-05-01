<?php
ob_start();
require_once "./connection/connect.inc.php"; // Use either mysqli or PDO consistently
// Start the session
session_start();

// Check if user is logged in
//if (!isset($_SESSION['username'])) {
//    header('Location: login.php');
//    exit();
//}


// Check if the animal_id parameter is set
if (isset($_GET['animal_id'])) {
    // Sanitize the animal_id parameter
    $animal_id = mysqli_real_escape_string($conn, $_GET['animal_id']);

    // Query the database for the animal to be deleted
    $sql = "SELECT * FROM animals WHERE animal_id = $animal_id";
    $result = mysqli_query($conn, $sql);

    // Check if the animal exists
    if (mysqli_num_rows($result) > 0) {
        // Delete the animal
        $sql = "DELETE FROM animals WHERE animal_id = $animal_id";
        mysqli_query($conn, $sql);

        // Check if the animal was successfully deleted
        if (mysqli_affected_rows($conn) > 0) {
           header('Location: manage-animals.php');
            exit();
        } else {
            echo "Error deleting animal";
        }
    } else {
        echo "Animal not found";
    }
} else {
    echo "Invalid request";
}
$conn->close();
ob_end_flush();
?>

