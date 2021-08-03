<?php
    $link = mysqli_connect('localhost', 'root', '');
    if(!$link){
        die('Failed to connect to server: ' . mysqli_error($link));
    }
    $db = mysqli_select_db($link, 'bookstore');
    if(!$db){
        die("Unable to select database");
    }
?>
