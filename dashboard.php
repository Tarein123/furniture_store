<?php
require_once "db.php";

function noUser()
{
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['count'];
}

function noProduct()
{
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM product";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['count'];
}

function noOrder()
{
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM orders";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['count'];
}
function topSellingProducts()
{
    global $conn;
    $sql = "SELECT p.product_name, SUM(od.quantity) as total_sold
            FROM order_details od
            JOIN product p ON od.product_id = p.product_id
            GROUP BY od.product_id
            ORDER BY total_sold DESC
            LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$topProducts = topSellingProducts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .card-stat {
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: 0.3s ease;
        }

        .card-stat:hover {
            transform: translateY(-3px);
        }

        .card-icon {
            font-size: 2rem;
            color: #0d6efd;
        }

        .card-title {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        .card-value {
            font-size: 1.75rem;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container-fluid">
        <div class="row mt-3" style="min-height: 100vh;">

            <?php require_once "sidebar.php"; ?>

            <div class="col-md-10 py-3">
                <h4 class="mb-4 fw-semibold">Dashboard Overview</h4>

                <div class="row g-4">
                    <!-- Users -->
                    <div class="col-md-4">
                        <div class="card card-stat p-4 border-0 bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="card-title">Total Users</div>
                                    <div class="card-value"><?= noUser(); ?></div>
                                </div>
                                <div class="card-icon">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="col-md-4">
                        <div class="card card-stat p-4 border-0 bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="card-title">Total Products</div>
                                    <div class="card-value"><?= noProduct(); ?></div>
                                </div>
                                <div class="card-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders -->
                    <div class="col-md-4">
                        <div class="card card-stat p-4 border-0 bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="card-title">Total Orders</div>
                                    <div class="card-value"><?= noOrder(); ?></div>
                                </div>
                                <div class="card-icon">
                                    <i class="bi bi-cart-check-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- row -->

                <h4 class="mb-4 fw-semibold text-center">Top 5 Most Selling Products</h4>
                <div class="card p-4 shadow-sm">
                    <canvas id="barChart" height="220"></canvas>
                </div>

            </div>
        </div>
    </div>


    <script>
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($topProducts, 'product_name')) ?>,
                datasets: [{
                    label: 'Units Sold',
                    data: <?= json_encode(array_column($topProducts, 'total_sold')) ?>,
                    backgroundColor: 'rgba(13, 110, 253, 0.6)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>