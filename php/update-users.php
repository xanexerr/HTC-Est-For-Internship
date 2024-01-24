<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/select2.min.css" rel="stylesheet">
    <script src="../js/sweetalert10.16.0.js"></script>
</head>

<body>

    <?php
    session_start();
    require_once("../connection.php");
    if (!isset($_SESSION["user_id"])) {
        echo '<script>';
        echo 'Swal.fire({
        title: "คุณยังไม่ได้เข้าสู่ระบบ",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../login.php";
            }
        });';
        echo '</script>';

        exit();
    } else {
        if ($_SESSION["role"] !== 'admin') {
            echo '<script>';
            echo 'Swal.fire({
            title: "คุณไม่มีสิทธิเข้าถึง!",
            icon: "warning",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../index.php";
                }
            });';
            echo '</script>';
            exit();
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $old_user_id = $_POST["old_user_id"];
        $user_id = $_POST['user_id'];
        $user_fname = htmlspecialchars($_POST['user_fname']);
        $user_lname = htmlspecialchars($_POST['user_lname']);
        $role = ($_POST['role']);

        $updateStatusQuery = "UPDATE users
    SET 
        user_id = ?,
        username = ?,
        user_fname = ?,
        user_lname = ?,
        role = ?
    WHERE user_id = ?";

        $stmt = $connection->prepare($updateStatusQuery);

        $stmt->bind_param("ssssss", $user_id, $user_id, $user_fname, $user_lname, $role, $old_user_id);

        if ($stmt->execute()) {
            echo "<script>
            Swal.fire('แก้ไขข้อมูลสำเร็จ', 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อย!', 'success').then(function() {
                window.location.href = '../admin-users-manage.php';
            });
        </script>";
            exit();
        } else {
            echo "<script>
            Swal.fire('Error', 'มีข้อผิดพลาดในการแก้ไขข้อมูล: " . $stmt->error . "', 'error').then(function() {
                window.location.href = '../admin-users-manage.php';
            });
        </script>";
        }
    } else {
        echo "Form submission error.";
    }
    ?>

</body>

</html>