<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_GET['detailId'])) {

    $product = $_SESSION['product'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail View</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-title">
                        <?php echo "$product[product_name]"; ?>

                    </div>
                    <div class="card-body">
                        <?php echo "<p>" . $product['price'] . "</p>"; ?>
                        <?php echo "<p class='text-wrap'>" . $product['description'] . "</p>"; ?>
                        <?php echo "<img src=$product[img_path] >";  ?>
                        ?>

                    </div>

                </div>

            </div>
        </div>



    </div>




</body>

</html>