<?php
require_once "db.php";
session_start();

$user_id = null;

// Try to fetch user_id from email if logged in
if (isset($_SESSION['customerEmail'])) {
    $email = $_SESSION['customerEmail'];
    $stmt = $conn->prepare("SELECT user_id FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $user_id = $user['user_id'];
    }
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<h4>Your cart is empty.</h4>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $payment_type = $_POST['payment_type'] ?? 'Cash on Delivery';

    $total_price = 0;

    foreach ($cart as $product_id => $qty) {
        $stmt = $conn->prepare("SELECT price FROM product WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        if ($product) {
            $total_price += $product['price'] * $qty;
        }
    }

    try {
        $conn->beginTransaction();

        // ✅ Insert into orders
        $sql = "INSERT INTO orders (user_id, total_price, shipping_address, payment_type)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id, $total_price, $address, $payment_type]);
        $order_id = $conn->lastInsertId();

        // Insert into order_details
        foreach ($cart as $product_id => $qty) {
            $stmt = $conn->prepare("SELECT price FROM product WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
            if ($product) {
                $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price)
                                        VALUES (?, ?, ?, ?)");
                $stmt->execute([$order_id, $product_id, $qty, $product['price']]);
            }
        }

        $conn->commit();
        unset($_SESSION['cart']);

        // ✅ Redirect to receipt page
        header("Location: receipt.php?order_id=" . $order_id);
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "❌ Error: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Guest Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h2>Guest Checkout</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Shipping Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Payment Type</label>
            <select name="payment_type" class="form-select" required>
                <option value="Cash on Delivery">Cash on Delivery</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Paypal">Paypal</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>

        <h5>Order Summary</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                foreach ($cart as $product_id => $qty) {
                    $stmt = $conn->prepare("SELECT product_name, price FROM product WHERE product_id = ?");
                    $stmt->execute([$product_id]);
                    $product = $stmt->fetch();
                    if ($product) {
                        $subtotal = $product['price'] * $qty;
                        $grandTotal += $subtotal;
                        echo "<tr>
                                <td>{$product['product_name']}</td>
                                <td>$qty</td>
                                <td>$ {$product['price']}</td>
                                <td>$ " . number_format($subtotal, 2) . "</td>
                              </tr>";
                    }
                }
                ?>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total</td>
                    <td class="fw-bold">$ <?= number_format($grandTotal, 2) ?></td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Place Order</button>
        <a href="viewCart.php" class="btn btn-secondary">Back to Cart</a>
    </form>
</body>

</html>