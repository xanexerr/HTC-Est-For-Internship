<!DOCTYPE html>
<html lang="en">

<!-- header  -->
<?php
include("header.php")
    ?>
<!-- body -->

<body>
    <?php
    include("navbar.php")
        ?>
    <?php
    require('connection.php');
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
    <!-- content -->

    <div class="container">

        <div class="d-flex justify-content-center align-items-center vh-100 ">
            <div class="g-0  overflow-hidden flex-md-row my-2  shadow border  w-50 h-md-250 position-relative bg-white">
                <p class='h4 py-2  bg-dark text-white  mb-0 text-center '>ระบบเพิ่มสมาชิก</p>
                <form class="container p-4 align-content-center " action="php/add-member.php" name="addwp"
                    method="POST">

                    <div class="form-group">
                        <label for="username">รหัสประจำตัว</label>
                        <input class="form-control" type="text" name="username" id="username" required>
                    </div>

                    <div class="form-group">
                        <label for="user_fname">ชื่อจริง</label>
                        <input class="form-control" type="text" name="user_fname" id="user_fname" required>
                    </div>

                    <div class="form-group">
                        <label for="user_lname">นามสกุล</label>
                        <input class="form-control" type="text" name="user_lname" id="user_lname" required>
                    </div>

                    <label for="user_tel" class="form-label mt-1">เบอร์โทร</label>
                    <input type="text" class="form-control" name="user_tel" required>

                    <div class="form-group">
                        <label for="user_type">ประเภทบัญชี</label>
                        <select class="form-control" name="user_type" id="user_type">
                            <option value="student">นักเรียน</option>
                            <option value="teacher">อาจารย์</option>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                                <option value="admin">ผู้ดูแลระบบ</option>
                            <?php } ?>
                        </select>
                    </div>

                    <button class="btn btn-success form-control mt-3" type="submit" name="submit" value="Submit">
                        เพิ่ม</button>

                    <a href="<?php if ($_SESSION['role'] == 'librarian') {
                        echo "librarian-users.php";
                    } elseif ($_SESSION['role'] == 'admin') {
                        echo "admin-users-manage.php";
                    } ?>" class="mt-1 btn btn-danger w-100">ยกเลิก</a>

                </form>
            </div>
        </div>
    </div>
    <?php
    include 'script.php';
    ?>

</body>

</html>


<script>
    // เลือก input element โดยใช้ ID
    const bookValueInput = document.getElementById('bookvalue');


    bookValueInput.addEventListener('change', function () {

        if (this.value < 1) {
            alert('ใส่จำนวนหนังสือให้ถูกต้อง');
            this.value = 1;
        }
    });
</script>