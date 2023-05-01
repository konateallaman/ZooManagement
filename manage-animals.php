<?php
 ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Animals</title>
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
</head>
<body>
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

<div>
    
    
    
<div class="container">
    <h1 class="text-center">Manage Animals</h1>
    <a href="add-animal.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Animal</a>
    <br><br>
    <a href="animal_report.php" class="btn btn-primary"><i class="bi bi-plus-arrow"></i> see full report</a>
       <br><br>
    <form method="GET">
        <div class="row mb-3">
           

            <div class="col-md-6">
                <label for="gender-filter" class="form-label">Filter by Gender:</label>
                <select name="gender" id="gender-filter" class="form-select">
                    <option value="">All Genders</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
             <div class="col-md-6">
                <label for="species-filter" class="form-label">Filter by Species:</label>
                <select name="species" id="species-filter" class="form-select">
                    <option value="">All Species</option>
                    <option value="Mammals">Mammals</option>
                    <option value="Reptiles">Reptiles</option>
                    <option value="Fish">Fish</option>
                    <option value="Amphibian">Amphibian</option>
                    <option value="Insects">Insects</option>
                    
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Filter</button>
    </form>
    <br><br>
    <div class="table-responsive mx-auto">
        <table class="table table-striped table-hover">
            <thead>
            <tr class="thead-dark">
                <th>ID</th>
                <th>Name</th>
                <th>Species</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Weight</th>
                <th>Habitat</th>
               
                <th>added on</th>
                <th>Last update</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
           
            // Connect to the database
            require './connection/connect.inc.php';
       $where = "WHERE 1"; // Default filter
            
            if (isset($_GET['gender']) && !empty($_GET['gender'])) {
                $gender = $_GET['gender'];
                $where .= " AND animals.gender='$gender'";
            }
            if (isset($_GET['species']) && !empty($_GET['species'])) {
            $species = $_GET['species'];
            $where .= " AND animals.species='$species'";
        }
            $sql = "SELECT animals.animal_id, animals.name, animals.species, animals.age, animals.gender, animals.weight, habitats.name AS habitat_name, animals.date_created AS date_created, animals.date_updated AS date_updated FROM animals
                INNER JOIN habitats ON animals.habitat_id=habitats.habitat_id
                $where
                ORDER BY animals.animal_id ASC";
            $result = mysqli_query($conn, $sql);


        // Display the results in a table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['animal_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['species'] . "</td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['weight'] . "</td>";
            echo "<td>" . $row['habitat_name'] . "</td>";
           // echo "<td>" . $row['exhibit_name'] . "</td>";
            echo "<td>" . $row['date_created'] . "</td>";
            echo "<td>" . $row['date_updated'] . "</td>";
            echo "<td><a href='edit-animal.php?animal_id=" . $row['animal_id'] . "' class='btn btn-warning'><i class='bi bi-pencil'></i> Edit</a> | <a href='delete-animal.php?animal_id=" . $row['animal_id'] . "' onClick=\"return confirm('Are you sure you want to delete this animal?')\" class='btn btn-danger'><i class='bi bi-trash'></i> Delete</a></td>";

            echo "</tr>";
        }

        // Close the database connection
        mysqli_close($conn);
       // ob_end_flush();
        ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
