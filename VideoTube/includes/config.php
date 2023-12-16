<?php
ob_start(); //Turns on output buffering 
session_start();

date_default_timezone_set("Europe/Prague");

try {
    $con = new PDO("mysql:dbname=VideoTube;host=172.26.240.1", "newuser", "yes");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>