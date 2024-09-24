<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "phpmyadmin", "893305", "placementDriver");

if (!$conn) {
    die("Couldn't connect to database due to".mysqli_connect_error());
}
?>