<?php
ob_start();
// Connect to the database
require './connection/connect.inc.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the animal ID from the URL parameter
    $animal_id = $_GET['animal_id'];

    // Get the updated information from the form
    $name = $_POST['name'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $weight = $_POST['weight'];
    $habitat_id = $_POST['habitat_id'];
   // $exhibit_id = $_POST['exhibit_id'];

    // Update the animal's information in the database
    $sql = "UPDATE animals SET name='$name', species='$species', age=$age, gender='$gender', weight=$weight, habitat_id=$habitat_id WHERE animal_id=$animal_id";
    $result = mysqli_query($conn, $sql);

    // Update the exhibit's information in the database
  //  $sql = "UPDATE exhibits SET exhibit_id=$exhibit_id WHERE animal_id=$animal_id";
  //  $result = mysqli_query($conn, $sql);

    // Redirect the user back to the animal list page
    header('Location: manage-animals.php');
    exit;
} else {
    // Retrieve the animal ID from the URL parameter
    $animal_id = $_GET['animal_id'];

    // Query the database for the animal information
    $sql = "SELECT animals.*, habitats.habitat_id, habitats.name AS habitat_name FROM animals
            INNER JOIN habitats ON animals.habitat_id=habitats.habitat_id
            WHERE animals.animal_id=$animal_id";
    $result = mysqli_query($conn, $sql);

    // Check if the animal was found in the database
    if (mysqli_num_rows($result) == 0) {
        // Animal not found, redirect the user back to the animal list page
        header('Location: manage-animals.php');
        exit;
    }

    // Retrieve the animal information from the database
    $row = mysqli_fetch_assoc($result);

    // Query the database for all habitats
    $sql = "SELECT * FROM habitats ORDER BY name ASC";
    $habitat_result = mysqli_query($conn, $sql);

    // Query the database for all exhibits
   // $sql = "SELECT * FROM exhibits ORDER BY name ASC";
   // $exhibit_result = mysqli_query($conn, $sql);
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Animal </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" integrity="sha512-hoU6/xSPUftzWU8VvU9Xq3V7Ndfx6Wwbu7Kv+e/wwf6Uu93kWgVvyzvQ9Mbi+1D04Q2w29K8mB0kfHNy0dCqw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>edit animal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-5">Edit Animal</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
            </div>
            <div class="mb-3">
                <label for="species" class="form-label">Species</label>
                <input type="text" class="form-control" id="species" name="species" value="<?php echo $row['species']; ?>">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="<?php echo $row['age']; ?>">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="male" <?php if ($row['gender'] == 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($row['gender'] == 'female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="number" class="form-control" id="weight" name="weight" value="<?php echo $row['weight']; ?>">
            </div>
            <div class="mb-3">
                <label for="habitat_id" class="form-label">Habitat</label>
                <select class="form-select" id="habitat_id" name="habitat_id">
                    <?php while ($habitat_row = mysqli_fetch_assoc($habitat_result)) { ?>
                        <option value="<?php echo $habitat_row['habitat_id']; ?>" <?php if ($row['habitat_id'] == $habitat_row['habitat_id']) echo 'selected'; ?>><?php echo $habitat_row['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
           
<input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form>
</div>
<!-- Bootstrap JS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha512-rn+6VOfGY6fI1/ZW8GwqCc0c/TB0gkTkcn6W8nkHi0B+eqg4+czz4EZ4xWpHJdO75zVg5BGbS5xtV8E2QWyJgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>
</html>