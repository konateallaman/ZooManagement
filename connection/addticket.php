<?php
ob_start();
require './connection/connect.inc.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $ticket_type = $_POST['ticket_type'];
  $ticket_price = $_POST['ticket_price'];
   $event = $_POST['event'];
  $id = random_int(1, 9999);
  
  // perform validation
  if(empty($ticket_type) || empty($ticket_price) || empty($event)) {
    $message = "<p class='alert alert-warning'>Please fill in all fields.</p>";
  } else {
    // perform database insert
    // Prepare and execute SQL statement
    $sql = "INSERT INTO sale_tickets (ticket_id,ticket_type, ticket_price,event) VALUES (?,?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds",$id, $ticket_type, $ticket_price,$event);
    $result = $stmt->execute();
    if ($result === TRUE) {
      $message = "<p class='alert alert-success'>Ticket Added successfully.</p>";
    }
  }
  
}

// Handle deleting or editing an existing ticket
if (!empty($_POST["ticket_id"]) && !empty($_POST["action"])) {
  $ticket_id = $_POST["ticket_id"];
  $action = $_POST["action"];

  if ($action == "delete") {
    // perform database delete
    // Prepare and execute SQL statement
    $query = "DELETE FROM sale_tickets WHERE ticket_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $ticket_id);
    $result = $stmt->execute();
    if ($result === TRUE) {
      $message = "<p class='alert alert-danger'>Ticket deleted successfully.</p>";
    }
    
  }
}

// Close the database connection
$conn->close();
//ob_end_flush();
?>