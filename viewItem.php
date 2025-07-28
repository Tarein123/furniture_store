<?php
require_once "db.php";
if (!isset($_SESSION)) {
    session_start();
}

// Get all categories
try {
    $sql = "SELECT * FROM category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Get all products
try {
    $sql = "SELECT 
                p.product_id, 
                p.product_name,
                p.description, 
                p.price,
                p.img_path, 
                p.quantity,
                c.name AS category
            FROM product p
            JOIN category c ON p.category_id = c.category_id";

    $stmt = $conn->query($sql);
    $products = $stmt->fetchAll();  //  FIXED from $product to $products
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Filter by category
if (isset($_GET['cate'])) {
    $cid = $_GET['cateChoose'];
    try {
        $sql = "SELECT 
                    p.product_id, 
                    p.product_name,
                    p.description, 
                    p.price,
                    p.img_path, 
                    p.quantity,
                    c.name AS category
                FROM product p
                JOIN category c ON p.category_id = c.category_id
                WHERE p.category_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$cid]);
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Filter by price range
if (isset($_GET['priceRadio'])) {
    $range = $_GET['priceRange'];
    $lower = 0;
    $upper = 0;
    if ($range == 0) {
        $lower = 1;
        $upper = 100;
    } else if ($range == 1) {
        $lower = 101;
        $upper = 200;
    } else if ($range == 2) {
        $lower = 201;
        $upper = 300;
    }

    $sql = "SELECT 
                p.product_id, 
                p.product_name,
                p.description, 
                p.price,
                p.img_path, 
                p.quantity,
                c.name AS category
            FROM product p
            JOIN category c ON p.category_id = c.category_id
            WHERE p.price BETWEEN ? AND ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$lower, $upper]);
    $products = $stmt->fetchAll();
}

if (isset($_GET['bSearch'])) {
    $keyword =  $_GET['wSearch'];
    try {
        $sql = "select * from item where iname like ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%" . $keyword . "%"]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Items</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <?php require_once "navbar.php" ?>
            </div>
        </div>

        <div class="row mt-3">
            <!-- Filter Column -->
            <div class="col-md-2 py-5">
                <!-- Category Filter -->
                <form action="viewItem.php" method="get" class="form border border-primary border-1 rounded">
                    <select name="cateChoose" class="form-select">
                        <option value="">Choose Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="mt-3 btn btn-sm btn-outline-primary rounded-pill" name="cate" type="submit">Submit</button>
                </form>

                <!-- Price Filter -->
                <form action="viewItem.php" method="get" class="mt-5 form border border-primary border-1 rounded">
                    <fieldset>
                        <legend>
                            <h6>Choose Price Range</h6>
                        </legend>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priceRange" value="0">
                            <label class="form-check-label">$1–$100</label><br>
                            <input class="form-check-input" type="radio" name="priceRange" value="1">
                            <label class="form-check-label">$101–$200</label><br>
                            <input class="form-check-input" type="radio" name="priceRange" value="2">
                            <label class="form-check-label">$201–$300</label>
                        </div>
                        <button class="mt-3 btn btn-sm btn-outline-primary rounded-pill" name="priceRadio" type="submit">Submit</button>
                    </fieldset>
                </form>

                <form method="GET" action="viewItem.php" class="d-flex mt-4">
                    <button type="submit" class="btn btn-outline-secondary">Reset</button>
                </form>

            </div>

            <!-- Product List Column -->
            <div class="col-md-10 mx-auto py-5 mb-2">
                <div class="py-2"> <a class="btn btn-outline-primary" href="insertProduct.php">Add New Item</a></div>

                <?php
                if (isset($_SESSION['insertSuccess'])) {
                    echo "<p class='alert alert-success'>$_SESSION[insertSuccess]</p>";
                    unset($_SESSION['insertSuccess']);
                } elseif (isset($_SESSION['updateSuccess'])) {
                    echo "<p class='alert alert-success'>$_SESSION[updateSuccess]</p>";
                    unset($_SESSION['updateSuccess']);
                } elseif (isset($_SESSION['deleteSuccess'])) {
                    echo "<p class='alert alert-success'>$_SESSION[deleteSuccess]</p>";
                    unset($_SESSION['deleteSuccess']);
                }
                ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($products) && count($products) > 0): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                                    <td>$<?= number_format($product['price'], 2) ?></td>
                                    <td><?= htmlspecialchars($product['description']) ?></td>
                                    <td><?= htmlspecialchars($product['category']) ?></td>
                                    <td><?= $product['quantity'] ?></td>
                                    <td><img src="<?= htmlspecialchars($product['img_path']) ?>" style="width:80px; height:80px;" alt="Product Image"></td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm rounded-pill" href="editItem.php?eid=<?= $product['product_id'] ?>">Edit</a>
                                        <a class="btn btn-outline-danger btn-sm rounded-pill" href="editItem.php?did=<?= $product['product_id'] ?>">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

