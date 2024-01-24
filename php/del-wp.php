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
    require_once('../connection.php');
    session_start();
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
        if ($_SESSION["role"] !== 'admin' && $_SESSION["role"] !== 'teacher') {
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

    $workplace_id = $_GET['id'];
    $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM comments WHERE workplace_id = ?");
    $stmtCheck->bindParam(1, $workplace_id);
    $stmtCheck->execute();
    $commentsCount = $stmtCheck->fetchColumn();
    if ($commentsCount > 0) {
        echo '<script>';
        echo 'Swal.fire({
        title: "ไม่สามารถลบได้!",
        text: "เนื่องจากได้มีนักเรียน นักศึกษา แสดงความคิดเห็นไว้!",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../admin-wp.php";
        }
    });';
        echo '</script>';
    } else {
        $stmtdeleteuser = $conn->prepare("UPDATE users SET workplace_id = null WHERE workplace_id = ?");
        $stmtdeleteuser->bindParam(1, $workplace_id);
        $stmtdeleteuser->execute();

        $stmtdeletewp = $conn->prepare("DELETE FROM workplaces WHERE workplace_id = ?");
        $stmtdeletewp->bindParam(1, $workplace_id);
        $stmtdeletewp->execute();


        if ($stmtdeletewp->execute()) {
            if ($_SESSION['role'] == 'admin') {
                echo "<script>
            Swal.fire('ลบมูลสำเร็จ!', 'ลบสถานประกอบการออกจากระบบแล้ว!', 'success').then(function() {
                window.location.href = '../admin-wp.php';
            });
        </script>";
            } else {
                echo "<script>
            Swal.fire('ลบมูลสำเร็จ!', 'ลบสถานประกอบการออกจากระบบแล้ว!', 'success').then(function() {
                window.location.href = '../teacher-wp.php';
            });
        </script>";
            }
        } else {
            $errorMessage = "มีข้อผิดพลาดในการลบข้อมูล : " . $stmtdeletewp->errorInfo()[2];
            echo 'Swal.fire({ title: "' . $errorMessage . '", icon: "error" });';
        }
    }

    $stmtCheck = null;
    $stmtdeletewp = null;
    $conn = null;
    ?>
</body>

</html>