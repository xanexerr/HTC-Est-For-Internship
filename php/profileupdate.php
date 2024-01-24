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
    require_once("../connection.php");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_POST['user_id'];
        $user_fname = htmlspecialchars($_POST['user_fname']);
        $user_lname = htmlspecialchars($_POST['user_lname']);
        $user_tel = ($_POST['user_tel']);
        $pwd = $_POST['password'];

        $updateStatusQuery = "UPDATE users
                      SET 
                          user_fname = ?,
                          user_lname = ?,
                          user_tel = ?,
                          password = ?
                      WHERE user_id = ?";

        $stmt = $connection->prepare($updateStatusQuery);


        $stmt->bind_param("sssss", $user_fname, $user_lname, $user_tel, $pwd, $user_id);


        if ($stmt->execute()) {
            echo "<script>
            Swal.fire('แก้ไขข้อมูลสำเร็จ', 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อย!', 'success').then(function() {
                window.location.href = '../profile.php';
            });
        </script>";
            exit();
        } else {
            echo "<script>
        Swal.fire('Error', 'มีข้อผิดพลาดในการแก้ไขข้อมูล: " . $stmt->error . "', 'error').then(function() {
            window.location.href = '../profile.php';
        });
    </script>";
        }
    } else {
        echo "Form submission error.";
    }
    ?>

</body>

</html>