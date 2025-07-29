<?php
require_once "db.php";
if (!isset($_SESSION)) {
    session_start();
}

// Get order ID from query string
if (!isset($_GET['order_id'])) {
    die("Order ID not provided.");
}
$orderId = $_GET['order_id'];

// Fetch order info
$stmt = $conn->prepare("SELECT o.*, u.username, u.email 
                        FROM orders o
                        LEFT JOIN user u ON o.user_id = u.user_id
                        WHERE o.order_id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch();

if (!$order) {
    die("Order not found.");
}

// Fetch order items
$stmt = $conn->prepare("SELECT od.*, p.product_name, p.img_path 
                        FROM order_details od
                        JOIN product p ON od.product_id = p.product_id
                        WHERE od.order_id = ?");
$stmt->execute([$orderId]);
$orderItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Inside your <body> -->
    <div class="container py-3 d-flex justify-content-center">
        <div class="card p-3 shadow-sm" style="max-width: 700px; width: 100%; font-size: 0.9rem;">
            <h2 class="text-center mb-3">Order Receipt</h2>

            <div class="row mb-3">
                <div class="col-6">
                    <h4 class="py-2">Order Info</h4>
                    <strong>Order ID:</strong> <?= $order['order_id'] ?><br>
                    <strong>Date:</strong> <?= $order['order_date'] ?><br>
                    <strong>Status:</strong> <?= $order['status'] ?><br>
                    <strong>Payment:</strong> <?= $order['payment_type'] ?>
                </div>
                <div class="col-6">
                    <h4 class="py-2">Customer Info</h4>
                    <strong>Name:</strong> <?= htmlspecialchars($order['username'] ?? 'Guest') ?><br>
                    <strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? '-') ?><br>
                    <strong>Address:</strong> <?= htmlspecialchars($order['shipping_address']) ?>
                </div>
            </div>

            <h6>Items</h6>
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Product</th>
                        <th>Img</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Sub</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($orderItems as $item):
                        $subtotal = $item['quantity'] * $item['price'];
                        $total += $subtotal;
                    ?>
                        <tr class="text-center align-middle">
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><img src="../<?= $item['img_path'] ?>" width="45" height="45"></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td><strong>$<?= number_format($order['total_price'], 2) ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center mt-3">
                <a href="viewItem.php" class="btn btn-success btn-sm px-4">Continue Shopping</a>
                <button onclick="window.print()" class="btn btn-outline-primary btn-sm px-4">Print</button>
            </div>
        </div>
    </div>

</body>

</html>