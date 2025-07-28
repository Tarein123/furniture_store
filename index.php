<?php
require_once "db.php";

$sql = "select * from item";
$stmt = $conn->query($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
foreach ($rows as $data) {
    echo $data['product_name'];
    echo $data['price'];
    echo "<img src=$data[img_path]>";
}
