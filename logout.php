<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    header("Location: 2login.php");
    exit;
?>
