<!DOCTYPE html>
<html lang="en">
<?php
include("header.php");
?>


<body>
    <?php
    include("navbar.php");
    ?>
    <div class="container  shadow border my-2">

        <form class="container p-3 align-content-center" action="php/admin-add-wp.php" name="addwp" method="POST">

            <div class="form-group">
                <label for="wp_name">ชื่อสถานประกอบการ</label>
                <input class="form-control" type="text" name="wp_name" id="wp_name" required>
            </div>

            <div class="form-row align-items-center">
                <div class="col-md-6 mb-3">
                    <!-- <label for="work_type">ประเภทงาน</label> -->
                    <select class="form-control" name="work_type" id="work_type" required>
                        <option value="เขียนโปรแกรม">เขียนโปรแกรม</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <!-- <label for="wp_tel">เบอร์โทร</label> -->
                    <input class="form-control" type="text" name="wp_tel" id="wp_tel" required>
                </div>
            </div>

            <div class="form-group">
                <label for="wp_des">ลักษณะงาน</label>
                <input class="form-control" type="text" name="wp_des" id="wp_des">
            </div>

            <div class="form-group">
                <label for="wp_address">ที่อยู่</label>
                <textarea class="form-control" name="wp_address" id="wp_address" rows="4"></textarea>
            </div>

            <input class="btn btn-success form-control" type="submit" name="submit" value="Submit">
        </form>

    </div>

    <?php include("script.php"); ?>
</body>

</html>