<?php
require_once "db.php";
if (!isset($_SESSION)) {
    session_start();
}

// Fetch products in cart
$products = [];
$total = 0;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT * FROM product WHERE product_id IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .table img {
            width: 60px;
            height: auto;
        }
    </style>
</head>

<body class="bg-light">

    <?php require_once "cnavbar.php"; ?>

    <div class="container py-5">
        <h2 class="mb-4">Your Shopping Cart</h2>

        <?php if (!empty($products)): ?>
            <form method="post" action="updateCart.php">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product):
                            $productID = $product['product_id'];
                            $qty = $_SESSION['cart'][$productID];
                            $subtotal = $product['price'] * $qty;
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><img src="../<?= $product['img_path'] ?>" alt="<?= $product['product_name'] ?>"></td>
                                <td><?= $product['product_name'] ?></td>
                                <td>$<?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeQty(<?= $product['product_id'] ?>, -1)">-</button>
                                        <input type="text"
                                            id="qty-<?= $product['product_id'] ?>"
                                            value="<?= $qty ?>"
                                            readonly
                                            class="form-control form-control-sm text-center"
                                            style="width: 50px;">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeQty(<?= $product['product_id'] ?>, 1)">+</button>
                                    </div>
                                </td>

                                <td id="subtotal-<?= $product['product_id'] ?>">$<?= number_format($subtotal, 2) ?></td>

                                <td>
                                    <a href="removeFromCart.php?product_id=<?= $product['product_id'] ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to remove this item?');">
                                        Remove
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h5 class="mt-4 text-end">Total Amount: $<span id="totalAmount"><?= number_format($total, 2) ?></span></h5>

                    <div>
                        <a href="viewtest.php" class="btn btn-outline-primary">Continue Shopping</a>
                        <a href="checkOut.php" class="btn btn-primary px-4 py-2">Proceed to Checkout</a>


                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-info">Your cart is currently empty.</div>
            <a href="viewtest.php" class="btn btn-primary">Start Shopping</a>
        <?php endif; ?>
    </div>

    <script>
        const prices = {
            <?php foreach ($_SESSION['cart'] as $pid => $qty): ?>
                <?= $pid ?>: <?= $products[array_search($pid, array_column($products, 'product_id'))]['price'] ?>,
            <?php endforeach; ?>
        };

        function changeQty(pid, delta) {
            const qtyInput = document.getElementById('qty-' + pid);
            let qty = parseInt(qtyInput.value) || 1;

            qty += delta;
            if (qty < 1) qty = 1;

            qtyInput.value = qty;

            // Update subtotal
            const price = prices[pid];
            const subtotal = qty * price;
            document.getElementById('subtotal-' + pid).innerText = '$' + subtotal.toFixed(2);

            // Update session via AJAX (optional for persistence)
            updateSession(pid, qty);

            // Recalculate total
            recalculateTotal();
        }

        function recalculateTotal() {
            let total = 0;
            for (const pid in prices) {
                const qty = parseInt(document.getElementById('qty-' + pid).value) || 1;
                total += qty * prices[pid];
            }
            document.getElementById('totalAmount').innerText = total.toFixed(2);
        }

        function updateSession(pid, qty) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'updateQty.php?product_id=' + pid + '&qty=' + qty, true);
            xhr.send();
        }
    </script>



</body>

</html>