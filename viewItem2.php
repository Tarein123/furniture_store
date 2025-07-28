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
    $sql = "select i.item_id, i.iname,
		i.price, i.description,
        i.quantity, i.img_path,
        c.cname as category
        from item i, category c 
        where i.category = c.cid";

    $stmt = $conn->query($sql);
    $items = $stmt->fetchAll();
    //print_r($items);

} catch (PDOException $e) {
    echo $e->getMessage();
}


if (isset($_GET['cate'])) {
    $cid = $_GET['cateChoose'];
    try {
        //
        $sql = "select i.item_id, i.iname,
            i.price, i.description,
            i.quantity, i.img_path,
            c.cname as category
            from item i, category c 
            where i.category = c.cid
            and  c.cid=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$cid]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} // end if of category selection

if (isset($_GET['priceRadio'])) {
    $range = $_GET['priceRange'];
    $sql = "select i.item_id, i.iname,
            i.price, i.description,
            i.quantity, i.img_path,
            c.cname as category
            from item i, category c 
            where i.category = c.cid
            and  i.price between ? and ?";
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
    $items = $stmt->fetchAll();
}
if (isset($_GET['bSearch'])) {
    $keyword =  $_GET['wSearch'];
    try {
        $sql = "select * from item where iname like ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%" . $keyword . "%"]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$_SESSION['items'] = $items;


?>
<?php if (isset($_SESSION['adminId']) && isset($_SESSION['login'])) { ?>
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
    <!-- 

-->

    <body class="bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php require_once "navbar.php" ?>
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
                                    echo "<option value=$category[cid]> $category[cname] </option>";
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
                    <div class="py-2"> <a class="btn btn-outline-primary" href="insertItem.php">Add New Item</a></div>

                    <?php
                    if (isset($_SESSION['insertSuccess'])) {
                        echo "<p class='alert alert-success'> $_SESSION[insertSuccess] </p>";
                        unset($_SESSION['insertSuccess']);
                    } else   if (isset($_SESSION['updateSuccess'])) {
                        echo "<p class='alert alert-success'> $_SESSION[updateSuccess] </p>";
                        unset($_SESSION['updateSuccess']);
                    } else   if (isset($_SESSION['deleteSuccess'])) {
                        echo "<p class='alert alert-success'> $_SESSION[deleteSuccess] </p>";
                        unset($_SESSION['deleteSuccess']);
                    }



                    ?>



                    <?php
                    if (isset($items)) {
                        echo "<div class='row'>";
                        foreach ($items as $item) {
                            $_SESSION['item'] = $item;
                            echo "<div class='col-md-3 mb-4'>
                                <div class='card shadow-sm border-0 rounded-4 h-100'>
                                <div class='card-title fw-bold'>$item[iname]</div>
                                <div class='card-body'>$item[price]</div>
                              
                                <div>$item[category]</div>
                                <div>$item[quantity]</div>
                                <div><img class=card-img-top rounded-top-4 src=$item[img_path] style=width:80px; height:80px></div>
                                <div><a class='btn btn-outline-primary rounded-pill'   href=detailItem2.php?detailId=$item[item_id]>Detail</a> 
                                 <a class='btn btn-outline-danger rounded-pill'   href=addcartItem.php?did=$item[item_id]>Add to cart</a> </div>
                                </div></div>";
                        }
                        echo "</div>";
                    }

                    ?>

                </div>

            </div>
        </div>
    </body>

    </html>
<?php } else {
    header("Location:login.php");
} ?>