<!DOCTYPE html>
<html>

<head>

    <title>เว็บรวบรวมสถานประกอบการ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="text-center bg-primary text-white"">
        <h4 class=" text-center p-3">ระบบสารสนเทศสถานประกอบการ วิทยาลัยเทคนิคหาดใหญ่</h4>
    </div>

    <?php
    session_start();
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

        echo '<div class="container d-flex justify-content-center align-items-center" style=" min-height: 85dvh;">';

        echo '<div class="border shadow w-50 rounded-3 p-3" style="min-width: 450px;">';
        echo '<div class="d-grid gap-2">';
        echo '<div class="text-center">';
        echo '<h4 class="bg-primary p-3 text-white rounded-3">คุณเข้าสู่ระบบอยู่แล้ว!</h4>';

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
                <div class="container d-flex justify-content-center align-items-center p-3" style="min-height: 85vh; ">
                <form class="border shadow p-3 my-4" style="min-width: 450px;" name="form1" method="post" action="check_login.php">
                    <h1 class="text-center p-3">เข้าสู่ระบบ</h1>
                    <div class="mb-3">
                        <label for="username" class="form-label">ชื่อบัญชีผู้ใช้</label>
        
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
        
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
        
                    <div class="d-grid gap-2 p-3">
                        <button type="submit" class="btn btn-success btn-lg d-grid gap-2">เข้าสู่ระบบ</button>
                    </div>
                </form>
            </div>
            ';
    }
    ?>


</body>

</html>