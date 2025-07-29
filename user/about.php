<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Us - Furn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-M9Mg5I0JhO1z58uZ5eIR9P6VJj+snzVvTGbDZnqYYMxqG2wlNzAzSFlzZfh5ZVqU1tMIMRSe0tSzQpxjT1krsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffffff;
            border-radius: 50%;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php include "cnavbar.php"; ?>

    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold">About <span class="text-success">Furn</span></h1>
            <p class="text-muted">Timeless furniture for your beautiful home.</p>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <img src="../images/show_room.png" class="img-fluid rounded shadow" alt="Furn showroom">
            </div>
            <div class="col-md-6">
                <h3 class="fw-semibold">Who We Are</h3>
                <p>
                    Furn is a modern furniture brand offering thoughtfully designed pieces that combine style, comfort,
                    and durability. From cozy sofas to elegant dining tables, our collections are crafted to elevate
                    your home experience.
                </p>
                <p>
                    Started in 2022, we now serve thousands of happy customers across the country with top-notch
                    products and unmatched customer support.
                </p>
            </div>
        </div>

        <div class="row text-center mb-5">
            <div class="col-md-4">
                <div class="icon-circle mx-auto">
                    <img src="../images/truck.png" alt="fast truck" style="width: 60px; height:auto;">
                </div>
                <h5>Fast Delivery</h5>
                <p class="text-muted">Nationwide shipping with guaranteed protection and timely delivery.</p>
            </div>
            <div class="col-md-4">
                <div class="icon-circle mx-auto">
                    <img src="../images/Sustainable.png" alt="Sustainable" style="width: 60px; height:auto;">
                </div>
                <h5>Sustainable Design</h5>
                <p class="text-muted">Eco-friendly materials with a long-lasting lifecycle.</p>
            </div>
            <div class="col-md-4">
                <div class="icon-circle mx-auto">
                    <img src="../images/support.png" alt="Sustainable" style="width: 60px; height:auto;">
                </div>
                <h5>Customer Support</h5>
                <p class="text-muted">24/7 assistance to help you with anything from shopping to delivery.</p>
            </div>
        </div>

        <div class="container my-5">
            <h4 class="fw-bold text-center mb-4">Why Choose Furn?</h4>
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="fas fa-truck fa-2x text-success mb-2"></i>
                    <h5>Fast Delivery</h5>
                    <p>We deliver nationwide in just 2–3 days.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-thumbs-up fa-2x text-success mb-2"></i>
                    <h5>Trusted Quality</h5>
                    <p>Every item is tested for durability and comfort.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-headset fa-2x text-success mb-2"></i>
                    <h5>24/7 Support</h5>
                    <p>We're here to help anytime you need us.</p>
                </div>
            </div>
        </div>

        <div class="container text-center my-5">
            <h4>Ready to furnish your dream space?</h4>
            <a href="viewtest.php" class="btn btn-success mt-3 px-4 py-2">Start Shopping</a>
        </div>

        <div class="container my-5">
            <h4 class="fw-bold mb-4 text-center">Frequently Asked Questions</h4>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                            Do you offer free shipping?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, we offer free shipping on orders above $500.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                            Can I return a product after purchase?
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, returns are accepted within 7 days of delivery with the original packaging.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                            What payment methods do you support?
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We accept Credit Cards, KBZPay, WavePay, and Cash on Delivery.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h4>Have questions?</h4>
            <p>Contact us at <a href="mailto:support@furn.com">support@furn.com</a> or call (09) 123 456 789</p>
        </div>
    </div>

    <!-- Bootstrap JS + FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>