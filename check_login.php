<?php
include 'header.php';
require 'connection.php';

$user_id = $connection->real_escape_string($_POST['username']);
$password = $connection->real_escape_string($_POST['password']);

$strSQL = "SELECT * FROM users WHERE user_id = '$user_id' AND password = '$password'";
$result = $connection->query($strSQL);

if (!$result || $result->num_rows === 0) {
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "เกิดข้อผิดพลาด!",
            text: "กรุณากรอกใหม่อีกครั้ง",
        }).then(function() {
            window.location.href = "login.php";
        });
    </script>';
    exit;
} else {
    $objResult = $result->fetch_assoc();
    $_SESSION["user_id"] = $objResult["user_id"];
    $_SESSION["role"] = $objResult["role"];
    $_SESSION["nowuser_fname"] = $objResult["user_fname"];
    $_SESSION["nowuser_lname"] = $objResult["user_lname"];
    session_write_close();
    echo '<script>window.location.href = "index.php";</script>';


}
$connection->close();
?>