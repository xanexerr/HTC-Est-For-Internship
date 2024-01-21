<?php
function displayLoggedInHeader($nowuser_fname, $nowuser_lname, $role, $nowwp_id)
{ ?>
    <nav class="navbar navbar-expand-sm navbar-expand-lg navbar-dark bg-dark">
        <div class="container ">
            <a class="navbar-toggler mx-3" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link btn   text-white px-3 " id="index" href="index.php">หน้าแรก</a>
                    </li>
                    <?php
                    if ($_SESSION['role'] == "admin") { ?>
                        <div class="">
                            <a href="admin-users-manage.php" id="amanage"
                                class="nav-link btn text-white px-3">ระบบจัดการบัญชีผู้ใข้</a>
                        </div>
                        <div class="">
                            <a href="admin-wp.php" id="wmanage" class="nav-link btn text-white px-3">ระบบจัดสถานประกอบการ</a>
                        </div>
                        <div class="">
                            <a href="admin-comment.php" id="cmtmanage"
                                class="nav-link btn  text-white px-3">ระบบจัดการความคิดเห็น</a>
                        </div>
                    <?php } ?>
                    <?php if ($_SESSION['role'] == "teacher") { ?>
                        <div class="">
                            <a href="teacher-wp.php" id="tmanage" class="nav-link btn text-white px-3">จัดการสถานประกอบการ</a>
                        </div>
                    <?php } ?>
                    <?php if ($_SESSION['role'] == "student") { ?>
                        <li class="">
                            <a href="std-wp-edit.php" id="std-edit"
                                class="nav-link btn  text-white  px-3">ข้อมูลสถานประกอบการของคุณ</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link btn text-white  px-3" id="profile" href="profile.php">ข้อมูลส่วนตัว</a>
                    </li>
                    <li class="">
                        <a href="about.php" id="about" class=" nav-link btn text-white  px-3">ติดต่อแอดมิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white px-3" href="logout.php">ออกจากระบบ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>
<?php function displayLoggedOutHeader()
{ ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class=" navbar-toggler mx-3" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a id="index" class="nav-link btn  text-white px-3 " href="index.php">หน้าแรก</a>
                </li>
                <li class="">
                    <a href="about.php" id="about" class=" nav-link btn text-white  px-3">ติดต่อแอดมิน</a>
                </li>
                <li class="">
                    <a href="login.php" class="nav-link p-2 px-3 btn btn-success text-white  mx-1">เข้าสู่ระบบ</a>
                </li>
            </ul>
        </div>
    </nav>
<?php } ?>
<?php
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $get_user_info = "SELECT user_id, user_fname, user_lname, workplace_id, role FROM users WHERE user_id = ?";
    $stmt_usercomment = $connection->prepare($get_user_info);
    $stmt_usercomment->bind_param("s", $user_id);
    $stmt_usercomment->execute();
    $stmt_usercomment->bind_result($nowuser_id, $nowuser_fname, $nowuser_lname, $nowwp_id, $role);
    $stmt_usercomment->fetch();
    $stmt_usercomment->close();
    $_SESSION["nowuser_fname"] = $nowuser_fname;
    $_SESSION["nowuser_lname"] = $nowuser_lname;
    displayLoggedInHeader($nowuser_fname, $nowuser_lname, $role, $nowwp_id);
} else {
    displayLoggedOutHeader();
}
?>