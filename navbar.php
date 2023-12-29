<?php
// import 
function displayLoggedInHeader($nowuser_fname, $nowuser_lname, $role, $nowwp_id)
{
    // Navbar
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">';
    echo '<div class="container">';
    echo '<a class="navbar-toggler mx-3" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<span class="navbar-toggler-icon"></span>';
    echo '</a>';
    echo '<div class="collapse navbar-collapse" id="navbarNav">';
    echo '<ul class="navbar-nav mx-auto">';
    echo '<li class="nav-item">';
    echo '<a class="nav-link btn btn-primary  text-white px-3 " href="index.php">หน้าแรก</a>';
    echo '</li>';
    if ($_SESSION['role'] == "admin") {
        echo '<div class="">
            <a href="#" class="nav-link btn btn-primary text-white px-3">ระบบจัดการบัญชีผู้ใข้</a>
            </div>';
        echo '<div class="">
            <a href="#" class="nav-link btn btn-primary text-white px-3">ระบบจัดการความคิดเห็น</a>
            </div>';
        echo '<div class="">
            <a href="admin-wp.php" class="nav-link btn btn-primary text-white px-3" id="admin-wp">ระบบจัดสถานประกอบการ</a>
            </div>';
    }

    if ($_SESSION['role'] == "teacher") {
        echo '<div class="">
            <a href="#" class="nav-link btn btn-primary text-white px-3">เพิ่มสถานประกอบการ</a>
            </div>';
    }

    if ($_SESSION['role'] == "student") {
        echo '<li class="">';
        if ($nowwp_id !== null) {
            echo '<a href="std-wp-edit.php" class="nav-link btn btn-primary text-white  px-3">แก้ข้อมูลสถานประกอบการ</a>';
        } else {
            echo '<a href="std-wp-edit.php" class="nav-link btn btn-primary text-white  px-3">เพิ่มข้อมูลสถานประกอบการ</a>';
        }
        echo '</li>';
    }

    echo '<li class="nav-item">';
    echo '<a class="nav-link btn btn-primary text-white  px-3" href="profile.php">ข้อมูลส่วนตัว</a>';
    echo '</li>';
    echo '<li class="">
        <a href="about.php" class=" nav-link btn btn-primary text-white  px-3">ติดต่อแอดมิน</a>
        </li>';
    echo '<li class="nav-item">';
    echo '<a class="nav-link btn btn-danger text-white px-3" href="logout.php">ออกจากระบบ</a>';
    echo '</li>';



    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</nav>';

}
function displayLoggedOutHeader()
{
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">';
    echo '<a class=" navbar-toggler mx-3" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<span class="navbar-toggler-icon"></span>';
    echo '</a>';
    echo '<div class="collapse navbar-collapse" id="navbarNav">';
    echo '<ul class="navbar-nav mx-auto">';
    echo '<li class="nav-item">';
    echo '<a class="nav-link btn btn-primary text-white px-3 " href="index.php">หน้าแรก</a>';
    echo '</li>';

    echo '<li class="">
        <a href="about.php" class=" nav-link btn btn-primary text-white  px-3">ติดต่อแอดมิน</a>
        </li>';

    echo '<li class="">
        <a href="login.php" class="nav-link p-2 px-3 btn btn-success text-white  mx-1">เข้าสู่ระบบ</a>
        </li>';

    echo '</ul>';
    echo '</div>';
    echo '</nav>';

}
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    // Fetch the user's information
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