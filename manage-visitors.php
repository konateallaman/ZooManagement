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
<?php
    
    // check if the user is logged in
   
    
    // connect to the database
    require './connection/connect.inc.php';
    
    // add new visitor
    if(isset($_POST['add_visitor'])) {
        // get the form data
       // $CustID = $_POST['CustID'];
        $CustFname = $_POST['CustFname'];
        $CustLname = $_POST['CustLname'];
        $CustEmail = $_POST['CustEmail'];
        $password = $_POST['password'];
        $CustDOB = $_POST['CustDOB'];
        $visit_date = $_POST['visit_date'];
        $date_created = date('Y-m-d H:i:s');
        $id = random_int(1, 9999);
        
        // prepare the SQL query to insert new visitor
        $sql = "INSERT INTO visitors (CustID, CustFname, CustLname, CustEmail, password, CustDOB, visit_date, date_created) VALUES ('$id', '$CustFname', '$CustLname', '$CustEmail', '$password', '$CustDOB', '$visit_date', '$date_created')";
        
        // execute the query
        $result = $conn->query($sql);
        
        // check if the query was successful
        if($result) {
            // redirect to the page with all visitors
           $message = "<p class='alert alert-success'>Visitor added successfully.</p>";
        } else {
            // display an error message
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    //print all 
    if(isset($_POST['print_all'])) {
         $sql = "SELECT * FROM visitors";
        // execute the query
        $result = $conn->query($sql);
        
        
    }
    
    // delete visitor
    if(isset($_GET['delete_visitor'])) {
        // get the CustID'
        
        $CustID  = $_GET['delete_visitor'];
        
        // prepare the SQL query to delete visitor
        $sql = "DELETE FROM visitors WHERE CustID = $CustID";
        
        // execute the query
        $result = $conn->query($sql);
        
        // check if the query was successful
        if($result) {
            // redirect to the page with all visitors
            $message = "<p class='alert alert-danger'>Visitor deleted successfully.</p>";
        } else {
            // display an error message
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    
    // edit visitor
    if(isset($_POST['edit_visitor'])) {
        // get the form data
        $CustID = $_POST['CustID'];
        $CustFname = $_POST['CustFname'];
        $CustLname = $_POST['CustLname'];
        $CustEmail = $_POST['CustEmail'];
        $password = $_POST['password'];
        $CustDOB = $_POST['CustDOB'];
        $visit_date = $_POST['visit_date'];
        
        // prepare the SQL query to update visitor
        $sql = "UPDATE visitors SET  CustFname = '$CustFname', CustLname = '$CustLname', CustEmail = '$CustEmail', password = '$password', CustDOB = '$CustDOB', visit_date = '$visit_date' WHERE CustID = $CustID";
        
        // execute the query
        $result = $conn->query($sql);
        
        // check if the query was successful
       
if($result) {
// redirect to the page with all visitors
header("Location: manage-visitors.php");
exit();
} else {
// display an error message
echo "Error: " . $sql . "<br>" . $conn->error;
}
}
// retrieve all visitors from the database
$sql = "SELECT * FROM visitors";

// retrieve visitors from the database
    if (isset($_POST['search'])) {
        // get the search term
        $search_term = $_POST['search_term'];
        
        // prepare the SQL query to search for visitors
        $sql = "SELECT * FROM visitors WHERE CustFname LIKE '%$search_term%' OR CustLname LIKE '%$search_term%' OR CustEmail LIKE '%$search_term%'";
    } else {
        // prepare the SQL query to retrieve all visitors
        $sql = "SELECT * FROM visitors";
    }

//execute the query
$result = $conn->query($sql);

   
    
   // $result = $conn->query($sql);
    
//$conn->close();
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <br>
            <?php if (!empty($message)) { ?>
              <div ><?php echo $message; ?></div>
            <?php } ?>
            <br>
    <h2 class="my-4">Add New Visitor</h2>
<form method="POST" action="">
   
    <div class="form-group">
        <label for="CustFname">First Name:</label>
        <input type="text" id="CustFname" name="CustFname" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="CustLname">Last Name:</label>
        <input type="text" id="CustLname" name="CustLname" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="CustEmail">Email:</label>
        <input type="email" id="CustEmail" name="CustEmail" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="CustDOB">Date of Birth:</label>
        <input type="date" id="CustDOB" name="CustDOB" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="visit_date">Visit Date:</label>
        <input type="date" id="visit_date" name="visit_date" class="form-control" required>
    </div>
    <button type="submit" name="add_visitor" class="btn btn-primary">Add Visitor</button>
</form>
</div>
        <div class="col-md-6">
            <h2 class="my-4">Search Visitors</h2>
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by name or email" name="search_term">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="search"><i class="bi bi-search"> </i>Search</button>
                    </div>
                </div>
            </form>
            <h1>OR</h1>
            <form method="post" action="">
    <div class="form-group">
        <button type="submit" name="print_all" class="btn btn-primary">All Visitors</button>
    </div>
    <div class="form-group">
     <br><br>
    <a href="visitors_report.php" class="btn btn-primary"><i class="bi bi-plus-arrow"></i>More reports</a>
       <br><br>
       </div>
</form>

        </div>
    </div>


</form>

<h1 class="mb-4">Registered Visitors</h1>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Visitor ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Visit Date</th>
                <th>Date Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            ob_start();
                // loop through all visitors
                 if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['CustID']."</td>";
                        echo "<td>".$row['CustFname']."</td>";
                        echo "<td>".$row['CustLname']."</td>";
                        echo "<td>".$row['CustEmail']."</td>";
                        echo "<td>".$row['CustDOB']."</td>";
                        echo "<td>".$row['visit_date']."</td>";
                        echo "<td>".$row['date_created']."</td>";
                        echo "<td>";
                        echo "<a href='edit-visitor.php?CustID=".$row['CustID']."' class='btn btn-primary btn-sm mr-2'>Edit</a>";
                        echo "<a href='manage-visitors.php?delete_visitor=".$row['CustID']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this visitor?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                        // free up memory
                    
                    }
                 } else {
                echo "<tr><td colspan='6'>No visitors found.</td></tr>";
            }
            $conn->close();
            ob_end_flush();
            ?>
        </tbody>
    </table>
</div>




   
</div>





<div class="container-fluid">

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
