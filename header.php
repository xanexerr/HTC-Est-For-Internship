<!--เอาไว้ใส่ link ต่างๆจะได้ไม่ต้องก็อปวางทุกหน้า-->

<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบรวบรวมสถานประกอบการ แผนกเทคโนโลยีสารสนเทศ</title>
    <link rel="icon" href="img/logo_ithtc.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="css/custom.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0"></script>
</head>

<?php
session_start();
require 'connection.php';
echo '<div class="bg-primary">';
echo '<div class="container d-flex flex-wrap justify-content-center py-3  mx-auto border-none text-white bg-primary px-3">';
echo '<a  class="d-flex align-items-center  mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span  class="fs-4 text-white m-1 text-shadow">
        ระบบรวบรวมสถานประกอบการ
        </span></a>';
echo '<div class="rounded d-flex align-items-center mb-md-0 mx-1 link-body-emphasis text-decoration-none">';

if (isset($_SESSION['nowuser_fname']) && $_SESSION['nowuser_lname']) {
    $nowuser_fname = $_SESSION["nowuser_fname"];
    $nowuser_lname = $_SESSION["nowuser_lname"];
    echo "<span class='fs-5 bg-warning rounded p-1 px-3' style='font-size: 16px;'>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16' style='width: 1em; height: 1em; vertical-align: -0.125em;'>
            <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0'></path>
            <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1'></path>
        </svg>
        <span style='font-size: 1em;'>$nowuser_fname $nowuser_lname</span>
    </span>";
}
echo '</div>';
echo '</div>';
echo '</div>';

?>