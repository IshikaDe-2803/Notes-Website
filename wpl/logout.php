<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["password"]);
$message = "User logged out successfully!";
echo  
        "<script>alert('$message');
        window.location.href='/wpl/home.php';
        </script>";
?>