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
        echo '<script>
            Swal.fire({
                title: "คุณยังไม่ได้เข้าสู่ระบบ",
                icon: "error",
                confirmButtonText: "ตกลง"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login.php";
                }
            });
        </script>';
        exit();
    } else if ($_SESSION["role"] !== 'admin') {
        echo '<script>
            Swal.fire({
                title: "คุณไม่มีสิทธิเข้าถึง!",
                icon: "error",
                confirmButtonText: "ตกลง"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../index.php";
                }
            });
        </script>';
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_fname = trim($_POST['user_fname']);
        $user_lname = trim($_POST['user_lname']);
        $username = trim($_POST['username']);
        $user_type = trim($_POST['user_type']);

        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $location = ($_SESSION['role'] == 'admin') ? '../admin-users-manage.php' : '../admin-users-manage.php';
            echo '<script>
                Swal.fire({
                    title: "เคยลงทะเบียนบัญชีไปแล้ว",
                    icon: "warning",
                    confirmButtonText: "ตกลง"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . $location . '";
                    }
                });
            </script>';
        } else {
            $stmt = $conn->prepare("INSERT INTO users (user_fname, user_lname, username,password, role, user_id) VALUES (?, ?, ?, ?, ?, ?)");

            $stmt->bindParam(1, $user_fname);
            $stmt->bindParam(2, $user_lname);
            $stmt->bindParam(3, $username);
            $stmt->bindParam(4, $username);
            $stmt->bindParam(5, $user_type);
            $stmt->bindParam(6, $username);

            if ($stmt->execute()) {
                $location = ($_SESSION['role'] == 'admin') ? '../admin-users-manage.php' : '../admin-users-manage.php';
                echo '<script>
                    Swal.fire({
                        title: "เพิ่มผู้ใช้สำเร็จ!",
                        icon: "success",
                        confirmButtonText: "ตกลง"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . $location . '";
                        }
                    });
                </script>';
            } else {
                echo '<script>
                    Swal.fire({
                        title: "มีข้อผิดพลาดในการเพิ่มข้อมูล",
                        text: "' . $stmt->errorInfo()[2] . '",
                        icon: "error",
                        confirmButtonText: "ตกลง"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . $location . '";
                        }
                    });
                </script>';
            }
        }

        $stmt = null;
        $conn = null;
    }
    ?>

</body>

</html>