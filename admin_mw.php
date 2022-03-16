<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    if($_SESSION["user"]["role"] != "admin"){
        $_SESSION["message"] = "Nemate dozvolu pristupa ovom sajtu";
        header("location:home.php");
    }
?>