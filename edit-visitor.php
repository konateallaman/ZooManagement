<?php
// start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <title>Manage New Tickets</title>
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Add Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <style>
    footer {
          position: relative;
          bottom: 0;
          width: 100%;
          background-color: #f5f5f5;
          padding: 10px;
          text-align: center;
        }
       
        /* Add custom styles for the buttons */
        .btn-admin {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
            transition: all 0.2s ease-in-out;
        }

        .btn-admin:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
         
        /* Define styles for smaller screens */
        @media only screen and (max-width: 768px) {
            .logo {
                display: none;
            }
            .username {
                font-size: 1rem;
            }
            .search-container {
                font-size: 0.8rem;
            }
        }
        html, body {
  height: 110%;
}

   
    </style>
</head>
<body>
   
<header>
    <div class="logo">
        <img src="./icons/safari.png" alt="Your logo">
    </div>
    <div class="username">
         <?php
        include "./connection/usersession.php";
        ?>
       
    </div>
</header>

<div class="navbar">
    <a href="AdminMenu.php"><i class="fa fa-home"></i> Home</a>


    <a href="user-logout-script.php" style="padding-left: 1px"><i class="bi bi-box-arrow-right"></i> Sign out</a>
</div>
<br>


<div class="container">
    
    <div class="col-md-4">
    <a href="manage-visitors.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Go Back
    </a>
</div>
    <br>
    <div class="row justify-content-center">
        <?php
        // connect to the database
    require './connection/connect.inc.php';
          // check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $CustID = $_POST['CustID'];
        $CustFname = $_POST['CustFname'];
        $CustLname = $_POST['CustLname'];
        $CustEmail = $_POST['CustEmail'];
        $CustDOB = $_POST['CustDOB'];
        $visit_date = $_POST['visit_date'];

        // check if password field is not empty
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
         $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
            // update the visitor details in the database
    $sql = "UPDATE visitors SET CustFname = '$CustFname', CustLname = '$CustLname', CustEmail = '$CustEmail', CustDOB = '$CustDOB', visit_date = '$visit_date'";
    
    // add password field update to query if password is set
    if(isset($password)) {
      $sql .= ", password = '$password'";
    }

    $sql .= " WHERE CustID = $CustID";

    if ($conn->query($sql) === TRUE) {
       echo "<p class='alert alert-success'>Visitor details updated successfully!</p>";
        //echo "Visitor details updated successfully!";
    } else {
       
        echo "Error updating visitor details: " . $conn->error;
    }
}
        ?>
    <div class="col-md-6">
        
        <h2>Edit Visitor</h2>
  <?php
    // connect to the database
    require './connection/connect.inc.php';

    // check if the visitor ID is set
    if (isset($_GET['CustID'])) {
        $CustID = $_GET['CustID'];

        // fetch the visitor details from the database
        $sql = "SELECT * FROM visitors WHERE CustID = $CustID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // display the visitor details in a form for editing
            echo "<form method='post'>";
            echo "<input type='hidden' name='CustID' value='" . $row['CustID'] . "'>";
            echo "<div class='form-group'>";
            echo "<label for='CustFname'>First Name:</label>";
            echo "<input type='text' class='form-control' id='CustFname' name='CustFname' value='" . $row['CustFname'] . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='CustLname'>Last Name:</label>";
            echo "<input type='text' class='form-control' id='CustLname' name='CustLname' value='" . $row['CustLname'] . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='CustEmail'>Email:</label>";
            echo "<input type='email' class='form-control' id='CustEmail' name='CustEmail' value='" . $row['CustEmail'] . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='password'>Password:</label>";
            echo "<input type='password' class='form-control' id='password' name='password'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='CustDOB'>Date of Birth:</label>";
            echo "<input type='date' class='form-control' id='CustDOB' name='CustDOB' value='" . $row['CustDOB'] . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='visit_date'>Visit Date:</label>";
            echo "<input type='date' class='form-control' id='visit_date' name='visit_date' value='" . $row['visit_date'] . "'>";
            echo "</div>";
            echo "<button type='submit' class='btn btn-primary'>Save</button>";
            echo "</form>";
        } else {
            echo "No visitor found with ID: $CustID";
        }
    }

  

// close the database connection
$conn->close();
?>

</div>
</div>
</div>





</div>
  <footer>
    <p>&copy; 2023 - All rights reserved</p>
  </footer>
  <!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>