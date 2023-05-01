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
//include './connection/addticket.php';
//ob_start();
require './connection/connect.inc.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $ticket_type = $_POST['ticket_type'];
  $ticket_price = $_POST['ticket_price'];
  $event = $_POST['event'];
  $available_tickets = $_POST['available_tickets'];
  $id = random_int(1, 9999);

  // perform validation
  if (empty($ticket_type) || empty($ticket_price) || empty($event)) {
    $message = "<p class='alert alert-warning'>Please fill in all fields.</p>";
  } else {
    // check if record already exists
    $sql = "SELECT * FROM sale_tickets WHERE ticket_type = ? AND ticket_price = ? AND event = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $ticket_type, $ticket_price, $event);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      // update existing record
      $row = $result->fetch_assoc();
      $id = $row['ticket_id'];
      $available_tickets += $row['available_tickets'];
      $sql = "UPDATE sale_tickets SET available_tickets = ? WHERE ticket_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ii", $available_tickets, $id);
      $result = $stmt->execute();
      if ($result === TRUE) {
        $message = "<p class='alert alert-success'>Ticket updated successfully.</p>";
      }
    } else {
      // perform database insert
      $sql = "INSERT INTO sale_tickets (ticket_id, ticket_type, ticket_price, event, available_tickets) VALUES (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("isdsi", $id, $ticket_type, $ticket_price, $event, $available_tickets);
      $result = $stmt->execute();
      if ($result === TRUE) {
        $message = "<p class='alert alert-success'>Ticket added successfully.</p>";
      }
    }
  }
}



// Handle deleting or editing an existing ticket


// delete ticket
if(isset($_GET['delete_ticket'])) {
    // get the ticket_id
    $ticket_id = intval($_GET['delete_ticket']);

    // prepare the SQL query to delete ticket
    $stmt = $conn->prepare("DELETE FROM sale_tickets WHERE ticket_id = ?");
    $stmt->bind_param("i", $ticket_id);

    // execute the query
    $result = $stmt->execute();

    // check if the query was successful
    if ($result) {
        $message = "<p class='alert alert-danger'>Ticket deleted successfully.</p>";
    } else {
        $message = "<p class='alert alert-warning'>Failed to delete ticket.</p>";
    }
}




// Close the database connection
//$conn->close();
//ob_end_flush();

?>

<div class="container">
    <h1>Add New Tickets</h1>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($message)) { ?>
              <div ><?php echo $message; ?></div>
            <?php } ?>
            <form method="POST">
             
<div class="form-group">
  <label for="ticket_type">Ticket Type:</label>
  <select class="form-control" id="ticket_type" name="ticket_type">
    <option value="">--select an option--</option>
    <option value="VIP" <?php if(!empty($ticket) && $ticket['ticket_type'] == 'VIP') {echo 'selected';}?>>VIP</option>
    <option value="Standard" <?php if(!empty($ticket) && $ticket['ticket_type'] == 'Standard') {echo 'selected';}?>>Standard</option>
  </select>
</div>

<div class="form-group">
<label for="ticket_price">Ticket Price:</label>
<input type="number" class="form-control" id="ticket_price" name="ticket_price" value="<?php if(!empty($ticket)) {echo $ticket['ticket_price'];}?>">
</div>

<div class="form-group">
  <label for="event">Event:</label>
  <select class="form-control" id="event" name="event">
    <option value="">--select an option--</option>
    <?php
    // Connect to the database
//require './connection/connect.inc.php';
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



<?php if (!empty($ticket)) { ?>
<input type="hidden" name="action" value="edit">
<button type="submit" class="btn btn-primary">Update Ticket</button>
<?php } else { ?>
<input type="hidden" name="action" value="add">
<button type="submit" class="btn btn-primary">Add Ticket</button>
<?php } ?>
</form>
</div>
<div class="col-md-6">

<h2>...Search Here...</h2>
<form method="GET">
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="filter" id="filter_all" value="all" checked>
        <label class="form-check-label" for="filter_all">All Tickets</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="filter" id="filter_ticket_price" value="ticket_price">
        <label class="form-check-label" for="filter_ticket_price">By Ticket Price</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="filter" id="filter_ticket_id" value="ticket_id">
        <label class="form-check-label" for="filter_ticket_id">By Ticket ID</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="filter" id="filter_event" value="event">
        <label class="form-check-label" for="filter_event">By event</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="filter" id="filter_ticket_type" value="ticket_type">
        <label class="form-check-label" for="filter_ticket_type">By Ticket Type</label>
    </div>
    <div class="form-group">
        <label for="filter_value">Filter Value:</label>
        <input type="text" class="form-control" id="filter_value" name="filter_value">
    </div>
    <div class
