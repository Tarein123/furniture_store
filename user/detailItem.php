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

// add to cart
function getCartCount()
{
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        return array_sum($_SESSION['cart']);
    }
    return 0;
}
$cartCount = getCartCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $product['product_name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .product-wrapper {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .accordion-button {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }

        .form-control {
            max-width: 80px;
        }

        @media (max-width: 768px) {
            .product-wrapper {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>

    <?php require_once "cnavbar.php" ?>

    <!-- CATEGORY FILTER BAR -->
    <div class="d-flex bg-light shadow-sm py-1">
        <div class="container d-flex flex-wrap gap-3 justify-content-left">
            <a href="viewtest.php" class="btn btn-sm btn-outline-dark">All</a>
            <a href="viewtest.php?cateName=Bed%20Room" class="btn btn-sm btn-outline-dark">Bed</a>
            <a href="viewtest.php?cateName=Dining%20Room" class="btn btn-sm btn-outline-dark">Dining</a>
            <a href="viewtest.php?cateName=Living%20Room" class="btn btn-sm btn-outline-dark">Living</a>
            <a href="viewtest.php?cateName=Outdoor" class="btn btn-sm btn-outline-dark">Outdoor</a>
            <a href="viewtest.php?cateName=Office" class="btn btn-sm btn-outline-dark">Office</a>
            <a href="viewtest.php?cateName=Kitchen" class="btn btn-sm btn-outline-dark">Kitchen</a>
        </div>

        <?php $cartCount = getCartCount(); ?>
        <div class="d-flex justify-content-end align-items-center me-4 position-relative">
            <a href="viewCart.php">
                <img src="../images/cart3.png" alt="view cart" style="width: 32px; height: 32px;">
                <?php if ($cartCount > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $cartCount ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
    </div>

    <div class="container py-4 mt-2">
        <div class="product-wrapper">
            <div class="row g-4">
                <!-- Image -->
                <div class="col-md-5 text-center">
                    <img src="../<?= $product['img_path'] ?>" alt="<?= $product['product_name'] ?>" class="product-image mb-3">
                    <a href="viewtest.php" class="btn btn-sm btn-outline-secondary">← Back</a>
                </div>

                <!-- Details -->
                <div class="col-md-7">
                    <h4 class="fw-semibold mb-2"><?= $product['product_name'] ?></h4>
                    <p class="text-muted mb-2">$<?= number_format($product['price'], 2) ?></p>

                    <p class="small text-body mb-3"><?= $product['description'] ?></p>

                    <form action="addToCart.php" method="get" class="d-inline">
                        <input type="hidden" name="productID" value="<?= $product['product_id'] ?>">
                        <input type="hidden" name="qty" value="1">
                        <button type="submit" name="addCart" class="btn btn-outline-secondary btn-dark btn-sm rounded-pill px-3" style="color: white;">
                            Add to Cart
                        </button>
                    </form>

                    <!-- Accordion Info -->
                    <div class="accordion accordion-flush" id="productAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    Materials & Finish
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                                <div class="accordion-body small">
                                    <?= $product['materials'] ?? 'Solid Wood, High-Quality Fabric, Premium Coating' ?>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    Assembly Guide / Video
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                                <div class="accordion-body small">
                                    <a href="#" style="text-decoration: none; color: black;">Watch our simple setup video</a>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    Features & Usage
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                                <div class="accordion-body small">
                                    Comfortable seating, scratch-resistant surface, easy to clean. Perfect for everyday use.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    Why You'll Love This
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                                <div class="accordion-body small">
                                    Built to last with a stylish modern aesthetic. Enhances your home or office ambiance.
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Accordion -->
                </div>
            </div>
        </div>
    </div>

    <?php require_once "footer.php" ?>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>