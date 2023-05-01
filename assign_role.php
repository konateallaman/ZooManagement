<?php
ob_start();
// start the session
        session_start();
?>
<!DOCTYPE html>
<html>
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
   <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Add Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!-- Modal JavaScript -->
<script>
    $(document).ready(function () {
        $('#addStaffModal').on('shown.bs.modal', function () {
            $('#name').focus();
        });
    });
</script>

    <style>
    footer {
          position: fixed;
          bottom: 0;
          width: 100%;
          background-color: #f5f5f5;
          padding: 20px;
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
   <style>
    .modal-backdrop {
        background-color: #000;
        opacity: 0.5;
    }
</style>
    </style>
	<title>Staff Management</title>
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


    <a href="user-logout-script.php" style="padding-left: 1px"><i class="fa fa-user-minus"></i> Sign out</a>
</div>

<div class="container mt-4">
    	<h1>Staff Management</h1>
<?php
 // Connect to the database
    require './connection/connect.inc.php';

	// handle add staff form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = $_POST['name'];
		$job_title = $_POST['job_title'];
		$contact_info = $_POST['contact_info'];
		$role_id = $_POST['role_id'];
		 $id = random_int(1, 9999);
		$sql = "INSERT INTO staff (staff_id,name, job_title, contact_info, role_id) VALUES ($id,'$name', '$job_title', '$contact_info', '$role_id')";
		if (mysqli_query($conn, $sql)) {
			echo "<div class='alert alert-success' role='alert'>Staff added successfully!</div>";
} else {
echo "<div class='alert alert-danger' role='alert'>Failed to add staff. Please try again.</div>";
}
	}

// handle delete staff request
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM staff WHERE staff_id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<div class='alert alert-success' role='alert'>Staff deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Failed to delete staff. Please try again.</div>";
    }
}
?>
<div class="row justify-content-between">
    <h2 class="col-sm-12 col-md-12 col-lg-8">Staff List</h2>
    <div class="col-sm-12 col-md-12 col-lg-4">
        <button type="button" class="btn btn-admin float-right" data-toggle="modal"
                data-target="#addStaffModal"><i class="fa fa-plus-circle"></i> Add Staff
        </button>
    </div>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Job Title</th>
            <th>Contact Info</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // retrieve staff data from database
        $sql = "SELECT staff.staff_id, staff.name, staff.job_title, staff.contact_info, staff_roles.role FROM staff JOIN staff_roles ON staff_roles.role_id=staff.role_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['staff_id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['job_title'] . "</td>
                        <td>" . $row['contact_info'] . "</td>
                        <td>" . $row['role'] . "</td>
                        <td><a href='edit_staff.php?staff_id=" . $row['staff_id'] . "' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i> Edit</a> 
                            <a href='?delete_id=" . $row['staff_id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this staff?');\"><i class='fa fa-trash'></i> Delete</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No staff found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</div>
<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form method="post" action="">
                     <div class="form-group">
                         <label for="name">Name:</label>
                         <input type="text" class="form-control" id="name" name="name" required>
                     </div>
                     <div class="form-group">
                         <label for="job_title">Job Title:</label>
                         <input type="text" class="form-control" id="job_title" name="job_title" required>
                     </div>
                     <div class="form-group">
                         <label for="contact_info">Contact Info:</label>
                         <input type="text" class="form-control" id="contact_info" name="contact_info" required>
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
                                     echo "<option value='" . $row['role_id'] . "'>" . $row['role'] . "</option>";
                                 }
                             }
                             ?>
                         </select>
                     </div>
                     <button type="submit" class="

btn btn-primary">Add Staff</button>
</form>
</div>
</div>
</div>

 </div>
<!-- Delete Staff Modal -->
<div class="modal fade" id="deleteStaffModal" tabindex="-1" role="dialog" aria-labelledby="deleteStaffModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStaffModalLabel">Delete Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <p>Are you sure you want to delete this staff member?</p>
                    <input type="hidden" name="delete_id" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete_staff">Delete Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-9iKj
aOZjlE7V8R/l+uFcN1OaLvz5ow5W5Yv+W5"
crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>
</html>
<?php
// close the database connection
mysqli_close($conn);
// flush the output buffer and turn off output buffering
ob_end_flush();
?>