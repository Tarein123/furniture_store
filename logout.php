<?php
if(!$_SESSION)
{
    session_start();
}

session_destroy();

header("Location:user/index1.php");


?>