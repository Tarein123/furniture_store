<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f4f6f9;
            
        }

        .sidebar {
            height: auto;
            background-color: rgba(75, 67, 67, 0.08);
            padding-top: 20px;
            color: black;
        }

        .sidebar a {
            color: black;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: rgba(46, 32, 136, 0.17);
        }

    </style>
</head>

<body>

            <div class="col-md-2 sidebar">
                <h4 class="text-center">Admin</h4>
                <a href="dashboard.php">Dashboard</a>
                <a href="viewItem.php">Product</a>
                <a href="userManage.php">user</a>
                <a href="ordersManage.php">Orders</a>
                <a href="#">Logout</a>
            </div>


</body>

</html>