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
    require '../connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $user_id = $_SESSION['user_id'];
        $user_fname = "" . htmlspecialchars($_POST['user_fname'], ENT_QUOTES, 'UTF-8') . "";
        $user_lname = "" . htmlspecialchars($_POST['user_lname'], ENT_QUOTES, 'UTF-8') . "";
        $password = $_POST['password'];
        $update_query = "UPDATE users SET user_fname=?, user_lname=?, password=? WHERE user_id=?";
        $stmt = $connection->prepare($update_query);

        $stmt->bind_param("ssss", $user_fname, $user_lname, $password, $user_id);

        if ($stmt->execute()) {
            // Update successful
            echo "<script>
                Swal.fire('Success', 'แก้ไขข้อมูลสำเร็จ!', 'success').then(function() {
                window.location.href = '../admin-users-manage.php';
            });
        </script>";
            exit();
        } else {
            // Update failed
            echo "เกิดข้อผิดพลาด : " . $connection->error;
        }

        // $stmt->close();
    }
    ?>
</body>

</html>