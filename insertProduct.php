<?php
require_once "db.php";

// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Fetch categories
$sql = "SELECT * FROM category";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();

// Handle form submission
if (isset($_POST['insertItem'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $fileName = $_FILES['img']['name'];
    $filePath = "images/" . $fileName;

    // Upload image to server
    $status = move_uploaded_file($_FILES['img']['tmp_name'], $filePath);
    if ($status) {
        // Use explicit column names
        $sql = "INSERT INTO product (product_id, product_name, description, price, quantity, img_path, category_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([null, $product_name, $description, $price, $quantity, $filePath, $category_id]);

        if ($status) {
            $lastId = $conn->lastInsertId();
            $_SESSION['insertSuccess'] = "Item with ID $lastId has been inserted successfully!";
            header("Location: viewItem.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Insert failed: ";
            print_r($stmt->errorInfo());
            echo "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Image upload failed.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Insert Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navbar.php"; ?>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form class="form mt-2 pt-2" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <fieldset>
                        <legend>Insert Product</legend>
                        <div class="mb-2">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" required>
                        </div>
                        <div class="mb-2">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" step="0.01" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" required>
                        </div>
                        <div class="mb-2">
                            <label for="img" class="form-label">Choose Product Image</label>
                            <input type="file" class="form-control" name="img" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="insertItem">Insert Item</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>

</html>