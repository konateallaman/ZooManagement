
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
    
   
<?php
// Connect to the database
require './connection/connect.inc.php';
// retrieve staff data to prepopulate the form
if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];
    $sql = "SELECT * FROM staff WHERE staff_id=$staff_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $job_title = $row['job_title'];
        $contact_info = $row['contact_info'];
        $role_id = $row['role_id'];
    } else {
        echo "<div class='alert alert-danger' role='alert'>Staff not found. Please try again.</div>";
        exit();
    }
}

// handle update staff form submission
if (isset($_POST['update_staff'])) {
    $staff_id = $_POST['staff_id'];
    $name = $_POST['name'];
    $job_title = $_POST['job_title'];
    $contact_info = $_POST['contact_info'];
    $role_id = $_POST['role_id'];
    $sql = "UPDATE staff SET name='$name', job_title='$job_title', contact_info='$contact_info', role_id='$role_id' WHERE staff_id=$staff_id";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>Staff updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Failed to update staff. Please try again.</div>";
    }
}
?>
<br>
<a href='assign_role.php' class='btn btn-warning btn-sm'><i class="bi bi-arrow-left"></i> Go Back</a> 
<br>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" action="">
                <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="job_title">Job Title:</label>
                    <input type="text" class="form-control" id="job_title" name="job_title" value="<?php echo $job_title; ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact_info">Contact Info:</label>
                    <input type="text" class="form-control" id="contact_info" name="contact_info" value="<?php echo $contact_info; ?>" required>
                </div>
                <div class="form-group">
                    <label for="role_id">Role:</label>
                    <select class="form-control" id="role_id" name="role_id">
                        <?php
                        // retrieve staff role data from database
                        $sql = "SELECT * FROM staff_roles";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($row['role_id'] == $role_id) ? 'selected' : '';
                                echo "<option value='" . $row['role_id'] . "' $selected>" . $row['role'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <br>
                <br>
                <button type="submit" class="btn btn-primary" name="update_staff">Save</button> 
            </form>
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