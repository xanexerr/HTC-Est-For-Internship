<!DOCTYPE html>
<html lang="en">

<!-- header  -->

<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบรวบรวมสถานประกอบการ แผนกเทคโนโลยีสารสนเทศ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<!-- body -->

<body>
    <!-- top banner  -->
    <?php
    include 'header.php';
    include 'navbar.php';
    ?>
    <!-- content -->

    <div class="container d-flex justify-content-center align-items-center p-3 my-4 min-vh-100">

        <?php
        // Check if the user is logged in
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];

            $get_user_workplace = "SELECT workplace_id, workplace_name, workplace_address, work_type, description, work_tel, user_id FROM workplaces WHERE user_id = ?";
            $stmt_usercomment = $connection->prepare($get_user_workplace);
            $stmt_usercomment->bind_param("s", $user_id);
            $stmt_usercomment->execute();
            $result = $stmt_usercomment->get_result();

            if ($result->num_rows > 0) {
                // Fetch workplace data
                $row = $result->fetch_assoc();

                // Assign fetched data to variables
                $workplace_id = $row['workplace_id'];
                $workplace_name = $row['workplace_name'];
                $workplace_address = $row['workplace_address'];
                $work_type = $row['work_type'];
                $description = $row['description'];
                $work_tel = $row['work_tel'];
                $new_user_id = $row['user_id'];

                $_SESSION["workplace_id"] = $row['workplace_id'];
                $_SESSION["workplace_name"] = $row['workplace_name'];
                $_SESSION["workplace_address"] = $row['workplace_address'];
                $_SESSION["work_type"] = $row['work_type'];
                $_SESSION["description"] = $row['description'];
                $_SESSION["work_tel"] = $row['work_tel'];
                $_SESSION["new_user_id"] = $row['user_id'];


                $_SESSION["workplace_name"] = $workplace_name;
                ?>
                <!-- Add a form for editing workplace data -->
                <div class="container d-flex justify-content-center align-items-center p-3  p-4 " style="min-height: 85vh; ">
                    <div class="shadow" style="width: 768px; min-width:450px; ">
                        <p class='h4 py-2 px-auto bg-dark border text-white mb-0 text-center'>เมนูแก้ไขข้อมูลสถานประกอบการ </p>
                        <?php
                        echo '<form class="border p-3" name="edit_workplace_form" method="POST" action="php/update-wp-data.php"
                            enctype="multipart/form-data">';

                        echo '<label for="workplace_name" class="form-label">ชื่อสถานประกอบการ</label>';
                        echo '<input type="text" class="form-control" name="workplace_name" value="' . $workplace_name . '"
                                required>';

                        echo '<label for="work_type" class="form-label mt-1">ประเภทงาน</label>';
                        echo '<select class="form-control" name="work_type">';
                        echo '<option value="เขียนโปรแกรม"' . ($work_type === 'เขียนโปรแกรม' ? ' selected' : '') . '>เขียนโปรแกรม</option>';
                        echo '<option value="ทำกราฟิก"' . ($work_type === 'ทำกราฟิก' ? ' selected' : '') . '>ทำกราฟิก</option>';
                        echo '<option value="ระบบเครือข่าย"' . ($work_type === 'ระบบเครือข่าย' ? ' selected' : '') . '>ระบบเครือข่าย</option>';
                        echo '<option value="ทำเว็บไซต์"' . ($work_type === 'ทำเว็บไซต์' ? ' selected' : '') . '>ทำเว็บไซต์</option>';
                        echo '<option value="ด้านบริการ"' . ($work_type === 'ด้านบริการ' ? ' selected' : '') . '>ด้านบริการ</option>';
                        echo '<option value=""' . ($work_type === '' ? ' selected' : '') . '>อื่นๆ</option>';
                        echo '</select>';


                        echo '<label for="description" class="form-label mt-1">ลักษณะงาน</label>';
                        echo '<input type="text" class="form-control" name="description" value="' . $description . '"
                                required>';

                        echo '<label for="work_tel" class="form-label mt-1">เบอร์โทรติดต่อ</label>';
                        echo '<input type="text" class="form-control" name="work_tel" value="' . $work_tel . '" required>';

                        echo '<label for="workplace_address" class="form-label mt-1">ที่อยู่บริษัท</label>';
                        echo '<textarea class="form-control" name="workplace_address" rows="5"
                                required>' . $workplace_address . '</textarea>';


                        echo '<button type="submit" value="submit"
                                class="mt-3 btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>';
                        echo '<div class="d-flex flex-column justify-content-end mt-1" style="height: 100%; ">';

                        echo '<a href="std-comment.php" class="btn btn-primary" >เพิ่มความคิดเห็น</a>';
                        echo '</div>';
                        echo '<a href="index.php" class="mt-1 btn btn-danger w-100">ยกเลิก</a>';

                        echo '</form>';

                        ?>
                        <!-- disble form -->

                    </div>
                    <?php
            } else {
                $user_id = $_SESSION["user_id"];
                $get_workplace_id = "SELECT workplace_id FROM users WHERE user_id = ?";
                $stmt_userwp = $connection->prepare($get_workplace_id);
                $stmt_userwp->bind_param("s", $user_id);
                $stmt_userwp->execute();
                $wpresult = $stmt_userwp->get_result();

                if ($wpresult->num_rows > 0) {
                    $workplace_data = $wpresult->fetch_assoc();
                    $workplace_id = $workplace_data['workplace_id'];

                    $get_user_workplace = "SELECT workplace_id, workplace_name, workplace_address, work_type, description, work_tel, user_id FROM workplaces WHERE workplace_id = ?";
                    $stmt_usercomment = $connection->prepare($get_user_workplace);
                    $stmt_usercomment->bind_param("s", $workplace_id);
                    $stmt_usercomment->execute();
                    $result = $stmt_usercomment->get_result();


                    if ($result->num_rows > 0) {
                        echo '<div class="container d-flex justify-content-center align-items-center p-3 p-4 "
                    style="min-height: 85vh; ">';
                        echo ' <div class="border" style="width: 768px; min-width:450px; ">';

                        echo "<p class='h4 py-2 px-auto bg-dark border text-white mb-0 text-center'>สถานประกอบการของคุณ </p>";

                        // Fetch workplace data
                        $row = $result->fetch_assoc();
                        echo "<div class='p-4'>";
                        echo '<p class="h1 mt-3 mb-3"> ' . $row['workplace_name'] . '</p>';
                        echo '<p>ประเภทงาน : ' . $row['work_type'] . '</p>';
                        echo '<p>รายละเอียดงาน : ' . $row['description'] . '</p>';
                        echo '<p>เบอร์ติดต่อ : ' . $row['work_tel'] . '</p>';
                        echo '<p>ที่อยู่: ' . $row['workplace_address'] . '</p>';
                        echo '<a  href="std-comment.php" class="mt-1 btn btn-success w-100" >เพิ่มความคิดเห็น</a>';
                        echo '</div>';
                        echo '</div>';



                    } else {
                        echo '<div class="container d-flex justify-content-center align-items-center p-3 " style="min-height: 85vh; ">
                    <div style="width: 768px;  shadow p-4">
                        <p class="h4 py-2 px-auto bg-dark border text-white mb-0 text-center">เลือกสถานประกอบการที่คุณฝึกประสบการณ์ </p>';
                        echo '<form class="border p-3" name="select_workplace_form" method="POST" action="php/update-wp-select.php"
                            enctype="multipart/form-data">';
                        echo '<label for="workplace_name" class="form-label mt-1">สถานประกอบการ</label>';
                        echo '<select class="form-control my-1" name="workplace">';
                        $sql = "SELECT workplace_id, workplace_name FROM workplaces";
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["workplace_id"] . '">' . $row["workplace_name"] . '</option>';
                            }
                        } else {
                            echo '<option value="">ไม่พบข้อมูล</option>';
                        }

                        echo "</select>";
                        echo '<button type="submit" value="submit"
                                class="mt-3 btn btn-success w-100">ยืนยัน</button>';
                        echo '<a href="index.php" class="mt-1 btn btn-danger w-100">ยกเลิก</a>';
                        echo '<a href="#" class="mt-1 btn btn-secondary w-100">เพิ่มสถานประกอบการใหม่</a>';

                    }
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo "No workplace found for this user.";
                }
                echo '</form>';

            }
        } else {
            echo '<script>';
            echo 'alert("คุณยังไม่ได้เข้าสู่ระบบ");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
        }
        ?>
        </div>
    </div>

    <!-- footer  -->
    <?php
    if (isset($_SESSION["user_id"])) {

    } else {
        echo '<nav class="bg-warning d-flex justify-content-center  px-5 mt-5">';
        echo '<div class="">
        <a href="#" class="p-2 px-3 btn btn-warning mx-1">ลงทะเบียนใช้งานระบบ | ติดต่อแอดมิน</a>
      </div>';
        echo '</nav>';
    }
    ?>

    <?php
    include 'script.php';
    ?>

</body>

</html>