<?php
    require_once 'check-session.php';

    //clear remembered username cookie when logged in with a different account
    if (isset($_COOKIE['username'])) {
        if ($_COOKIE['username'] !== $_SESSION['user']) {
            setcookie('username', null, -1, '/'); 
        }
    }

    session_unset();
    session_destroy();

    header('Location:login.php');
?>