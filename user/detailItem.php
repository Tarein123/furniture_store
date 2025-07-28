<?php
require_once "db.php";
if (!isset($_SESSION)) session_start();

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $stmt = $conn->prepare("SELECT p.*, c.name as category 
                            FROM product p 
                            JOIN category c ON p.category_id = c.category_id
                            WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if (!$product) {
        echo "Product not found!";
        exit;
    }
} else {
    echo "No product selected.";
    exit;
}
?>
<!-- Then show the product info in HTML -->

<!-- <img src="../<?= $product['img_path'] ?>" style="width:150px">
<h1><?= $product['product_name'] ?></h1>
<p><?= $product['description'] ?></p>
<p>Category: <?= $product['category'] ?></p>
<p>Price: $<?= $product['price'] ?></p> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $product['product_name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .product-image {
            width: 400px;
            height: 500px;
            border-radius: 10px;
        }

        .accordion-button {
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row g-5">

            <!-- Left Side: Image -->
            <div class="col-md-6 text-center">
                <img src="../<?= $product['img_path'] ?>" alt="<?= $product['product_name'] ?>" class="product-image shadow">
                <a href="viewtest.php" class="btn btn-outline-secondary mt-3 ms-2">Back to Products</a>

            </div>

            <!-- Right Side: Details -->
            <div class="col-md-6">
                <h2 class="fw-bold"><?= $product['product_name'] ?></h2>
                <p class="h5 text-muted">$<?= number_format($product['price'], 2) ?></p>

                <p class="text-secondary small">
                    ★★★★★ <span class="ms-2">(8 Reviews)</span>
                </p>

                <p class="text-muted fst-italic">100% raw, unrefined, organic & cruelty-free. 200 ML</p>

                <p><?= $product['description'] ?></p>

                <!-- Quantity & Add to Cart -->
                <div class="d-flex align-items-center my-4">
                    <label for="qty" class="me-2">Quantity</label>
                    <input type="number" id="qty" name="qty" min="1" value="1" class="form-control w-25 me-3">
                    <button class="btn btn-dark">ADD TO CART</button>
                </div>

                <!-- Accordion Sections -->
                <div class="accordion" id="productAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                Ingredients
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                            <div class="accordion-body">
                                <?= $product['ingredients'] ?? 'Pure Coconut Oil' ?>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Watch Video
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                            <div class="accordion-body">
                                <a href="#">Click here to watch product video.</a>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                Benefits & How To Use
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                            <div class="accordion-body">
                                Apply a small amount to hair or skin. Use daily for best results.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                Why Love Hair Coconut Oil
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                            <div class="accordion-body">
                                Cold-pressed, non-greasy, quick absorbing, and safe for all skin types.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>