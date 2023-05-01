<?php
require_once "./connection/connect.inc.php";

// Retrieve the comment ID
$comment_id = $_POST['comment_id'];

// Update the like count in the database
$sql = "UPDATE comments SET likes = likes + 1 WHERE id = $comment_id";
mysqli_query($conn, $sql);

// Retrieve the updated like count from the database
$sql = "SELECT likes FROM comments WHERE id = $comment_id";
$result = mysqli_query($conn, $sql);
$comment = mysqli_fetch_assoc($result);

// Display the updated like count
echo $comment['likes'];

// Close the database connection
mysqli_close($conn);
?>
