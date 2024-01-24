<!--เอาไว้ใส่ link ต่างๆจะได้ไม่ต้องก็อปวางทุกหน้า-->

<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบรวบรวมสถานประกอบการ แผนกเทคโนโลยีสารสนเทศ</title>
    <link rel="icon" href="img/logo_ithtc.png" type="image/x-icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">
    <script src="js/sweetalert10.16.0.js"></script>
    <script src="js/fontawesome.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mycss/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Thai:wght@400;700&display=swap" rel="stylesheet">

</head>

<?php
session_start();
require_once 'connection.php';
?>
<div class="bg-primary">
    <div class="container d-flex flex-wrap justify-content-center py-3  mx-auto border-none text-white bg-primary px-3">
        <a class="d-flex align-items-center  mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <span class="fs-4  m-1 text-shadow">
                <div class="container  ">
                    <p class="text-start  text-white mb-0">ระบบรวบรวมสถานประกอบการ</p>
                </div>
            </span></a>
        <div class="rounded d-flex align-items-center mb-md-0 mx-1 link-body-emphasis text-decoration-none">
            <?php if (isset($_SESSION['nowuser_fname']) && $_SESSION['nowuser_lname']) { ?>
                <span class='fs-5 bg-warning rounded p-1 px-3' style='font-size: 16px;'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                        class='bi bi-person-circle' viewBox='0 0 16 16'
                        style='width: 1em; height: 1em; vertical-align: -0.125em;'>
                        <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0'></path>
                        <path fill-rule='evenodd'
                            d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1'>
                        </path>
                    </svg>
                    <span class="ms-1" style='font-size: 1em;'>
                        <?php echo $_SESSION['nowuser_fname'] . $_SESSION['nowuser_lname'] ?>
                    </span>
                <?php } ?>
            </span>
        </div>
    </div>
</div>