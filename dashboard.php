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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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

            </div>
        </div>
    </div>

</body>

</html>