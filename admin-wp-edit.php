<!DOCTYPE html>
<html lang="en">

<!-- header  -->
<?php
include("header.php")
    ?>
<!-- body -->

<body>
    <!-- top banner  -->
    <?php
    require('connection.php');
    include 'navbar.php';
    include 'php/admin-check.php';

    $workplace_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT COUNT(*) FROM workplaces ");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM workplaces WHERE `workplace_id` =  '$workplace_id' ");
    $stmt->execute();
    $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <!-- content -->

    <div class="flex-container">
        <div class="container  px-0 border   shadow rounded my-3 col-md-10 bg-white">
            <p class='h4 py-2  bg-dark border text-white  mb-0 text-center  rounded-top '>รายละเอียด </p>
            <div class="">
                <div class="">
                    <?php foreach ($workplacesData as $row): ?>

                        <form class="border p-3" name="edit_workplace_form" method="POST" action="php/admin-wp-update.php"
                            enctype="multipart/form-data">

                            <?php if ($row['show'] == '0'): ?>
                                <div class="text-center ">
                                    <a href='php/show-status.php?id=<?php echo $row['workplace_id']; ?>'
                                        class='px-2 btn btn-success d-block w-100'>ไม่ได้แสดงสถานประกอบการ : คลิกเพื่อแสดงผล</a>
                                </div>
                            <?php else: ?>
                                <div class="text-center ">
                                    <a href='php/show-status.php?id=<?php echo $row['workplace_id']; ?>'
                                        class='btn btn-danger d-block w-100'>กำลังแสดงผลบนเว็บไซต์ :
                                        คลิกเพื่อเก็บสถานประกอบการ</a>
                                </div>
                            <?php endif; ?>
                            <label for="workplace_id" class="form-label">รหัสสถานประกอบการ</label>
                            <input type="text" class="form-control text-danger" name="workplace_id" readonly
                                value="<?php echo $row['workplace_id']; ?>">


                            <label for="workplace_name" class="form-label  mt-1">ชื่อสถานประกอบการ</label>
                            <input type="text" class="form-control" name="workplace_name"
                                value="<?php echo $row['workplace_name']; ?>" required>

                            <label for="work_type" class="form-label mt-1">ประเภทงาน</label>
                            <select class="form-control" name="work_type">
                                <option value="เขียนโปรแกรม" <?= ($row['work_type'] === 'เขียนโปรแกรม' ? ' selected' : '') ?>>
                                    เขียนโปรแกรม</option>
                                <option value="ทำกราฟิก" <?= ($row['work_type'] === 'ทำกราฟิก' ? ' selected' : '') ?>>ทำกราฟิก
                                </option>
                                <option value="ระบบเครือข่าย" <?= ($row['work_type'] === 'ระบบเครือข่าย' ? ' selected' : '') ?>>
                                    ระบบเครือข่าย</option>
                                <option value="ทำเว็บไซต์" <?= ($row['work_type'] === 'ทำเว็บไซต์' ? ' selected' : '') ?>>
                                    ทำเว็บไซต์
                                </option>
                                <option value="ด้านบริการ" <?= ($row['work_type'] === 'ด้านบริการ' ? ' selected' : '') ?>>
                                    ด้านบริการ
                                </option>
                                <option value="<?= ($row['work_type'] === '' ? ' selected' : '') ?>">อื่นๆ</option>
                            </select>



                            <label for="description" class="form-label mt-1">ลักษณะงาน</label>
                            <input type="text" class="form-control" name="description"
                                value="<?php echo $row['description']; ?>" required>

                            <label for="work_tel" class="form-label mt-1">เบอร์โทรติดต่อ</label>
                            <input type="tel" class="form-control" name="work_tel" value="<?php echo $row['work_tel']; ?>"
                                required>

                            <label for="workplace_address" class="form-label mt-1">ที่อยู่บริษัท</label>
                            <textarea class="form-control" name="workplace_address" rows="5"
                                required><?php echo $row['workplace_address']; ?></textarea>

                            <div class="form-group">
                                <label for="map">แผนที่</label>
                                <input type="text" class="form-control" name="map" id="map" rows="4"
                                    value="<?php echo $row['map']; ?>">
                            </div>

                            <button type="submit" value="submit"
                                class="mt-3 btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>
                            <a href="#" class="mt-1 btn-danger btn w-100"
                                onclick="confirmDelete('<?php echo $row['workplace_id']; ?>')">ลบสถานประกอบการ</a>
                            <a href="admin-wp.php" class="mt-1 btn btn-warning w-100">ยกเลิก</a>
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
<script>
    function confirmDelete(userId, admin) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'การลบสถานประกอบการนี้ไม่สามารถย้อนกลับได้!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบทันที!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'php/del-wp.php?id=' + encodeURIComponent(userId) + '&admin=' + encodeURIComponent(admin);
            }
        });
    }
</script>

</html>