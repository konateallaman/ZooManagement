
    <?php
    session_start();

if (isset($_POST['ticket_id'])) {
    $ticketId = $_POST['ticket_id'];
    if (!in_array($ticketId, $_SESSION['cart'])) {
        array_push($_SESSION['cart'], $ticketId);
        echo 'success';
    } else {
        echo 'Item already in cart';
    }
}

    ?>

