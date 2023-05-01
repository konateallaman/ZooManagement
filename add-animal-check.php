<?php
ob_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $name = $_POST['name'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $weight = $_POST['weight'];
    $habitat_id = $_POST['habitat_id'];

   
    

   if (isset($_FILES['image'])) {
        // Get the uploaded image
        $image = $_FILES['image'];

        // Check if the image was uploaded successfully
        if ($image['error'] == UPLOAD_ERR_OK) {
            // Get the file extension
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            // Generate a unique filename
            $filename = uniqid() . '.' . $extension;

            // Move the uploaded image to the uploads directory
            move_uploaded_file($image['tmp_name'], './pictures/' . $filename);
        }
    }


$id = mt_rand(100000, 9999999);

// Connect to the database
    require_once "./connection/connect.inc.php";
    
$sql= "INSERT INTO animals (animal_id, name, species, age, gender, weight, habitat_id, picture) VALUES (?,?,?,?,?,?,?,?)";

    if (isset($conn)) {
        $stmt = $conn->prepare($sql);
    }
    $stmt->bind_param("ssssssss", $id,$name, $species, $age, $gender, $weight, $habitat_id,$filename);
    $result = $stmt->execute();

    // Check if the query was successful
    if ($result) {
        // Redirect back to the animal list page
        header('Location: manage-animals.php');
        exit;
    } else {
        // Display an error message
        //echo "Error adding record: " . mysqli_error($conn);
         echo '<br><br><div class="alert alert-danger" ><strong><h6 style="text-align: center;">Error adding record:</h6></strong></div>';
    }

// Close the database connection
mysqli_close($conn);

}
?>
