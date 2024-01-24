<!DOCTYPE html>
<html>


<?php include("header.php"); ?>

<body>
    <?php include("navbar.php"); ?>
    <div class="flex-container vh-100">
        <div class="container d-flex col-12 justify-content-center my-5 ">
            <div class="d-flex justify-content-center  col-10  ">
                <?php
                require 'connection.php';
                if (isset($_SESSION["user_id"])) {
                    echo "<script>";
                    echo "Swal.fire('คุณได้เข้าสู่ระบบแล้ว!', '', 'success').then(function() {
                    window.location.href = 'index.php';
                });";
                    echo "</script>";
                } else { ?>
                    <form class="border shadow rounded col-6 bg-white" name="form1" method="post" action="check_login.php">
                        <p class="h4 py-2  bg-dark  text-white  mb-0 text-center  rounded-top">เข้าสู่ระบบ</p>
                        <img src="img/login_banner.png" alt="login" class="w-100">
                        <div class="p-4">
                            <div class="mb-3">
                                <p class="h5 m-1">ชื่อบัญชีผู้ใช้</p>
                                <input type="text" class="form-control" name="username" id="username" required>
                            </div>
                            <div class="mb-3">
                                <p class="h5 m-1">รหัสผ่าน</p>

                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>

                            <div class="d-grid gap-2 pt-3">
                                <button type="submit" class="btn btn-success btn d-grid gap-2">เข้าสู่ระบบ</button>
                            </div>
                            <div class="d-grid gap-1 pt-1">
                                <!-- <a href="#" class="btn  btn-warning btn-lg d-grid ">ลงทะเบียน</a> -->
                                <a href="index.php" class="btn btn-danger btn d-grid ">ยกเลิก</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include 'script.php';
                } ?>
    <script>
        addClassToElement("login");
    </script>
</body>

</html>