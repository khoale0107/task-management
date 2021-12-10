<?php
    session_start();
    //if no session -> to login
    if (!isset($_SESSION['user'])) {
        header('Location:login.php');
        die();
    }
?>