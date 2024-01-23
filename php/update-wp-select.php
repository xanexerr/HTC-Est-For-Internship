<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0"></script>
</head>

<body>
    <?php
    session_start();

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require '../connection.php';
        $user_id = $_SESSION['user_id'];

        $workplace_id = $_POST['workplace'];

        // Prepare and execute your SQL UPDATE query
        $updatestatus = "UPDATE users
            SET workplace_id = '$workplace_id'
            WHERE user_id = '$user_id'";

        // Execute the query
        if ($connection->query($updatestatus) === TRUE) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'แก้ไขข้อมูลสำเร็จ!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = '../index.php';
                });
              </script>";
            exit();
        } else {
            // Handle errors
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'เกิดข้อผิดพลาด : " . $connection->error . "',
                    showConfirmButton: false,
                    timer: 3000
                });
              </script>";
        }
    } else {
        // Handle if the form was not submitted
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'Form not submitted!',
                showConfirmButton: false,
                timer: 3000
            });
          </script>";
    }
    ?>
</body>

</html>