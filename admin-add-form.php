<!DOCTYPE html>
<html lang="en">
<?php
include("header.php");
?>


<body>
    <?php
    include("navbar.php");
    ?>
    <div class="container  shadow border p-0 col-8 my-2 rounded ">
        <p class='h4 py-2  bg-dark border text-white  mb-0 text-center  rounded-top'>เพิ่มสถานประกอบการ </p>
        <div class="">
            <form class="container p-4 align-content-center " action="php/admin-add-wp.php" name="addwp" method="POST">

                <div class="form-group">
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
                    <textarea class="form-control" name="wp_address" id="wp_address" rows="4"></textarea>
                </div>

                <button class="btn btn-success form-control mt-3" type="submit" name="submit" value="Submit">
                    บันทึก</button>
                <a href="admin-wp.php" class="mt-1 btn btn-danger w-100">ยกเลิก</a>
            </form>

        </div>
    </div>
    <?php include("script.php"); ?>
</body>

</html>