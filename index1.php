<?php
require_once "db.php";
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

</head>

<body>

    <!-- Navbar -->
    <?php require_once "user/cnavbar.php" ?>


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
    </style>
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner hero-carousel">
            <div class="carousel-item active">
                <img src="images/background1.jpg" class="d-block" style="width: 100%; height: 700px;" alt="Hero">
                <div class="carousel-caption text-white">
                    <h1>Elegant & Modern Furniture</h1>
                    <p>Upgrade your home with timeless style</p>
                    <a href="user/viewtest.php" class="btn btn-light">Shop Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/sofa.jpg" class="d-block w-100" alt="Hero2">
                <div class="carousel-caption text-white">
                    <h1>Comfort You Deserve</h1>
                    <p>Discover the finest wooden collections</p>
                    <a href="#" class="btn btn-light">Explore</a>
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
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6 g-4">
            <!-- Repeat for 5 categories -->
            <div class="col">
                <a href="https://www.google.com/chrome/" class="product-card">
                    <div class="card border-0 h-100">
                        <img src="img/sofa.jpg" class="category-img" alt="Living Room" />
                        <div class="card-body p-2">
                            <h6>Living Room</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="https://www.google.com/chrome/" class="product-card">
                    <div class="card border-0 h-100">
                        <img src="img/sofa.jpg" class="category-img" alt="Living Room" />
                        <div class="card-body p-2">
                            <h6>Living Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="https://www.google.com/chrome/" class="product-card">
                    <div class="card border-0 h-100">
                        <img src="img/sofa.jpg" class="category-img" alt="Living Room" />
                        <div class="card-body p-2">
                            <h6>Living Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="https://www.google.com/chrome/" class="product-card">
                    <div class="card border-0 h-100">
                        <img src="img/sofa.jpg" class="category-img" alt="Living Room" />
                        <div class="card-body p-2">
                            <h6>Living Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="https://www.google.com/chrome/" class="product-card">
                    <div class="card border-0 h-100">
                        <img src="img/sofa.jpg" class="category-img" alt="Living Room" />
                        <div class="card-body p-2">
                            <h6>Living Room</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="https://www.google.com/chrome/" class="product-card">
                    <div class="card border-0 h-100">
                        <img src="img/sofa.jpg" class="category-img" alt="Living Room" />
                        <div class="card-body p-2">
                            <h6>Living Room</h6>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Repeat 4 more for Dining Room, Bedroom, Outdoor, Office... -->
        </div>
    </div>

    <!-- Sale off product ............... -->

    <style>
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
    </style>

    <!-- Full-width product banner with text -->
    <div class="container-fluid px-0">
        <div class="full-banner">

            <form class="left-text d-flex me-3">
                <h2 class="clearance-text">Clearance Sale</h2>
                <h3 class="saleoff-num">50%</h3>
                <h4 class="saleoff-text">Off</h4>
                <p class="saleoff-des ml-2">Save up to 50% on Furniture Village sofas,</p>
                <p class="saleoff-des mt-4">all at amazing clearance prices and swiftly</p>
                <p class="saleoff-des mt-5"> directly to you. Don't miss out!</p>
                <button class="buy-btn btn-dark rounded">Buy Now</button>
            </form>

            <form action="" class="d-flex me-3">
                <div class="product-item">
                    <img class="img rounded-4" src="img/sofa.jpg" alt="">
                </div>
            </form>

        </div>
    </div>

    <!-- Featured Products -->

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
    <section class="py-5" id="products">
        <div class="container text-center">
            <h2 class="mb-4">Featured Products</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card product-card">
                        <img src="img/sofa.jpg" class="card-img-top"
                            alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Wooden Chair</h5>
                            <div class="rating mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <p class="card-text">$120</p>
                            <a href="#" class="btn btn-outline-dark btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card product-card">
                        <img src="img/sofa.jpg" class="card-img-top"
                            alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Wooden Chair</h5>
                            <div class="rating mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <p class="card-text">$120</p>
                            <a href="#" class="btn btn-outline-dark btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card product-card">
                        <img src="img/sofa.jpg" class="card-img-top"
                            alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Wooden Chair</h5>
                            <div class="rating mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <p class="card-text">$120</p>
                            <a href="#" class="btn btn-outline-dark btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card product-card">
                        <img src="img/sofa.jpg" class="card-img-top"
                            alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Wooden Chair</h5>
                            <div class="rating mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <p class="card-text">$120</p>
                            <a href="#" class="btn btn-outline-dark btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <!-- Add more product cards as needed -->
            </div>
        </div>
    </section>

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

</html>