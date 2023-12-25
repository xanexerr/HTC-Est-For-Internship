<!--เอาไว้ใส่ link ต่างๆจะได้ไม่ต้องก็อปวางทุกหน้า-->

<head>
    <link rel="icon" href="img/logo_ithtc.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="css/custom.css" rel="stylesheet">
</head>

<?php
// import 
session_start();
require 'connection.php';
echo '<div class="bg-primary">';
echo '<div class="d-flex flex-wrap justify-content-center py-3  mx-5 border-bottom text-white bg-primary px-3">';
echo '<a  class="d-flex align-items-center  mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span  class="fs-4 text-white m-1 text-shadow">
        ระบบรวบรวมสถานประกอบการ
        </span></a>';
echo '<div class="rounded d-flex align-items-center mb-md-0 mx-1 link-body-emphasis text-decoration-none">';

// ถ้าเจอ ตัวแปร nowuser_fname และ nowuser_lname  ให้แสดงชื่อบนแถบฟ้า
if (isset($_SESSION['nowuser_fname']) && $_SESSION['nowuser_lname']) {
    $nowuser_fname = $_SESSION["nowuser_fname"];
    $nowuser_lname = $_SESSION["nowuser_lname"];
    echo "<span class='fs-5 px-3 bg-warning rounded p-1 '>$nowuser_fname $nowuser_lname</span>";
}
echo '</div>';
echo '</div>';
echo '</div>';

?>