<?php
session_start();
require 'connection.php';

$user_id = $connection->real_escape_string($_POST['username']);
$password = $connection->real_escape_string($_POST['password']);

$strSQL = "SELECT * FROM users WHERE user_id = '$user_id' AND password = '$password'";
$result = $connection->query($strSQL);

if (!$result || $result->num_rows === 0) {
    echo '<script>alert("เกิดข้อผิดพลาด! กรุณากรอกใหม่อีกครั้ง");</script>';
    echo '<script>window.location.href = "login.php";</script>';
    exit;
} else {

    $objResult = $result->fetch_assoc();
    $_SESSION["user_id"] = $objResult["user_id"];
    $_SESSION["role"] = $objResult["role"];
    session_write_close();
    // echo '<script>window.history.go(-2);</script>';
    header("location: index.php");
}

$connection->close();
?>