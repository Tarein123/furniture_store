<?php
require_once "db.php";
if (!isset($_SESSION)) {
    session_start();
}

// Fetch all categories
try {
    $stmt = $conn->prepare("SELECT * FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Base query
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
        WHERE 1=1";

$params = [];

//  Apply Category Filter
if (!empty($_GET['cateChoose'])) {
    $sql .= " AND p.category_id = ?";
    $params[] = $_GET['cateChoose'];
}

//  Apply Price Filter
if (isset($_GET['priceRange'])) {
    switch ($_GET['priceRange']) {
        case '0':
            $sql .= " AND p.price BETWEEN 1 AND 100";
            break;
        case '1':
            $sql .= " AND p.price BETWEEN 101 AND 200";
            break;
        case '2':
            $sql .= " AND p.price BETWEEN 201 AND 300";
            break;
    }
}

if (!empty($_GET['wSearch'])) {
    $sql .= " AND p.product_name LIKE ?";
    $params[] = '%' . trim($_GET['wSearch']) . '%';
}

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error loading products: " . $e->getMessage();
}

//  Delete logic (optional, unchanged)
if (isset($_GET['did'])) {
    $deleteId = $_GET['did'];
    try {
        $stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
        $stmt->execute([$deleteId]);
        $_SESSION['deleteSuccess'] = "Product deleted successfully!";
        header("Location: viewItem.php");
        exit;
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
    }
}

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
                        <button class="btn btn-outline-success" type="submit" name="bSearch">🔍</button>
                    </form>

                </div>

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
                                        <a class="btn btn-outline-primary btn-sm rounded-pill w-100 my-2" href="editItem.php?eid=<?= $product['product_id'] ?>">Edit</a>
                                        <a class="btn btn-outline-danger btn-sm rounded-pill w-100"
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