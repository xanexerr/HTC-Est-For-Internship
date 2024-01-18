<!DOCTYPE html>
<html lang="en">
<?php
include("header.php");
?>


<body>
    <?php
    include("navbar.php");
    if (!isset($_SESSION["user_id"])) {
        echo '<script>';
        echo 'Swal.fire({
        title: "คุณยังไม่ได้เข้าสู่ระบบ",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "login.php";
            }
        });';
        echo '</script>';

        exit();
    } else {
        if ($_SESSION["role"] !== 'admin' && $_SESSION["role"] !== 'teacher') {
            echo '<script>';
            echo 'Swal.fire({
        title: "คุณไม่มีสิทธิเข้าถึง!",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php";
            }
        });';
            echo '</script>';
            exit();
        }
    }
    ?>
    <div class="container  shadow border p-0 col-8 my-2 rounded ">
        <p class='h4 py-2  bg-dark border text-white  mb-0 text-center  rounded-top'>เพิ่มสถานประกอบการ </p>
        <div class="">
            <form class="container p-4 align-content-center " action="php/teacher-add-wp.php" name="addwp"
                method="POST">
                <input class="form-control no-arrow" type="hidden" name="user_id" id="user_id" required
                    value="<?php echo $_SESSION["user_id"]; ?>">
                <div class=" form-group">
                    <label for="wp_name">ชื่อสถานประกอบการ</label>
                    <input class="form-control" type="text" name="wp_name" id="wp_name" required>
                </div>

                <div class="">
                    <label for="wp_name">ประเภทงาน</label>
                    <select class="form-control" name="work_type">
                        <option value="เขียนโปรแกรม">เขียนโปรแกรม</option>';
                        <option value="ทำกราฟิก">ทำกราฟิก</option>';
                        <option value="ระบบเครือข่าย">ระบบเครือข่าย</option>';
                        <option value="ทำเว็บไซต์">ทำเว็บไซต์</option>';
                        <option value="ด้านบริการ">ด้านบริการ</option>';
                        <option value="อื่นๆ">อื่นๆ</option>';
                    </select>
                </div>
                <div class=" ">
                    <label for="wp_tel">เบอร์โทร</label>
                    <input class="form-control no-arrow" type="number" name="wp_tel" id="wp_tel" required>
                </div>

                <div class="form-group">
                    <label for="wp_des">ลักษณะงาน</label>
                    <input class="form-control" type="text" name="wp_des" id="wp_des">
                </div>

                <div class="form-group">
                    <label for="wp_address">ที่อยู่</label>
                    <textarea class="form-control" name="wp_address" id="wp_address" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="map">แผนที่</label>
                    <input type="text" class="form-control" name="map" id="map" rows="4" placeholder="google map link">
                </div>
                <button class="btn btn-success form-control mt-3" type="submit" name="submit" value="Submit">
                    บันทึก</button>
                <a href="teacher-wp.php" class="mt-1 btn btn-danger w-100">ยกเลิก</a>
            </form>

        </div>
    </div>
    <?php include("script.php"); ?>
</body>

</html>