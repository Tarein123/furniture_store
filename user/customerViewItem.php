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


if (isset($_GET['cate'])) {
    $cid = $_GET['cateChoose'];
    try {
        //
        $sql = "select p.product_id, p.product_name,
            p.price, p.description,
            p.quantity, p.img_path,
            c.name as category
            from product p, category c 
            where p.category_id = c.category_id
            and  c.category_id=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$category_id]);
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} // end if of category selection

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
if (isset($_GET['bSearch'])) {
    $keyword =  $_GET['wSearch'];
    try {
        $sql = "select * from product where name like ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%" . $keyword . "%"]);
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$_SESSION['products'] = $products;

?>


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
        <script>
            function decrease(btn) {
                const form = btn.closest("form");
                const qtyInput = form.querySelector("[name='qty']");
                let qty = parseInt(qtyInput.value) || 0;
                if (qty > 0)
                    qty--;
                qtyInput.value = qty;

            }

            function increase(btn) {
                const form = btn.closest("form");
                const qtyInput = form.querySelector("[name='qty']");
                let qty = parseInt(qtyInput.value) || 0;
                if (qty < 10)
                    qty++;
                qtyInput.value = qty;

            }
        </script>



    </head>
    <!-- 

-->

    <body class="p-2 text-dark bg-opacity-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php require_once "cnavbar.php" ?>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-md-2 py-5">
                    <form action="viewItem.php" method="get" class="form border border-primary border-1 rounded">
                        <select name="cateChoose" class="form-select">
                            <option>Choose Category</option>
                            <?php
                            if (isset($categories)) {
                                foreach ($categories as $category) {
                                    echo "<option value=$category[category_id]> $category[name] </option>";
                                }
                            }

                            ?>

                        </select>
                        <button class="mt-3 btn btn-sm btn-outline-primary rounded-pill" name="cate" type="submit">Submit</button>
                    </form>
                    <form action="viewItem.php" method="get" class="mt-5 form border border-primary border-1 rounded">
                        <fieldset>
                            <legend>
                                <h6>Choose Price Range</h6>
                            </legend>

                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="priceRange" value="0">
                                <label class="form-check-label" for="priceRange">
                                    $1-$100
                                </label>
                                <br>
                                <input class="form-check-input" type="radio" name="priceRange" value="1">
                                <label class="form-check-label" for="priceRange">
                                    $100-$200
                                </label>
                                <br>

                                <input class="form-check-input" type="radio" name="priceRange" value="2">
                                <label class="form-check-label" for="priceRange">
                                    $201-$300
                                </label>
                            </div>
                            <button class="mt-3 btn btn-sm btn-outline-primary rounded-pill" name="priceRadio" type="submit">Submit</button>

                        </fieldset>


                    </form>

                </div>

                <div class="col-md-10 mx-auto py-5 mb-2">
                    <?php if (array_key_exists('cart', $_SESSION)) { ?>
                        <div class="py-2 d-flex justify-content-end"> <a href="viewCart.php"><img src="profile/cart2.png" alt="view cart" style="width:60px; height:60px"></a></div>

                    <?php } ?>

                    <?php
                    if (isset($products)) {
                        echo "<div class=row>";
                        foreach ($products as $product) { ?>
                            <div class="col-md-3 mb-4">

                                <div class="card text-center shadow-sm rounded-4 p-3 h-100">



                                    <!-- Product Image -->
                                    <a href="detailItem.php?id=<?= $product['product_id'] ?>">
                                        <img src="../<?= $product['img_path'] ?>" class="img-fluid rounded mb-3" style="height: 180px; object-fit: contain;" alt="<?= $product['product_name'] ?>">
                                        <div class="content">
                                            <h3>view detail</h3>
                                        </div>
                                    </a>

                                    <!-- Product Name -->
                                    <h6 class="fw-semibold"><?= $product['product_name'] ?></h6>

                                    <!-- Price and Quantity -->
                                    <div class="d-flex justify-content-center align-items-center mb-3 gap-2">
                                        <span class="text-muted">$<?= number_format($product['price'], 2) ?></span>
                                        <input type="number" name="qty" value="<?= isset($_SESSION['cart'][$product['product_id']]) ? $_SESSION['cart'][$product['product_id']] : 1 ?>"
                                            class="form-control form-control-sm text-center"
                                            style="width: 60px;" min="1" max="10">
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-center gap-2">


                                        <form action="addToCart.php" method="get" class="d-inline">
                                            <input type="hidden" name="productID" value="<?= $product['product_id'] ?>">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" name="addCart" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>


                                </div>
                            </div>

                    <?php }

                        echo "</div>";
                    }

                    ?>

                </div>

            </div>
        </div>
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
