<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    setcookie('user_id', '', time() - 3600, '/');
    setcookie('username', '', time() - 3600, '/');
    header("Location: login.php");
    exit;
?>