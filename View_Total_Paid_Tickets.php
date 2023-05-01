<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <title>View Tickets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
       
.btn-edit {
    margin-right: 10px;
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
        // start the session
        session_start();
        // check if user is logged in
        if (isset($_SESSION['CustEmail'])) {
            $CustEmail = $_SESSION['CustEmail'];
            echo '<div class="alert alert-success"><strong><h4 >You are logged in as:, </h4></strong>' . $CustEmail . '!</div>'; // print the logged-in user's email
        }
        ?>
    </div>
</header>
<div class="navbar">
    <a href="AdminMenu.php"><i class="fa fa-home"></i> Home</a>


    <a href="user-logout-script.php" style="padding-left: 1px"><i class="bi bi-box-arrow-right"></i> Sign out</a>
</div>
<div class="container mt-4">
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
        <label class="form-check-label" for="filter_event">By Event</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="filter" id="filter_ticket_type" value="ticket_type">
        <label class="form-check-label" for="filter_ticket_type">By Ticket Type</label>
    </div>
     <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="filter" id="filter_cust_email" value="cust_email">
        <label class="form-check-label" for="filter_cust_email">By Customer Email</label>
    </div>
   
    <div class="form-group">
        <label for="filter_value">Filter Value:</label>
        <input type="text" class="form-control" id="filter_value" name="filter_value">
    </div>
    
  
 
   
    <button type="submit" class="btn btn-primary">Filter</button>
    
    <?php echo "&nbsp;"; ?>
    
    <a href="ticket_report.php" >Full Report</a>
    
    
    <br>
</form>


    </div>

<div class="container mt-4">
    <h1 class="mb-4" style="color: #00ff40">Tickets Bought by Visitors</h1>
   <?php
require_once "./connection/connect.inc.php"; //database

// Set default filter value
$filter_value = "";

// Check if form is submitted
if (isset($_GET['filter'])) {
    // Get selected filter and its value
    $filter = $_GET['filter'];
    $filter_value = $_GET['filter_value'];

    // Build SQL query based on selected filter
    switch ($filter) {
        case 'ticket_price':
            $sql = "SELECT * FROM tickets INNER JOIN visitors ON tickets.CustID = visitors.CustID WHERE ticket_price = '$filter_value'";
            break;
        case 'ticket_id':
            $sql = "SELECT * FROM tickets INNER JOIN visitors ON tickets.CustID = visitors.CustID WHERE ticket_id = '$filter_value'";
            break;
        case 'event':
            $sql = "SELECT * FROM tickets INNER JOIN visitors ON tickets.CustID = visitors.CustID WHERE event LIKE '%$filter_value%'";
            break;
        case 'ticket_type':
            $sql = "SELECT * FROM tickets INNER JOIN visitors ON tickets.CustID = visitors.CustID WHERE ticket_type LIKE '%$filter_value%'";
            break;
        case 'cust_email':
            $sql = "SELECT * FROM tickets WHERE CustEmail  LIKE '%$filter_value%'";
            break;
           
        default:
            $sql = "SELECT * FROM tickets INNER JOIN visitors ON tickets.CustID = visitors.CustID";
            break;
    }

} else {
    // No filter selected, get all tickets
    $sql = "SELECT * FROM tickets INNER JOIN visitors ON tickets.CustID = visitors.CustID";
}

// Execute SQL query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
   while($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title"><strong>Ticket Id:</strong> ' . $row["ticket_id"] . '</h5>';
        echo '<p class="card-text"><strong>Event:</strong> ' . $row["event"] .'</p>';
        echo '<p class="card-text"><strong>Full Name:</strong> ' . $row["CustFname"] . ' ' . $row["CustLname"] . '</p>';
        echo '<p class="card-text"><strong>Email:</strong> ' . $row["CustEmail"] . '</p>';
        echo '<p class="card-text"><strong>Ticket Type:</strong> ' . $row["ticket_type"] . '</p>';
        echo '<p class="card-text"><strong>Ticket Price:</strong> $' . $row["ticket_price"] . '</p>';
        echo '<p class="card-text"><strong>Purchase Date:</strong> ' . $row["purchase_date"] . '</p>';
        echo '<p class="card-text"><strong>Quantity:</strong> ' . $row["Quantity"] . '</p>';
        echo '<p class="card-text"><strong>Purchase Method:</strong> ' . $row["payment_method"] . '</p>';

        // Edit button
        echo '<a href="edit_ticket.php?id=' . $row["ticket_id"] . '" class="btn btn-primary btn-edit"><i class="bi bi-pencil"></i>Edit</a>';

        // Delete button
        echo '<a href="delete-ticket.php?id=' . $row["ticket_id"] . '" class="btn btn-danger"><i class="bi bi-trash"></i>Delete</a>';

        echo '</div>';
        echo '</div>';
    }
} else {
        echo '<p class="lead">No tickets found.</p>';
    }

    // close database connection
    $conn->close();
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