="form-group">
<label for="price_range">By Price Range:</label>
<select class="form-control" id="price_range" name="price_range">
<option value="">Select a price range</option>
<option value="0-50">0-50</option>
<option value="50-100">50-100</option>
<option value="100-150">100-150</option>
<option value="150-200">150-200</option>
<option value="200+">200+</option>
</select>
</div>
<button type="submit" class="btn btn-primary">Filter</button>
<br>

</form>
<h2>Current Tickets</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Ticket Type</th>
                <th>Ticket Price</th>
                 <th>Event</th>
                  <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
         
            
           
          
           <?php
           
           // ob_start();
            require './connection/connect.inc.php';
            // Retrieve the total number of available tickets
            $sql = "SELECT SUM(available_tickets) as total_tickets FROM sale_tickets";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_tickets = $row['total_tickets'];
            
            // Retrieve all tickets from database
            $sql = "SELECT sale_tickets.ticket_id, sale_tickets.ticket_type, sale_tickets.ticket_price, exhibits.name, sale_tickets.available_tickets
                FROM sale_tickets
                LEFT JOIN exhibits ON sale_tickets.event = exhibits.exhibit_id
                ";
            // Check if any filter value is submitted
            if(isset($_GET['filter_value']) && !empty($_GET['filter_value'])) {
                $filter = $_GET['filter'];
                $filter_value = $_GET['filter_value'];
                // Add WHERE clause based on filter conditions
                if ($filter === 'ticket_price') {
                    $sql .= " WHERE ticket_price LIKE '%$filter_value%'";
                } else if ($filter === 'ticket_id') {
                    $sql .= " WHERE ticket_id LIKE '%$filter_value%'";
                } else if ($filter === 'ticket_type') {
                    $sql .= " WHERE ticket_type LIKE '%$filter_value%'";
                } else if($filter === 'event') {
                    $sql .= " WHERE name LIKE '%$filter_value%'";
                }
            } else if(isset($_GET['price_range']) && !empty($_GET['price_range'])) {
                $price_range = $_GET['price_range'];
                // Add WHERE clause based on price range selected
                if ($price_range === '0-50') {
                    $sql .= " WHERE ticket_price >= 0 AND ticket_price <= 50";
                } else if ($price_range === '50-100') {
                    $sql .= " WHERE ticket_price >= 50 AND ticket_price <= 100";
                } else if ($price_range === '100-150') {
                    $sql .= " WHERE ticket_price >= 100 AND ticket_price <= 150";
                } else if ($price_range === '150-200') {
                    $sql .= " WHERE ticket_price >= 150 AND ticket_price <= 200";
                } else if ($price_range === '200+') {
                    $sql .= " WHERE ticket_price >= 200";
                }
            }
            $result = $conn->query($sql);
            $num_rows = $result->num_rows; // Get the number of rows returned
            if ($num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ticket_id'] . "</td>";
                    echo "<td>" . $row["ticket_type"] . "</td>";
                    echo "<td>" . $row["ticket_price"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                     echo "<td>" . $row["available_tickets"] . "</td>";
                     $total_filtered_tickets += $row['available_tickets'];
                    echo "<td>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='ticket_id' value='" . $row["ticket_id"] . "'>";
                    
                    
                   
                    echo "<a href='New_Tickets.php?delete_ticket=".$row["ticket_id"]."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this ticket ?\")'><i class='bi bi-trash'></i>Delete</a>";
                   
                    echo "&nbsp;";
                    echo "<td><a href='edit_sale_ticket.php?ticket_id=" . $row['ticket_id'] . "' class='btn btn-warning'><i class='bi bi-pencil'></i>Edit</a></td>";
                     
                    echo "</tr>";
                }
                // Display the total number of tickets
               
echo "</tbody></table>";
 
echo "</tr>";

//echo "<p><b>Total number of tickets: " . $num_rows . "</b></p>";
} else {
echo "<tr><td colspan='4'>No tickets found.</td></tr>";
echo "</tbody></table>";
}

// Calculate percentage of available tickets
if ($total_tickets > 0) {
$percentage_available = round(($total_filtered_tickets / $total_tickets) * 100, 2);
} else {
$percentage_available = 0;
}

echo "</tbody>";
echo "</table>";
echo "<p>Total available tickets: " . $total_tickets . "</p>";
echo "<p>Total filtered tickets: " . $total_filtered_tickets . "</p>";
echo "<p>Percentage of available tickets: " . $percentage_available . "%</p>";







//$conn->close();
//ob_end_flush();
?>
           


</div>
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
<?php
$conn->close();
ob_end_flush();
?>
</html>
