<!DOCTYPE html>
<html>


<?php include("header.php"); ?>

<body>
    <?php include("navbar.php"); ?>
    <div class="container d-flex justify-content-center align-items-center p-5">

        <?php
        require 'connection.php';
        // Check if the user is logged in
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $get_user_info = "SELECT user_id, user_fname, user_lname FROM users WHERE user_id = ?";
            $stmt_usercomment = $connection->prepare($get_user_info);
            $stmt_usercomment->bind_param("s", $user_id);
            $stmt_usercomment->execute();
            $stmt_usercomment->bind_result($nowuser_id, $nowuser_fname, $nowuser_lname);
            $stmt_usercomment->fetch();
            $stmt_usercomment->close();

            $_SESSION["nowuser_fname"] = $nowuser_fname;
            $_SESSION["nowuser_lname"] = $nowuser_lname;



            echo '<div class="border shadow w-50 rounded-3 " style="min-width: 450px;">';
            echo '<div class="d-grid gap-2">';
            echo '<div class="text-center">';
            echo '<p class="h3 py-3 bg-dark border text-white  mb-0 text-center  rounded-top">เข้าสู่ระบบอยู่แล้ว!!</p>
                    <div class="p-4">';

            echo "<h4 class='ml-3 pt-3'>รหัสนักศึกษา</h4><br>";
            echo "<h5 class='text-primary'>$nowuser_id</h5><br>";

            echo "<h4 class='ml-3'>ชื่อผู้ใช้ </h4><br>";
            echo "<h5 class='text-primary'>$nowuser_fname $nowuser_lname</h5><br>";

            echo '<div class="mt-3">';
            echo '<a href="index.php" class="btn btn-primary btn-lg d-grid gap-2 mx-auto w-100 rounded-3">กลับหน้าแรก</a>';
            echo '<a href="logout.php" class="btn btn-danger btn-lg d-grid gap-2 mx-auto w-100 rounded-3 mt-1">ออกจากระบบ</a>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '

                <form class="border shadow rounded" style="min-width: 450px; width:768px;" name="form1" method="post" action="check_login.php">
                    <p class="h4 py-2  bg-dark border text-white  mb-0 text-center  rounded-top">เข้าสู่ระบบ</p>
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
                        <button type="submit" class="btn btn-success btn-lg d-grid gap-2">เข้าสู่ระบบ</button>
                    </div>
                    <div class="d-grid gap-1 pt-1">
                   <!-- <a href="#" class="btn  btn-warning btn-lg d-grid ">ลงทะเบียน</a> -->
                        <a href="index.php" class="btn btn-danger btn-lg d-grid ">ยกเลิก</a>
                    </div>
                    </div>
                </form>
            ';
        }
        ?>
    </div>
    <?php
    include 'script.php';
    ?>
</body>

</html>