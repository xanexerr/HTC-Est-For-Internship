<!DOCTYPE html>
<html lang="en">

<!-- header  -->

<?php
include("header.php");
?>

<head>

</head>
<!-- body -->

<body>
    <!-- top banner  -->
    <?php
    require('connection.php');
    include('navbar.php');
    include('php/admin-check.php');

    $user_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users ");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM users WHERE `user_id` =  '$user_id' ");
    $stmt->execute();
    $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <!-- content -->

    <div class="flex-container vh-100">
        <div class="container  px-0 border   shadow  my-3 col-md-10 bg-white">
            <p class='h4 py-2  bg-dark border text-white  mb-0 text-center  '>รายละเอียด </p>
            <div class="">
                <div class="">
                    <?php foreach ($userData as $row): ?>
                        <form class="border p-3" name="edit_workplace_form" method="POST" action="php/update-users.php"
                            enctype="multipart/form-data">
                            <label for="user_id" class="form-label">รหัสผู้ใช้</label>
                            <input type="hidden" class="form-control text-danger" name="old_user_id"
                                value="<?php echo $row['user_id']; ?>">
                            <input type="text" class="form-control text-danger" name="user_id"
                                value="<?php echo $row['user_id']; ?>">

                            <label for="user_fname" class="form-label mt-1">นามสกุล</label>
                            <input type="text" class="form-control" name="user_fname"
                                value="<?php echo $row['user_fname']; ?>" required>

                            <label for="user_lname" class="form-label mt-1">นามสกุล</label>
                            <input type="text" class="form-control" name="user_lname"
                                value="<?php echo $row['user_lname']; ?>" required>

                            <label for="role" class="form-label mt-1">สถานะ</label>
                            <select class="form-control" name="role" required>
                                <option value="admin" <?php if ($row['role'] == 'admin') {
                                    echo 'selected';
                                } ?>>ผู้ดูแลระบบ</option>
                                <option value="teacher" <?php if ($row['role'] == 'teacher') {
                                    echo 'selected';
                                } ?>>อาจารย์</option>
                                <option value="student" <?php if ($row['role'] == 'student') {
                                    echo 'selected';
                                } ?>>นักเรียน</option>
                            </select>

                            <label for="user_lname" class="form-label mt-1">รหัสผ่าน</label>
                            <input type="password" class="form-control" name="password"
                                value="<?php echo $row['password']; ?>" required>

                            <button type="submit" value="submit"
                                class="mt-3 btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>
                            <a href="#" class="mt-1 btn-danger btn w-100"
                                onclick="confirmDelete('<?php echo $row['user_id']; ?>')">ลบบัญชี</a>
                            <a href="admin-users-manage.php" class="mt-1 btn  btn-warning w-100">ยกเลิก</a>
                        </form>

                    <?php endforeach; ?>


                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    include 'script.php';
    ?>

</body>

</html>


<script>
    function confirmDelete(userId, admin) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'การลบบัญชีนี้ไม่สามารถย้อนกลับได้!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบทันที!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete script with user_id and admin values
                window.location.href = 'php/del-member.php?id=' + encodeURIComponent(userId) + '&admin=' + encodeURIComponent(admin);
            }
        });
    }
</script>