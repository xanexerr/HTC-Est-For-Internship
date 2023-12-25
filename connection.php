<?php
// teacher database

// $server = "49.229.102.185";
// $username = "64209010006";
// $password = "64209010006";
// $database = "db_Est";

// localhost database

$server = "localhost";
$username = "root";
$password = "";
$database = "tryproject2";

$connection = new mysqli($server, $username, $password, $database);
// $connection = new mysqli("49.229.102.185", "64209010006", "64209010006", "db_Est");

if ($connection->connect_error) {
    echo "Connection Failed!";
    die("Connection failed: " . $connection->connect_error);
} else {
}


try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optionally, set charset to UTF-8 (if needed)
    $conn->exec("SET NAMES utf8");
} catch (PDOException $e) {
    // Display error message if connection fails
    echo "Connection failed: " . $e->getMessage();
}


?>