<?php


$hasscode = password_hash("Abc123!@#", PASSWORD_BCRYPT);
echo $hasscode;
echo "<br>".strlen($hasscode);


?>