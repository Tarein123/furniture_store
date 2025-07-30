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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        /* <!-- Hero Carousel --> */
        .hero-carousel img {
            height: 80vh;
            object-fit: cover;
            filter: brightness(70%);
        }

        .carousel-caption {
            bottom: 35%;
        }

        .carousel-caption h1 {
            font-size: 3rem;
        }

        /* <!-- Product Categories --> */
        .category-img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease, opacity 0.3s ease;
            width: 100%;
        }

        /* < !-- Featured Products --> */
        .swiper {
            padding: 20px 0;
            position: relative;
        }

        .swiper-slide {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .swiper-slide img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .swiper-button-next,
        .swiper-button-prev {
            background: #00A9B7;
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            top: 45%;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 16px;
            font-weight: bold;
        }

        .swiper-pagination-bullet {
            background: #00A9B7;
            opacity: 0.1;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
        }

        /* product category */

        .product-card {
            text-decoration: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        .category-card img,
        .product-card img {
            height: 200px;
            object-fit: cover;
        }
    </style>

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>


    <!-- Navbar -->
    <?php require_once "cnavbar.php" ?>

    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner hero-carousel">
            <div class="carousel-item active">
                <img src="../images/background2.png" class="d-block" style="width: 100%; height: 580px;" alt="Hero">
                <div class="carousel-caption text-white">
                    <h1>Elegant & Modern Furniture</h1>
                    <p>Upgrade your home with timeless style</p>
                    <a href="viewtest.php" class="btn btn-light">Shop Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../images/background3.png" class="d-block w-100" style="width: 100%; height: 580px;" alt="Hero2">
                <div class="carousel-caption text-white">
                    <h1>Comfort You Deserve</h1>
                    <p>Discover the finest wooden collections</p>
                    <a href="viewtest.php" class="btn btn-light">Explore</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Categories -->

    <div class="container text-center my-5">
        <h2 class="mb-4 fw-bold">Product Categories</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6 g-3">
            <!-- Repeat for 5 categories -->
            <div class="col">
                <a href="viewtest.php?cateName=Bed%20Room" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <div py-5 px-5>
                            <img src="../images/Bed_Room.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        </div>
                        <div class="card-body p-2">
                            <h6>Bed Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="viewtest.php?cateName=Living%20Room" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Living_Room.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Living Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="viewtest.php?cateName=Dining%20Room" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Dining_Room.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Dining Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="viewtest.php?cateName=Kitchen" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Kitchen.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Kitchen</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="viewtest.php?cateName=Outdoor" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Outdoor.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Outdoor</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="viewtest.php?cateName=Office" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Office.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Office</h6>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Clearance Sale -->

    <div class="container-fluid py-5 px-3">
        <div class="row align-items-center">

            <!-- Text Content -->
            <div class="col-lg-6 col-md-12 text-center text-lg-start mb-4 mb-lg-0">
                <div class="mx-5 px-5">
                    <h2 class="fw-bold">Clearance Sale</h2>
                    <h3 class="saleoff-num text-danger">25% Off</h3>
                    <p class="saleoff-des px-2 px-lg-0">
                        Don’t miss out! Our Clearance Sale is here – enjoy huge discounts
                        on a wide range of items as we make room for new stock.
                        Limited quantities available, so shop now before it’s gone!
                        First come, first served!
                    </p>
                    <a href="viewtest.php" class="btn btn-outline-secondary btn-sm px-4 py-2 rounded-pill">
                        Buy Now
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="col-lg-6 col-md-12 text-center">
                <img src="../images/Living_Room_25.png"
                    class="img-fluid rounded-4 shadow"
                    style="max-height: 300px; object-fit: cover;"
                    alt="Sale Banner">
            </div>

        </div>
    </div>


    <div class="container text-center">
        <h2 class="mt-5">Featured Products</h2>
    </div>


    <div class="col-md-10 mx-auto py-2 mb-2">
        <?php if (isset($products)) : ?>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($products as $product) : ?>
                        <div class="swiper-slide">
                            <div class="card border-0 h-100">

                                <a href="detailItem.php?id=<?= $product['product_id'] ?>">
                                    <img src="../<?= $product['img_path'] ?>" alt="<?= $product['product_name'] ?>">
                                </a>

                                <div class="p-3">
                                    <h6 class="fw-semibold"><?= $product['product_name'] ?></h6>
                                    <p class="text-muted mb-2">$<?= number_format($product['price'], 2) ?></p>                   
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination Dots -->
                <div class="swiper-pagination mt-3"></div>
            </div>
        <?php endif; ?>
    </div>


    <!-- Footer -->
    <?php require_once "footer.php" ?>


</body>

<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1
            },
            576: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3
            },
            992: {
                slidesPerView: 4
            }
        }
    });
</script>


</html>