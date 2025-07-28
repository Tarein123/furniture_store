<?php
session_start();

// Check if cart and item to remove exist
if (isset($_GET['product_id']) && isset($_SESSION['cart'])) {
    $productId = $_GET['product_id'];

    // Remove the product from the cart
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

// Redirect back to cart
header("Location: viewCart.php");
exit;
