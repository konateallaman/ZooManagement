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
      .exhibit-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .exhibit-card h3 {
        margin-top: 0;
    }
    
    .exhibit-card p {
        margin-bottom: 10px;
    }
    
    .exhibit-availability {
        font-style: italic;
    }
    
    .exhibit-buy {
        margin-top: 10px;
        text-align: center;
    }
    
    .exhibit-img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
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
    <br>

	<h1>Upcoming Events</h1>
	<h3><marquee direction="left" style="color: green;">Check out our upcoming exhibits below</marquee></h3>

	<!-- Exhibits Section -->
	<section>
	
		<br><br><br>
		<div class="exhibits-container">
		<?php
   

    // Connect to the database
    require './connection/connect.inc.php';

    // Query the exhibits and sale_tickets tables
    $query = "SELECT exhibits.name, exhibits.description,sale_tickets.ticket_id, sale_tickets.ticket_price, sale_tickets.ticket_type,sale_tickets.available_tickets, exhibits.location, exhibits.exhibit_id FROM exhibits LEFT JOIN sale_tickets ON exhibits.exhibit_id = sale_tickets.event";
    $result = $conn->query($query);

    // Loop through the exhibit data and generate HTML code for each exhibit
    
     while ($row = $result->fetch_assoc()) { ?>
    <div class="exhibit-card animated fadeIn">
        <img src="./Images/exhibit2.jpg" alt="Exhibit 2" class="exhibit-img">
        <h3><span style="color: blue;">Event:</span> <?php echo $row['name']; ?></h3>
        <p><span style="color: green;">Description:</span> <?php echo $row['description']; ?></p>
        <p><span style="color: red;">Ticket Price:</span> $<?php echo $row['ticket_price']; ?></p>
        <p><span style="color: orange;">Ticket type:</span> <?php echo $row['ticket_type']; ?></p>
        <?php if ($row['available_tickets'] == 0) { ?>
            <p class="exhibit-availability"><span style="color: pink;">Availability:</span> Out of stock</p>
            <div class="exhibit-buy">
                <button type="button" class="btn btn-primary" disabled>Buy Ticket</button>
            </div>
        <?php } else { ?>
            <p class="exhibit-availability"><span style="color: pink;">Availability:</span> <?php echo $row['available_tickets']; ?> available</p>
            <form method="post" action="Buy_Ticket.php?CustEmail=<?php echo $CustEmail; ?>">
                <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                <input type="hidden" name="ticket_id" value="<?php echo $row['ticket_id']; ?>">
                <input type="hidden" name="event_id" value="<?php echo $row['exhibit_id']; ?>">
                <input type="hidden" name="ticket_type" value="<?php echo $row['ticket_type']; ?>">
                <input type="hidden" name="ticket_price" value="<?php echo $row['ticket_price']; ?>">
                <div class="exhibit-buy">
                    <button type="submit" class="btn btn-primary">Buy Ticket</button>
                </div>
            </form>
        <?php } ?>
    </div>
    <?php echo '<br><br><br>';
 } 
    

    // Close the database connection
    $conn->close();
?>

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