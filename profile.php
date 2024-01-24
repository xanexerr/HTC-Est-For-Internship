<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<body>
    <?php
    require('connection.php');
    include('navbar.php');

    $session_userid = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :session_userid");
    $stmt->bindParam(':session_userid', $session_userid, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the user data
    $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="flex-container vh-100">
        <div class="container">
            <div class="my-3 bg-body shadow mx-auto col-sm-10 col-lg-6 col-md-10 ">
                <div class=" justify-content-center">
                    <p class='h4 py-2 px-auto bg-dark text-white mb-0 text-center '>
                        แก้ไขข้อมูลส่วนตัว </p>
                    <?php foreach ($userData as $row): ?>

                        <form class="border p-3 " name="edit_workplace_form" method="POST" action="php/profileupdate.php"
                            enctype="multipart/form-data">

                            <label for="user_id" class="form-label">รหัสผู้ใช้</label>
                            <input type="text" class="form-control text-danger" name="user_id"
                                value="<?= $row['user_id']; ?>" readonly>

                            <label for="user_fname" class="form-label mt-1">ชื่อ</label>
                            <input type="text" class="form-control" name="user_fname" value="<?= $row['user_fname']; ?>"
                                required>

                            <label for="user_lname" class="form-label mt-1">นามสกุล</label>
                            <input type="text" class="form-control" name="user_lname" value="<?= $row['user_lname']; ?>"
                                required>

                            <label for="user_tel" class="form-label mt-1">เบอร์โทร</label>
                            <input type="text" class="form-control" name="user_tel" value="<?= $row['user_tel']; ?>"
                                required>

                            <label for="password" class="form-label mt-1">รหัสผ่าน</label>
                            <div class="d-flex align-items-center">
                                <input type="password" class="form-control " name="password" id="passwordField"
                                    value="<?= $row['password']; ?>" required>
                                <a class="btn btn-outline-secondary rounded col-2" type="button" id="showPasswordBtn"></a>
                            </div>

                            <button type="submit" value="submit"
                                class="mt-3 btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>
                            <a href="
                            <?php if ($_SESSION['role'] == 'admin ') {
                                echo 'admin-users-manage.php';
                            } else {
                                echo 'index.php';
                            } ?>" class="mt-1 btn btn-secondary w-100">ยกเลิก</a>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'script.php'; ?>
    <script>
        addClassToElement("profile");
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordField = document.getElementById('passwordField');
            const showPasswordBtn = document.getElementById('showPasswordBtn');

            updateButtonText(); // Set initial text content

            showPasswordBtn.addEventListener('click', function () {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                updateButtonText(); // Update text content on button click
            });

            function updateButtonText() {
                if (passwordField.getAttribute('type') === 'password') {
                    showPasswordBtn.textContent = 'แสดง'; // Display
                } else {
                    showPasswordBtn.textContent = 'ซ่อน'; // Hide
                }
            }
        });
    </script>
</body>

</html>