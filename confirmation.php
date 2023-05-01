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
    <title>receipt</title>
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
<body >
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
    
    // Connect to the database
require './connection/connect.inc.php';

// Get the last inserted ticket for the visitor
$query = "SELECT * FROM tickets WHERE CustEmail = '{$_SESSION['CustEmail']}' ORDER BY purchase_date DESC LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ticket_id = $row['ticket_id'];
    $ticket_type = $row['ticket_type'];
    $ticket_price = $row['ticket_price'];
    $quantity = $row['Quantity'];
    $purchase_date = $row['purchase_date'];
    $payment_method = $row['payment_method'];
    $event= $row['event'];
    $CustID = $row['CustID'];
} else {
    // Redirect back to the events page
    header('Location: upcoming_events.php');
    exit();
}

// Close the database connection
$conn->close();
?>
<!-- HTML for displaying the ticket receipt -->
<div class="row">
    
    <div class="col-md-8">
        <h2 style="color:red"><?php echo $event; ?></h2>
       
       
        
        <hr>
        <h3>Ticket Details</h3>
         <p>Ticket Id: <?php echo $ticket_id; ?></p>
        <p>Ticket Type: <?php echo $ticket_type; ?></p>
        <p>Quantity: <?php echo $quantity; ?></p>
        <p>Price: $<?php echo $ticket_price; ?></p>
        <hr>
        <h3>Payment Details</h3>
        <p>Payment Method: <?php echo $payment_method; ?></p>
        <p>Date of Purchase: <?php echo $purchase_date; ?></p>
        <p>Total Amount: $<?php echo $ticket_price * $quantity; ?></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" onclick="window.print()">Print Receipt</button>
    </div>
</div>

     
       
    
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>