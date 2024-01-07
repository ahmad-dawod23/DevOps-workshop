<?php
ob_start(); //Turns on output buffering 
session_start();

date_default_timezone_set("Europe/Prague");


    $db_host = getenv('MYSQL_HOST', true) ?: getenv('MYSQL_HOST');
    $db_name = getenv('MYSQL_DATABASE', true) ?: getenv('MYSQL_DATABASE');
    $db_user = getenv('MYSQL_USER', true) ?: getenv('MYSQL_USER');
    $db_pwd  = getenv('MYSQL_PASSWORD', true) ?: getenv('MYSQL_PASSWORD');


try {
	$string="mysql:dbname={$db_name};host={$db_host}";
    $con = new PDO($string, $db_user, $db_pwd);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>