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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
    .exhibit-img {
    width: 50%;
    height: auto;
}

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
    <a href="WelcomePage.php"><i class="fa fa-home"></i> Home</a>


    <a href="user-logout-script.php" style="padding-left: 1px"><i class="bi bi-box-arrow-right"></i> Sign out</a>
</div>
   
<div class="container">
 <?php
    
        // check if user is logged in
    if (!isset($_SESSION['CustEmail'])) {
        header("Location: UserLogin.php"); // redirect to login page if user is not logged in
    }

    // Check if the form has been submitted
    if (isset($_POST['buy'])) {
        // Connect to the database
        require './connection/connect.inc.php';

        try {
            // Get the form data
            $ticket_id = $_POST['ticket_id'];
            $ticketType = $_POST['ticket_type'];
            $ticketPrice = $_POST['ticket_price'];
            $purchaseDate = date('Y-m-d H:i:s');
            $paymentMethod = $_POST['payment_method'];
            $event=$_POST['name'];
            $eventID = $_POST['event_id'];
            $quantity = $_POST['Quantity'];
            $id = random_int(1, 9999);

            // Query the visitors table to check if the logged in customer exists
            $query = "SELECT * FROM visitors WHERE CustEmail = '{$_SESSION['CustEmail']}'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $CustID = $row["CustID"];
                
                // Insert the ticket into the tickets table
                $query = "INSERT INTO tickets (ticket_id,sale_ticket_id, CustID, CustEmail, purchase_date, ticket_type, ticket_price,Quantity, payment_method,event) 
                          VALUES ('$id','$ticket_id', '$CustID', '{$_SESSION['CustEmail']}', '$purchaseDate', '$ticketType', '$ticketPrice','$quantity', '$paymentMethod','$event')";
                $conn->query($query);

                // Update the available tickets in the sale_tickets table
                $query = "UPDATE sale_tickets SET available_tickets = available_tickets - $quantity WHERE ticket_id = $ticket_id";
                $conn->query($query);

                // Redirect back to the events page
                header('Location: confirmation.php');
                exit();
            } else {
                throw new Exception("The logged in customer does not exist.");
            }
        } catch (Exception $e) {
            $message = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';

        }

        // Close the database connection
        $conn->close();
    }
    ?>
<!-- HTML form for buying a ticket -->
<div class="container">
    <?php
    echo $message;
    ?>
    <h1>Buy Ticket</h1>
    <form method="post">
        
         <div class="form-group">
            <label for="ticket_id">Event</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $_POST['name']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="ticket_id"></label>
            <input type="hidden" class="form-control" id="ticket_id" name="ticket_id" value="<?php echo $_POST['ticket_id']; ?>" readonly>
        </div>
            <div class="form-group">
        <label for="ticket_type">Ticket Type:</label>
        <input type="text" class="form-control" id="ticket_type" name="ticket_type" value="<?php echo $_POST['ticket_type']; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="ticket_price">Ticket Price:</label>
        <input type="text" class="form-control" id="ticket_price" name="ticket_price" value="<?php echo $_POST['ticket_price']; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="payment_method">Payment Method:</label>
        <select class="form-control" id="payment_method" name="payment_method" required>
            <option value="Credit Card">Credit Card</option>
            <option value="Gift Card">Gift Card</option>
        </select>
    </div>
    <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" class="form-control" id="quantity" name="Quantity" min="1" required>
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" id="event_id" name="event_id" value="<?php echo $_POST['event_id']; ?>">
    </div>
    <button type="submit" class="btn btn-primary" name="buy">Buy Now</button>
</form>
</div>
       


<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>