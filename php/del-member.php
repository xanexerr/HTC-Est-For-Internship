<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0"></script>
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
                window.location.href = "login.php";
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
                    window.location.href = "index.php";
                }
            });';
            echo '</script>';
            exit();
        }
    }

    $user_id = $_GET['id'];
    $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM comments WHERE user_id = ?");
    $stmtCheck->bindParam(1, $user_id);
    $stmtCheck->execute();
    $commentsCount = $stmtCheck->fetchColumn();

    if ($commentsCount > 0) {
        // If there are related comments, handle accordingly
        echo '<script>';
        echo 'Swal.fire({
        title: "ไม่สามารถลบบัญชีได้!",
        text: "เนื่องจากบัญชีนี้ได้ทำการเพิ่มข้อมูลต่างๆ สู่เว็บไซต์",
        icon: "error",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../admin-users-manage.php";
        }
    });';
        echo '</script>';
    } else {
        $stmtdeletewp = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmtdeletewp->bindParam(1, $user_id);

        if ($stmtdeletewp->execute()) {
            echo "<script>
            Swal.fire('Success', 'ลบมูลสำเร็จ!', 'success').then(function() {
                window.location.href = '../admin-users-manage.php';
            });
        </script>";
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