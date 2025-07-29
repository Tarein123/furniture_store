<?php
require_once "db.php";
session_start();

// Make sure user is logged in
if (!isset($_SESSION['customerEmail'])) {
    header("Location: customerLogin.php");
    exit();
}

$email = $_SESSION['customerEmail'];

// Get user ID
$stmt = $conn->prepare("SELECT user_id, username FROM user WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit();
}

$user_id = $user['user_id'];

// Get all orders for this user
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require_once "cnavbar.php" ?>


    <div class="container mt-3">


        <h3 class="mb-4">🧾 Order History for <?= htmlspecialchars($user['username']) ?></h3>

        <?php if (count($orders) === 0): ?>
            <div class="alert alert-info">You have no past orders.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($orders as $order): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100" style="font-size: 0.9rem;">
                            <div class="card-header bg-light py-2">
                                <strong>Order #<?= $order['order_id'] ?></strong> <br>
                                <small class="text-muted"><?= $order['order_date'] ?></small>
                            </div>
                            <div class="card-body py-2 px-3">
                                <p class="mb-1"><strong>Status:</strong> <?= $order['status'] ?></p>
                                <p class="mb-1"><strong>Payment:</strong> <?= $order['payment_type'] ?></p>
                                <p class="mb-2"><strong>Address:</strong> <?= $order['shipping_address'] ?></p>

                                <!-- Order Items -->
                                <table class="table table-sm table-bordered mb-2">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="font-size: 0.8rem;">Product</th>
                                            <th style="font-size: 0.8rem;">Qty</th>
                                            <th style="font-size: 0.8rem;">Price</th>
                                            <th style="font-size: 0.8rem;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmtItems = $conn->prepare("
                                    SELECT d.quantity, d.price, p.product_name 
                                    FROM order_details d
                                    JOIN product p ON d.product_id = p.product_id
                                    WHERE d.order_id = ?
                                ");
                                        $stmtItems->execute([$order['order_id']]);
                                        $items = $stmtItems->fetchAll();

                                        $orderTotal = 0;
                                        foreach ($items as $item):
                                            $subtotal = $item['quantity'] * $item['price'];
                                            $orderTotal += $subtotal;
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td>$<?= number_format($item['price'], 2) ?></td>
                                                <td>$<?= number_format($subtotal, 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                                            <td><strong>$<?= number_format($orderTotal, 2) ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</body>

</html>