<?php
session_start();

if (isset($_GET['productID'])) {
    $id = $_GET['productID'];
    $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }

    // Redirect back
    header("Location: viewtest.php");
    exit;
}
?>

