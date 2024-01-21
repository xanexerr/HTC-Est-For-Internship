<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "tryproject2";

// mysql connection ธรรมดา
$connection = new mysqli($server, $username, $password, $database);
if ($connection->connect_error) {
    echo "Connection Failed!";
    die("Connection failed: " . $connection->connect_error);
} else {
}
// pdo connection
try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
