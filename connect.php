<?php
session_start();

$user = "root";
$password = "";
$host = "localhost";
$port = 3307;
$dbname = "dbchuaf3";
    
$mysqli = new mysqli($host, $user, $password, $dbname, $port);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>