<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $_SESSION["user"]["id"] = null;
    $_SESSION["user"]["username"] = null;
    $_SESSION["user"]["role"] = null;
    header("location: home.php");
?>