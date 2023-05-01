<?php
ob_start();
// start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <title>New Animal</title>
    <style>
        .form-group {
            background-color: lightgray;
            text-align: center;
        }
       body {
        min-height: 100vh;
    }
        
    </style>
</head>
<body >
<header>
    <div class="logo">
        <img src="./icons/safari.png" alt="Your logo">
    </div>
    <div class="username">
       
    </div>
</header>
<div class="navbar">
    <a href="AdminMenu.php"><i class="fa fa-home"></i> Home</a>


     <a href="user-logout-script.php" style="padding-left: 1px"><i class="bi bi-box-arrow-right"></i> Sign out</a>
</div>

<h1 style="text-align: center;">New animal</h1>



<div>
    <br>
   

</div> 

<form method="POST" action="" class="mx-auto" style="max-width: 500px;" enctype="multipart/form-data" >
    <div class="form-group">
    
    <?php
ob_start();
try {
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
         $message = "<p class='alert alert-success'>Animal added successfully.</p>";
        // Redirect back to the animal list page
       // header('Location: manage-animals.php');
       // exit;
    } else {
        // Display an error message
        //echo "Error adding record: " . mysqli_error($conn);
        $message = "<p class='alert alert-success'>Error adding record.</p>";
        // echo '<br><br><div class="alert alert-danger" ><strong><h6 style="text-align: center;">Error adding record:</h6></strong></div>';
    }

// Close the database connection
//mysqli_close($conn);

}
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Caught exception: " . $e->getMessage() . "</div>";
}

?>
</div>
<div class="container">
     <br><br>
    <a href="manage-animals.php" class="btn btn-primary"><i class="bi bi-plus-arrow"></i>Go to manage animals</a>
       <br><br>

   
    
    <?php
    echo $message;
    ?>
<br>
    <div class="form-group">
        <label for="name">Name:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
            </div>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </div>
    <div class="form-group">
        <label for="species">Species:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-paw"></i></span>
            </div>
            <input type="text" class="form-control" id="species" name="species">
        </div>
    </div>
    <div class="form-group">
        <label for="age">Age:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-clock"></i></span>
            </div>
            <input type="number" class="form-control" id="age" name="age">
        </div>
    </div>
    <div class="form-group">
        <label for="gender">Gender:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
            </div>
            <select class="form-control" id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="weight">Weight:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-weight"></i></span>
            </div>
            <input type="number" class="form-control" id="weight" name="weight" step="0.01">
        </div>
    </div>
    <div class="form-group">
        <label for="habitat_id">Habitat:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-tree-fill"></i></span>
            </div>
            <select class="form-control" id="habitat_id" name="habitat_id">
                <?php
                // Connect to the database
                require_once "./connection/connect.inc.php";

                // Get the list of habitats
                $query = "SELECT habitat_id, name FROM habitats";
                $result = mysqli_query($conn, $query);

                // Loop through the list of habitats and print each one as an option in the select list
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['habitat_id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <div class="input-group">
            <input type="file" class="form-control" id="image" name="image">
            <div class="input-group-append">
                <span class="input-group-text"><i class
="bi bi-camera"></i></span>
</div>
    </div>
    
 
</div>
<div>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>

</form>
</div>
</div>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);
ob_end_flush();
?>