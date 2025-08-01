<?php
$server = "localhost";
$user = "root";
$password = "";
$database = "furniture_store";
$dsn = "mysql:host=$server; dbname=$database";
try {

    $conn = new PDO($dsn, $user, $password);
    // to show exception messages
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // to accesss table row in object style
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //echo "connection established";

} catch (PDOException $e) {
    echo $e->getMessage();
}
