<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0"></script>
</head>

<body>

    <?php
    require_once("../connection.php");
    session_start();

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
            Swal.fire('Success', 'แก้ไขข้อมูลสำเร็จ!', 'success').then(function() {
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