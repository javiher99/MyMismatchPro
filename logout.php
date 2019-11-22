<?php
    require_once('Func.php');
    unset($_SESSION);
    session_destroy();
    Func::deleteCookie();
    header("location: index.php");
?>