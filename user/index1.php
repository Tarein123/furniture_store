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
    <!-- Add in <head> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Add before </body> -->


</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>


    <!-- Navbar -->
    <?php require_once "cnavbar.php" ?>


    <!-- Hero Carousel -->

    <style>
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

        a {
            text-decoration: none;
        }
    </style>
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner hero-carousel">
            <div class="carousel-item active">
                <img src="../images/background2.png" class="d-block" style="width: 100%; height: 580px;" alt="Hero">
                <div class="carousel-caption text-white">
                    <h1>Elegant & Modern Furniture</h1>
                    <p>Upgrade your home with timeless style</p>
                    <a href="user/viewtest.php" class="btn btn-light">Shop Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../images/background3.png" class="d-block w-100" style="width: 100%; height: 580px;" alt="Hero2">
                <div class="carousel-caption text-white">
                    <h1>Comfort You Deserve</h1>
                    <p>Discover the finest wooden collections</p>
                    <a href="user/viewtest.php" class="btn btn-light">Explore</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Categories -->
    <style>
        .category-img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease, opacity 0.3s ease;
            width: 100%;
        }
    </style>
    <div class="container text-center my-5">
        <h2 class="mb-4 fw-bold">Product Categories</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6 g-3">
            <!-- Repeat for 5 categories -->
            <div class="col">
                <a href="user/viewtest.php?cateName=Bed%20Room" class="product-card">
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
                <a href="user/viewtest.php?cateName=Living%20Room" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Living_Room.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Living Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="user/viewtest.php?cateName=Dining%20Room" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Dining_Room.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Dining Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="user/viewtest.php?cateName=Kitchen" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Kitchen.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Kitchen</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="user/viewtest.php?cateName=Outdoor" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Outdoor.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Outdoor</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="user/viewtest.php?cateName=Office" class="product-card">
                    <div class="card border-1 h-100 py-2 px-2">
                        <img src="../images/Office.png" class="category-img" alt="Living Room" style="width: 100%; height: 180px;" />
                        <div class="card-body p-2">
                            <h6>Office</h6>
                        </div>
                    </div>
                </a>
            </div>


            <!-- Repeat 4 more for Dining Room, Bedroom, Outdoor, Office... -->
        </div>
    </div>

    <!-- Sale off product ............... -->

    <!-- <style>
        a {
            text-decoration: none;
        }

        .full-banner {
            background-color: #FDEAC1;
            margin-bottom: 450px;
        }

        .left-text {
            position: absolute;
        }

        .clearance-text {
            margin-top: 30px;
            padding-left: 220px;
            padding-right: 100px;
            color: black;
        }

        .saleoff-num {
            position: absolute;
            padding-top: 60px;
            padding-left: 250px;
            font-size: 100px;
            color: red;
            font-style: italic;
        }

        .saleoff-text {
            position: absolute;
            padding-top: 150px;
            padding-left: 420px;
            font-size: 40px;
            color: red;
        }

        .saleoff-des {
            padding-top: 200px;
            position: absolute;
            padding-left: 200px;
        }

        .product-text {
            padding-left: 100px;
            position: absolute;
        }

        .product-item {
            position: absolute;
            margin-top: 30px;
            margin-bottom: 30px;
            padding-left: 650px;
            width: 300px;
            height: 100px;
        }

        .img {
            width: 500px;
            height: 300px;
        }

        .buy-btn {
            position: absolute;
            padding-left: 30px;
            padding-right: 30px;
            margin-top: 290px;
            margin-left: 280px;
        }
    </style> -->

    <!-- Full-width product banner with text -->
    <div class="container-fluid px-5">
        <div class="full-banner d-flex">

            <form class="text-center mt-5">
                <h2 class="justify-content-center align-items-center">Clearance Sale</h2>
                <h3 class="saleoff-num">25% Off</h3>

                <p class="saleoff-des px-5">Don’t miss out! Our Clearance Sale is here – enjoy huge discounts
                    on a wide range of items as we make room for new stock.
                    Limited quantities available, so shop now before it’s gone! First come, first served!</p>
                <a href="viewtest.php" class="btn btn-outline-secondary btn-sm rounded-pil px-3">Buy Now</a>

            </form>


            <form action="" class="d-flex">
                <div class="product-item pr-4">
                    <img src="../images/Living_Room_25.png" class="d-block" style="width: 500px; height: 300px" alt="Hero">

                </div>
            </form>

        </div>
    </div>

    <!-- Featured Products -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
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
    </style>



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

                                    <form action="addToCart.php" method="get">
                                        <input type="hidden" name="productID" value="<?= $product['product_id'] ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill">
                                            Add to Cart
                                        </button>
                                    </form>
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





    <style>
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

    <!-- Newsletter -->


    <section class="py-5 bg-dark text-white">
        <div class="container text-center">
            <h4>Subscribe to Our Newsletter</h4>
            <p>Get exclusive updates and special offers in your inbox</p>
            <form class="d-flex justify-content-center">
                <input type="email" class="form-control w-25 me-2" placeholder="Enter your email">
                <button type="submit" class="btn btn-light">Subscribe</button>
            </form>
        </div>
    </section>


    <!-- Footer -->

    <style>
        .footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 60px 20px 30px;
            font-size: 15px;
        }

        .footer h5 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer a {
            text-decoration: none;
            color: #dddddd;
        }

        .footer a:hover {
            color: #ffffff;
        }

        .footer input[type="email"] {
            border-radius: 20px;
            padding-left: 15px;
        }

        .social-icons a {
            font-size: 20px;
            margin-right: 10px;
            color: #dddddd;
        }

        .social-icons a:hover {
            color: #ffffff;
        }

        .footer-bottom {
            border-top: 1px solid #444;
            margin-top: 30px;
            padding-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #aaaaaa;
        }
    </style>
    <footer class="footer">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
                <div class="col mb-4">
                    <h5>FURN</h5>
                    <p>Bringing comfort and style to your home with elegant furniture collections.</p>
                </div>

                <div class="col mb-4">
                    <h5>CONTENT</h5>
                    <p><i class="bi bi-telephone-fill me-2"></i>+95 123 456 789</p>
                    <p><i class="bi bi-envelope-fill me-2"></i>support@furn.com</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-telegram"></i></a>
                    </div>
                </div>
                <div class="col mb-4">
                    <h5>PRODUCT</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Sofas</a></li>
                        <li><a href="#">Beds</a></li>
                        <li><a href="#">Dining Tables</a></li>
                        <li><a href="#">Chairs</a></li>
                        <li><a href="#">TV Stands</a></li>
                        <li><a href="#">Coffee Tables</a></li>
                        <li><a href="#">Bookshelves</a></li>
                        <li><a href="#">Wardrobes</a></li>
                    </ul>
                </div>
                <div class="col mb-4">
                    <h5>CLIENT SERVICE</h5>
                    <ul class="list-unstyled mb-3">
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Store Location</a></li>
                    </ul>
                </div>
                <div class="col mb-4">
                    <h5>LEGAL INFO</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Information Use</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom mt-4">
                &copy; 2025 FURN Furniture. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <!-- JS Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        window.onscroll = () => {
            scrollTopBtn.style.display = window.scrollY > 200 ? 'block' : 'none';
        };
        scrollTopBtn.onclick = () => window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    </script>

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