<?php
// Database credentials
$host = "localhost";
$dbname = "php";
$username = "root";
$password = "";


    $con = "mysql:host=$host;dbname=$dbname;charset=utf8";
    // set the PDO error mode to exception
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
$db = new PDO ($con, $username, $password, $options);
?>
