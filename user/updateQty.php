<?php
session_start();
if (isset($_GET['product_id']) && isset($_GET['qty'])) {
    $pid = $_GET['product_id'];
    $qty = max(1, intval($_GET['qty'])); // min 1
    $_SESSION['cart'][$pid] = $qty;
}
?>
