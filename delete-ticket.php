<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <title>View Tickets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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


    <a href="user-logout-script.php" style="padding-left: 1px"><i class="fa fa-user-plus"></i> Sign out</a>
</div>
<?php
ob_start();
require_once "./connection/connect.inc.php"; // Use either mysqli or PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_id = $_POST["ticket_id"];
    // ...delete ticket record from database...
    $sql = "DELETE FROM tickets WHERE ticket_id='$ticket_id'";
    $result = $conn->query($sql);
    // Redirect user back to ticket list page
    header("Location:View_Total_Paid_Tickets.php");
    exit();
} else {
    $ticket_id = $_GET["id"];
    $sql = "SELECT * FROM tickets WHERE ticket_id='$ticket_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <div class="container mt-4">
            <h1 class="mb-4" style="color: #00ff40">Delete Ticket</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="ticket_id">Ticket Id:</label>
                    <input type="text" class="form-control" id="ticket_id" name="ticket_id" value="<?php echo $row["ticket_id"]; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="ticket_type">Ticket Type:</label>
                    <input type="text" class="form-control" id="ticket_type" name="ticket_type" value="<?php echo $row["ticket_type"]; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="ticket_price">Ticket Price:</label>
                    <input type="text" class="form-control" id="ticket_price" name="ticket_price" value="<?php echo $row["ticket_price"]; ?>" readonly>
                </div>
                <!-- ...add other form fields here as needed... -->
                <button type="submit" class="btn btn-danger" >Delete Ticket</button>
            </form>
        </div>
<?php
    } else {
        echo '<p class="lead">Ticket not found.</p>';
    }
}

// close database connection
$conn->close();
ob_end_flush();
?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
