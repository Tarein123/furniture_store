<?php
if(!$_SESSION)
{
    session_start();
}

session_destroy();

header("Location:index1.php");


?>