<?php
require_once("db.php");
session_start();

// Handle status update
if (isset($_GET['order_id']) && isset($_GET['update_status'])) {
    $orderId = $_GET['order_id'];
    $newStatus = $_GET['update_status'];
    try {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $stmt->execute([$newStatus, $orderId]);
        $_SESSION['status_updated'] = "Order status updated successfully.";
        header("Location: ordersManage.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating status: " . $e->getMessage();
    }
}

// Fetch orders with user info
try {
    $sql = "SELECT o.*, u.username, u.email 
            FROM orders o 
            LEFT JOIN user u ON o.user_id = u.user_id 
            ORDER BY o.order_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching orders: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-select-sm {
            min-width: 120px;
        }

        .action-form {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .table thead th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container-fluid">
        <div class="row mt-3" style="min-height: 100vh;">

            <?php require_once "sidebar.php"; ?>

            <div class="col-md-10 py-4 px-3">
                <h3 class="mb-4 fw-semibold">Order Management</h3>

                <?php if (isset($_SESSION['status_updated'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['status_updated'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['status_updated']); ?>
                <?php endif; ?>

                <?php if (!empty($orders)) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Order Date</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Shipping</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order) : ?>
                                    <tr>
                                        <td><?= $order['order_id'] ?></td>
                                        <td>
                                            <?php if ($order['user_id']) : ?>
                                                <?= htmlspecialchars($order['username']) ?><br>
                                                <small class="text-muted"><?= htmlspecialchars($order['email']) ?></small>
                                            <?php else : ?>
                                                <em class="text-muted">Guest</em>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date("M d, Y H:i", strtotime($order['order_date'])) ?></td>
                                        <td class="fw-semibold">$<?= number_format($order['total_price'], 2) ?></td>
                                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($order['status']) ?></span></td>
                                        <td><?= htmlspecialchars($order['payment_type']) ?></td>
                                        <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                                        <td>
                                            <form method="get" class="action-form">
                                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                <select name="update_status" class="form-select form-select-sm">
                                                    <option <?= $order['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option <?= $order['status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                                    <option <?= $order['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                                    <option <?= $order['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="alert alert-warning">No orders found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>