<?php
    require_once 'check-session.php';   


    if (password_verify($_SESSION['user'], $_SESSION['hashed-password'])) {
        header('Location:reset-password-required.php');
    }
?>