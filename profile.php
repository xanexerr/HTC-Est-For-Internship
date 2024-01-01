<!DOCTYPE html>
<html lang="en">

<!-- header  -->
<?php
include 'header.php';
?>

<!-- body -->

<body>
    <!-- top banner  -->
    <?php
    include("navbar.php");
    ?>


    <!-- content -->

    <div class="container d-flex justify-content-center align-items-center p-3 my-4 min-vh-100">

        <?php
        // Check if the user is logged in
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];

            $get_user = "SELECT * FROM users WHERE user_id = ?";
            $stmt_user = $connection->prepare($get_user);
            $stmt_user->bind_param("s", $user_id);
            $stmt_user->execute();
            $result = $stmt_user->get_result();
            // Fetch workplace data
            $row = $result->fetch_assoc();


            $user_fname = $row['user_fname'];
            $user_lname = $row['user_lname'];
            $user_tel = $row['user_tel'];
            $password = $row['password'];

            echo '<div class="container d-flex justify-content-center align-items-center p-3 " style="min-height: 85vh; ">
            <div style="width: 768px;  shadow p-4">';
            echo ' <p class="h4 py-2 px-auto bg-dark border text-white mb-0 text-center">ข้อมูลส่วนตัว </p>';
            echo '<form onsubmit="return validatePassword()" class="border shadow  p-4" name="edit_name" method="POST"
                    action="php/update-user-data.php" enctype="multipart/form-data">';
            echo '   <label for="work_type" class="form-label ">รหัสนักเรียน </label>';
            echo '<input type="text" disabled class="form-control" name="user_id" value="' . $user_id . '"required>';
            echo '  <label for="work_type" class="form-label mt-3">ชื่อจริง</label>';
            echo '  <input type="text" class="form-control" name="user_fname" value="' . $user_fname . '"required>';
            echo '<label for="work_type" class="form-label mt-3">นามสกุล</label>';
            echo '<input type="text" class="form-control" name="user_lname" value="' . $user_lname . '"required>';
            echo '   <label for="work_type" class="form-label mt-3">รหัสผ่าน</label>';
            echo ' <input type="password" class="form-control" name="password" id="password" value="' . $password . '"required>';
            echo ' <label for="work_type" class="form-label mt-3">ยืนยันรหัสผ่าน</label>';
            echo '<input type="password" class="form-control" name="password" id="conpassword" value="' . $password . '"required>';
            echo '<div class="align-items-center pt-2 ml-3">';
            echo '<input type="checkbox" class="form-check-input" id="showPassword" onclick="showPass()">';
            echo ' <label class="form-check-label " for="showPassword">แสดงรหัสผ่าน</label>';
            echo ' </div>';
            echo '<button type="submit" value="submit" class="mt-3 btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>';
            echo '  <a href="index.php" class="mt-1 btn btn-danger w-100">ยกเลิก</a>';
            echo '</form>';
            echo '</div>';
            echo ' </div>';
        } else {
            echo '<script>';
            echo 'alert("คุณยังไม่ได้เข้าสู่ระบบ");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
        }

        ?>
    </div>

    <!-- footer  -->
    <?php
    if (isset($_SESSION["user_id"])) {

    } else {

        echo '</nav>';
    }
    ?>
    <script>
        function showPass() {
            var password = document.getElementById("password");
            var conpassword = document.getElementById("conpassword");

            if (password.type === "password") {
                password.type = "text";
                conpassword.type = "text";
            } else {
                password.type = "password";
                conpassword.type = "password";
            }
        }

        function validatePassword() {
            var password = document.getElementById("password").value;
            var conpassword = document.getElementById("conpassword").value;

            if (password !== conpassword) {
                alert("กรุณาใส่รหัสผ่านให้ตรงกัน");
                return false; // ยกเลิกการ submit ฟอร์ม
            }
            return true; // สามารถ submit ฟอร์มได้
        }
        <?php
        include 'script.php';
        ?>
</body >

</html >