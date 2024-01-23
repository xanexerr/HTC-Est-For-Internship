<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "connection.php"; // Corrected the filename here
    $workplace_name = $_POST["workplace_name"];
    $workplace_address = $_POST["workplace_address"];
    $work_type = $_POST["work_type"];
    $work_des = $_POST["work_des"];
    $work_tel = $_POST["workplace_tel"];
    $map = $_POST["map"];
    $user_id = $_SESSION["user_id"];
    $stmt = $connection->prepare("INSERT INTO workplaces (workplace_name, workplace_address, work_type, description, work_tel, map, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $workplace_name, $workplace_address, $work_type, $work_des, $work_tel, $map, $user_id);

    if ($stmt->execute()) {
        $user_id = $_SESSION['user_id'];
        $userwp_query = "SELECT workplace_id FROM workplaces WHERE user_id = ?";
        $stmt_userwp = $connection->prepare($userwp_query);
        $stmt_userwp->bind_param("s", $user_id);
        $stmt_userwp->execute();
        $stmt_userwp->bind_result($userwp);
        $stmt_userwp->fetch();
        $stmt_userwp->close();
        $update_user_query = "UPDATE users SET workplace_id = ? WHERE user_id = ?";
        $stmt_update_user = $connection->prepare($update_user_query);
        $stmt_update_user->bind_param("ss", $userwp, $user_id);
        $stmt_update_user->execute();
        $stmt_update_user->close();

        echo "<script>
                Swal.fire('Success', 'ข้อมูลได้รับการบันทึกแล้ว', 'success').then(function() {
                    window.location.href = 'index.php'; // Redirect to index.php or any other page
                });
            </script>";

    } else {
        echo "<script>
                Swal.fire('Error', 'มีข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            </script>";
    }
    $stmt->close();
}
?>



<body>
    <?php include 'navbar.php'; ?>
    <div class="flex-container">
        <div class="container ">
            <div class="my-3 bg-body shadow mx-auto col-6 ">
                <p class="h4 py-2 px-auto bg-dark border text-white mb-0 text-center">เพิ่มสถานประกอบการ</p>
                <div class="p-3">
                    <form action="std-add-wp.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="workplace_name" class="col-form-label">ชื่อบริษัท:</label>
                            <input type="text" require class="form-control" name="workplace_name">
                        </div>
                        <div class="mb-3">
                            <label for="workplace_address" class="col-form-label">ที่อยู่บริษัท:</label>
                            <input type="text" require class="form-control" name="workplace_address">
                        </div>
                        <div class="mb-3">
                            <label for="work_type" class="col-form-label">ประเภทงาน:</label>
                            <?php
                            echo '<select class="form-control" name="work_type">';
                            echo '<option value="เขียนโปรแกรม">เขียนโปรแกรม</option>';
                            echo '<option value="ทำกราฟิก">ทำกราฟิก</option>';
                            echo '<option value="ระบบเครือข่าย">ระบบเครือข่าย</option>';
                            echo '<option value="ทำเว็บไซต์">ทำเว็บไซต์</option>';
                            echo '<option value="ด้านบริการ">ด้านบริการ</option>';
                            echo '<option value="">อื่นๆ</option>';
                            echo '</select>';
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="work_des" class="col-form-label">ลักษณะงาน:</label>
                            <input type="text" require class="form-control" name="work_des">
                        </div>
                        <div class="mb-3">
                            <label for="workplace_tel" class="col-form-label">เบอร์โทรติดต่อ:</label>
                            <input type="number" require class="form-control" name="workplace_tel">
                        </div>

                        <div class="form-group">
                            <label for="map">แผนที่</label>
                            <input type="url" class="form-control" name="map" id="map" rows="4">
                        </div>

                        <div class="mb-3 mt-3">
                            <button type="submit" name="submit"
                                class="btn btn-success w-100">เพิ่มสถานประกอบการ</button>
                            <a href="index.php" class="mt-1 btn btn-warning w-100">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    include 'script.php';
    ?>
    <script>
        addClassToElement("std-add");
    </script>

</body>

</html>