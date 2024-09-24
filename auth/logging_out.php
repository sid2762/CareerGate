<?php
session_start(); 

if (isset($_SESSION['admin-logged-in']) || $_SESSION['admin-logged-in'] == true) {
    session_unset();
    session_destroy();

    header("Location: ../admin_login.php");
    exit(); 
}

session_unset();
session_destroy();

header("Location: ../login.php");
exit();
?>
