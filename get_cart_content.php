<?php
session_start();

// Check if the cart array exists in the session
if (isset($_SESSION['cart'])) {
    // Retrieve the cart content
    $cart = $_SESSION['cart'];

    // Initialize the cart items HTML
    $cart_items_html = '';

    // Loop through the cart items and create the HTML
    foreach ($cart as $item) {
        $cart_items_html .= '<div class="cart-item">';
        $cart_items_html .= '<p><strong>' . $item['name'] . '</strong></p>';
        $cart_items_html .= '<p>Quantity: ' . $item['quantity'] . '</p>';
        $cart_items_html .= '<p>Price: $' . number_format($item['price'], 2) . '</p>';
        $cart_items_html .= '</div>';
    }

    // Return the cart items HTML
    echo $cart_items_html;
} else {
    // Return an empty cart message if the cart array does not exist in the session
    echo '<p>Your cart is empty.</p>';
}
?>
