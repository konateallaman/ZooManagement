<?php
// Connect to the database

require_once "./connection/connect.inc.php";

// Get form data
$CustFname = $_POST['CustFname'];
$CustLname = $_POST['CustLname'];
$CustEmail = $_POST['CustEmail'];
$visit_date = $_POST['visit_date'];
$ticket_type = $_POST['ticket_type'];
$ticket_price = $_POST['ticket_price'];
$payment_method = $_POST['payment_method'];

// Determine the payment method and get the corresponding ID
if ($payment_method == 'Gift Card') {
    $gift_card_id = $_POST['gift_card_id'];
    $credit_card_number = NULL;
} else {
    $gift_card_id = NULL;
    $credit_card_number = $_POST['credit_card_number'];
}

$id = mt_rand(100000, 999999); // generate a random number between 100000 and 999999

// Insert visitor information into the Visitors table
$insert_visitor_sql = "INSERT INTO Visitors (CustID, CustFname, CustLname, CustEmail, visit_date)
                      VALUES ('$id','$CustFname $CustLname', '$CustFname', '$CustLname', '$CustEmail', '$visit_date')";
if ($conn->query($insert_visitor_sql) === FALSE) {
    echo "Error: " . $insert_visitor_sql . "<br>" . $conn->error;
} else {
    $CustID = $conn->insert_id; // Get the ID of the newly inserted visitor
}
$Tid = mt_rand(100000, 999999);// random ticket number
// Insert ticket information into the Tickets table
$insert_ticket_sql = "INSERT INTO Tickets (ticket_id,CustID, purchase_date, ticket_type, ticket_price, payment_method, gift_card_id, credit_card_number)
                      VALUES ('$Tid','$CustID', NOW(), '$ticket_type', '$ticket_price', '$payment_method', '$gift_card_id', '$credit_card_number')";
if ($conn->query($insert_ticket_sql) === FALSE) {
    echo "Error: " . $insert_ticket_sql . "<br>" . $conn->error;
} else {
    echo "Ticket purchased successfully!";
}

// Close the database connection
$conn->close();
?>
