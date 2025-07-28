<?php

require_once "db.php";
function noUser()
{
    global $conn;
    $sql = "select count(*) as count from users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['count'];
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 card shadow-sm border-0 rounded-4 h-100 py-3 px-3">
                <?php $user = noUser();
                echo "<div class='card-title'>$user </div>";  ?>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>


        </div>

    </div>

</body>

</html>