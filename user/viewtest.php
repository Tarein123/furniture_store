<?php
require_once "db.php";
if (!isset($_SESSION)) {
    session_start();
}
try {
    $sql = "select * from category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $sql = "select p.product_id, p.product_name,
		p.price, p.description,
        p.quantity, p.img_path,
        c.name as category
        from product p, category c 
        where p.category_id = c.category_id";

    $stmt = $conn->query($sql);
    $products = $stmt->fetchAll();
    //print_r($items);

} catch (PDOException $e) {
    echo $e->getMessage();
}


// filter by price
if (isset($_GET['priceRadio'])) {
    $range = $_GET['priceRange'];
    $sql = "select p.product_id, p.product_name,
            p.price, p.description,
            p.quantity, p.img_path,
            c.name as category
            from product p, category c 
            where p.category_id = c.category_id
            and  p.price between ? and ?";
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

    $stmt = $conn->prepare($sql);
    $stmt->execute([$lower, $upper]);
    $products = $stmt->fetchAll();
}


// Category name-based filtering (e.g., from 'cateName=Living Room')
if (isset($_GET['cateName'])) {
    $cateName = $_GET['cateName'];
    $sql = "SELECT p.product_id, p.product_name,
                p.price, p.description,
                p.quantity, p.img_path,
                c.name as category
            FROM product p
            JOIN category c ON p.category_id = c.category_id
            WHERE c.name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$cateName]);
    $products = $stmt->fetchAll();
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

<?php if (isset($_SESSION['customerEmail']) && isset($_SESSION['clogin'])) { ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Item</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>



    </head>

    <body class="text-dark bg-opacity-50">

        <?php require_once "cnavbar.php" ?>

        <div class="container-fluid">

            <!-- CATEGORY FILTER BAR -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-wrap bg-light shadow-sm py-2 px-3 justify-content-between align-items-center">

                        <!-- Category Buttons -->
                        <div class="d-flex flex-wrap gap-2">
                            <a href="viewtest.php" class="btn btn-sm btn-outline-dark">All</a>
                            <a href="viewtest.php?cateName=Bed%20Room" class="btn btn-sm btn-outline-dark">Bed</a>
                            <a href="viewtest.php?cateName=Dining%20Room" class="btn btn-sm btn-outline-dark">Dining</a>
                            <a href="viewtest.php?cateName=Living%20Room" class="btn btn-sm btn-outline-dark">Living</a>
                            <a href="viewtest.php?cateName=Outdoor" class="btn btn-sm btn-outline-dark">Outdoor</a>
                            <a href="viewtest.php?cateName=Office" class="btn btn-sm btn-outline-dark">Office</a>
                            <a href="viewtest.php?cateName=Kitchen" class="btn btn-sm btn-outline-dark">Kitchen</a>
                        </div>

                        <!-- Cart Icon -->
                        <div class="position-relative ms-auto">
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
                </div>
            </div>

            <!-- FILTER + PRODUCTS -->
            <div class="row mt-4">

                <!-- Sidebar Filter -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="card shadow-sm p-3">
                        <form method="get" action="viewtest.php">
                            <h5 class="mb-3">Filter</h5>

                            <fieldset class="border p-2 rounded">
                                <legend class="small fw-semibold">Choose Price Range</legend>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="priceRange" value="0" id="range1">
                                    <label class="form-check-label" for="range1">$1–$100</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="priceRange" value="1" id="range2">
                                    <label class="form-check-label" for="range2">$101–$200</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="priceRange" value="2" id="range3">
                                    <label class="form-check-label" for="range3">$201–$300</label>
                                </div>

                                <button class="btn btn-success btn-sm w-100 mt-3" type="submit">Apply Filter</button>
                                <a href="viewtest.php" class="btn btn-outline-secondary btn-sm w-100 mt-2">Reset</a>
                            </fieldset>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9 col-md-8">
                    <div class="row">

                        <?php if (isset($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card text-center shadow-sm rounded-4 p-3 h-100">

                                        <a href="detailItem.php?id=<?= $product['product_id'] ?>">
                                            <img src="../<?= $product['img_path'] ?>" class="img-fluid rounded mb-3" style="height: 180px; object-fit: contain;" alt="<?= $product['product_name'] ?>">
                                            <div class="content">
                                                <h6 class="text-primary small">View Detail</h6>
                                            </div>
                                        </a>

                                        <h6 class="fw-semibold"><?= $product['product_name'] ?></h6>

                                        <div class="mb-3 text-muted">$<?= number_format($product['price'], 2) ?></div>

                                        <form action="addToCart.php" method="get">
                                            <input type="hidden" name="productID" value="<?= $product['product_id'] ?>">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>


        <?php require_once "footer.php" ?>

        <style>
            .card:hover {
                transform: scale(1.03);
                transition: 0.4s ease-in-out;
            }

            .content {
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
                width: 100%;
                height: 210px;
                left: 0;
                top: 0;
                position: absolute;
                background: rgba(0, 0, 0, 0.3);
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                opacity: 0;
                transition: 0.6s;

            }

            .content:hover {
                opacity: 1;
            }

            .content h3 {
                font-size: 25px;
                color: #ffe100;
                justify-content: end;
            }
        </style>
    </body>

    </html>

<?php } else {
    header("Location:customerLogin.php");
} ?>