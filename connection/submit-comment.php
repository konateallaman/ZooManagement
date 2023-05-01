<?php
ob_start();
require "./connection/connect.inc.php";

// handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $id = random_int(1, 9999);
    $likes=0;

    // prepare statement
    $stmt = $conn->prepare("INSERT INTO comments (id, name, email, comment,likes) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("sssss", $id, $name, $email, $comment,$likes);

    // execute statement
    if ($stmt->execute()) {
        echo "Thanks !";
    } else {
        echo "Error adding comment: " . $conn->error;
    }
}


// handle like button click
if (isset($_GET['like'])) {
    $id = $_GET['like'];

    // update likes count in database
    $stmt = $conn->prepare("UPDATE comments SET likes=likes+1 WHERE id=?");
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
       // redirect back to the page to avoid resubmission on page refresh
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
    } else {
        echo "Error liking comment: " . $conn->error;
    }
}

// display comments
$stmt = $conn->prepare("SELECT * FROM comments");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<b>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . ":</b>";
        echo "<br>" . htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8') . "<br>";
       echo "<a href='?like=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>👍 (" . htmlspecialchars($row['likes'], ENT_QUOTES, 'UTF-8') . ")<br></a>";

        echo "</div>";
    }
} else {
    echo "No comments yet";
}

// close database connection
$conn->close();
ob_end_flush();

?>