<?php
    session_start();
    if(isset($_COOKIE['id'])){
        $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['name'] = $_COOKIE['name'];
    }
    if(!isset($_SESSION['id'])){
        header("Location: login.php");
    }

?>