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

// Delete product if 'did' (delete ID) is provided
if (isset($_GET['did'])) {
    $deleteId = $_GET['did'];

    try {
        $sql = "DELETE FROM product WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$deleteId]);

        $_SESSION['deleteSuccess'] = "Product deleted successfully!";
        // Redirect to clear the URL
        header("Location: viewItem.php");
        exit;
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
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

            <?php require_once "sidebar.php" ?>

            <!-- Product List Column -->
            <div class="col-md-10 mx-auto py-1 mb-2">

                <!-- Category Filter -->
                <form action="viewItem.php" method="get" class="border border-primary rounded p-3 mb-4">
                    <div class="row g-3 align-items-center">

                        <!-- Category Dropdown -->
                        <div class="col-md-4">
                            <label for="cateChoose" class="form-label fw-semibold">Category</label>
                            <select name="cateChoose" id="cateChoose" class="form-select">
                                <option value="">Choose Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Price Range Radios -->
                        <div class="col-md-5">
                            <label class="form-label fw-semibold d-block">Price Range</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="priceRange" value="0" id="range1">
                                <label class="form-check-label" for="range1">$1–$100</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="priceRange" value="1" id="range2">
                                <label class="form-check-label" for="range2">$101–$200</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="priceRange" value="2" id="range3">
                                <label class="form-check-label" for="range3">$201–$300</label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-3 text-end">
                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4" name="filterSubmit">
                                Apply Filters
                            </button>
                            <form method="GET" action="viewItem.php" class="d-flex mt-4">
                                <button type="submit" class="btn btn-outline-secondary">Reset</button>
                            </form>

                        </div>
                    </div>
                </form>


                <div class="py-2 d-flex">
                    <a class="btn btn-outline-primary" href="insertProduct.php">Add New Item</a>

                    <form class="d-flex me-3 mx-4" method="get" action="viewItem.php">
                        <input class="form-control me-2" type="search" name="wSearch" placeholder="Search..." />
                        <button class="btn btn-outline-success" type="submit" name="bSearch">
                            🔍
                        </button>
                    </form>
                </div>

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
                                        <a class="btn btn-outline-danger btn-sm rounded-pill"
                                            href="viewItem.php?did=<?= $product['product_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this item?');">
                                            Delete
                                        </a>
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