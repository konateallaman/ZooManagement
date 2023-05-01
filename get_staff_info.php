<?php
// Establish a connection to the database
require_once "./connection/connect.inc.php";

// Check if the staff ID was submitted
if (isset($_POST['staff_id'])) {

    // Get the staff ID from the POST data
    $staff_id = $_POST['staff_id'];

    // Query the database to get the staff info
    $sql = "SELECT * FROM staff WHERE staff_id = '$staff_id'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if a staff member was found with the given ID
    if (mysqli_num_rows($result) > 0) {

        // Fetch the staff info from the database
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $job_title = $row['job_title'];
        $contact_info = $row['contact_info'];
        $role_id = $row['role_id'];

        // Return the staff info as a JSON object
        $staff_info = array(
            'name' => $name,
            'job_title' => $job_title,
            'contact_info' => $contact_info,
            'role_id' => $role_id
        );
        echo json_encode($staff_info);

    } else {
        echo "Staff member not found.";
    }

} else {
    echo "No staff ID submitted.";
}

// Close the database connection
mysqli_close($conn);
?>
