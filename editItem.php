<?php
require_once "db.php";
if (!isset($_SESSION)) {
    session_start();
}

// Redirect if eid is not provided
if (!isset($_GET['eid'])) {
    header("Location: viewItem.php");
    exit;
}

// Fetch categories
$sql = "SELECT * FROM category";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();

// Fetch product details
$product = null;
$product_id = $_GET['eid'];
try {
    $sql = "SELECT p.product_id, p.product_name,
               p.price, p.description, 
               p.quantity, p.img_path, c.name as category,
               p.category_id
        FROM product p
        JOIN category c ON p.category_id = c.category_id
        WHERE p.product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Handle update request
if (isset($_POST['updateItem'])) {
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $fileName = $_FILES['img']['name'];
    $filePath = "images/" . $fileName;

    // Upload new image only if one is selected
    if (!empty($fileName)) {
        move_uploaded_file($_FILES['img']['tmp_name'], $filePath);
    } else {
        $filePath = $product['img_path']; // keep old image if not changed
    }

    $sql = "UPDATE product 
            SET product_name = ?, price = ?, quantity = ?, 
            description = ?, category_id = ?, img_path = ?
            WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $status = $stmt->execute([
        $productName,
        $price,
        $quantity,
        $description,
        $category,
        $filePath,
        $productID
    ]);

    if ($status) {
        $_SESSION['updateSuccess'] = "Product with ID $productID has been updated successfully!";
        header("Location: viewItem.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-6 mx-auto mt-3">
                <form class="form" enctype="multipart/form-data" method="post" action="">
                    <fieldset>
                        <legend>Edit Item</legend>
                        <input type="hidden" name="productID" value="<?= isset($product) ? $product['product_id'] : '' ?>">

                        <div class="mb-2">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="productName"
                                value="<?= isset($product) ? htmlspecialchars($product['product_name']) : '' ?>">
                        </div>

                        <div class="mb-2">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price"
                                value="<?= isset($product) ? $product['price'] : '' ?>">
                        </div>

                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control"><?= isset($product) ? htmlspecialchars($product['description']) : '' ?></textarea>
                        </div>

                        <div class="mb-2">
                            <label for="category" class="form-label">Category</label>
                            <p>Currently selected: <strong><?= isset($product) ? $product['category'] : 'None' ?></strong></p>
                            <select name="category" class="form-select">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['category_id'] ?>"
                                        <?= (isset($product) && $product['category_id'] == $cat['category_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity"
                                value="<?= isset($product) ? $product['quantity'] : '' ?>">
                        </div>

                        <div class="mb-2">
                            <?php if (isset($product)): ?>
                                <img src="<?= $product['img_path'] ?>" alt="Image" style="width: 100px;"><br>
                            <?php endif; ?>
                            <label for="img" class="form-label">Choose New Image (optional)</label>
                            <input type="file" class="form-control" name="img">
                        </div>

                        <button type="submit" class="btn btn-primary" name="updateItem">Update Item</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>

</html>