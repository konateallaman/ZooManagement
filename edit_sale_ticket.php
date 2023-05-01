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
    <style>
    footer {
          position: relative;
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


    <a href="user-logout-script.php" style="padding-left: 1px"><i class="fa fa-user-minus"></i> Sign out</a>
</div>
    <?php
    ob_start();
    // check if user is logged in
    if (!isset($_SESSION['CustEmail'])) {
        header("Location: UserLogin.php"); // redirect to login page if user is not logged in
    }
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    
    
    // Connect to the database
    require './connection/connect.inc.php';



// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the animal ID from the URL parameter
    $ticket_id = filter_input(INPUT_GET, 'ticket_id', FILTER_SANITIZE_NUMBER_INT);

    // Get the updated information from the form
    $ticket_type = mysqli_real_escape_string($conn, $_POST['ticket_type']);
    $ticket_price = mysqli_real_escape_string($conn, $_POST['ticket_price']);
     $event = mysqli_real_escape_string($conn, $_POST['event']);
     $available_tickets = mysqli_real_escape_string($conn, $_POST['available_tickets']);
     
     
     

    // Update the ticket's information in the database
    $sql = "UPDATE sale_tickets SET ticket_type='$ticket_type', ticket_price='$ticket_price', event='$event',available_tickets='$available_tickets' WHERE ticket_id='$ticket_id'";
    $result = mysqli_query($conn, $sql);
    // Redirect the user back to tickets list page
    header('Location: New_Tickets.php');
    exit;
} else {
    // Retrieve the animal ID from the URL parameter
    $ticket_id = filter_input(INPUT_GET, 'ticket_id', FILTER_SANITIZE_NUMBER_INT);

    // Query the database for the animal information
    $sql = "SELECT * FROM sale_tickets WHERE ticket_id='$ticket_id'";
    $result = mysqli_query($conn, $sql);

    // Check if the ticket was found in the database
    if (mysqli_num_rows($result) == 0) {
        // ticket not found, redirect the user back to the ticket list page
        header('Location: New_Tickets.php');
        exit;
    }

    // Retrieve the ticket information from the database
    $row = mysqli_fetch_assoc($result);

}

ob_end_flush();
?>
<!-- Display the ticket edit form -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2> Edit Ticket</h2>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?ticket_id=' . $ticket_id); ?>">
        <div class="form-group">
          <label for="ticket_type">Ticket Type:</label>
          <select class="form-control" id="ticket_type" name="ticket_type">
            <option value="VIP"<?php if ($row['ticket_type'] == 'VIP') echo ' selected'; ?>>VIP</option>
            <option value="STANDARD"<?php if ($row['ticket_type'] == 'STANDARD') echo ' selected'; ?>>Standard</option>
          </select>
        </div>
       
        <div class="form-group">
          <label for="ticket_price">Ticket Price:</label>
          <input type="text" class="form-control" id="ticket_price" name="ticket_price" value="<?php echo $row['ticket_price']; ?>">
        </div>
        <div class="form-group">
  <label for="ticket_type">Event:</label>
  <select class="form-control" id="event" name="event">
    <option value="" >--select an option--</option>
    <?php
    // Connect to the database
require './connection/connect.inc.php';
// Retrieve exhibit locations from the exhibits table
$sql = "SELECT exhibit_id, name FROM exhibits";
$result = $conn->query($sql);

// Loop through each exhibit location and add it to the dropdown menu
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo '<option value="' . $row["exhibit_id"] . '">' . $row["name"] . '</option>';
  }
}
?>
  </select>
  
  
</div>
 <div class="form-group">
        <label for="ticket_price">Number Of tickets:</label>
        <input type="number" class="form-control" id="available_tickets" name="available_tickets" value="<?php if(!empty($ticket)) {echo $ticket['available_tickets'];}?>">
         </div>
        <button type="submit" class="btn btn-primary" value="Submit">Update</button>
      </form>
    </div>
  </div>
</div>

<div><br></div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                   <p>&copy; <?php echo date('Y'); ?> Your Company. All rights reserved.</p>
            </div>
            
            
        </div>
    </div>
</footer>

<!-- Add jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Add Bootstrap JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>