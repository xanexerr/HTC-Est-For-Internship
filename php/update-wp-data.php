<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0"></script>
</head>

<body>

    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require '../connection.php'; // Connect to the database
    
        // Assume $connection is the mysqli connection object
    
        $user_id = $_SESSION['user_id'];

        $workplace_name = $_POST['workplace_name'];
        $work_type = $_POST['work_type'];
        $description = $_POST['description'];
        $work_tel = $_POST['work_tel'];
        $workplace_address = $_POST['workplace_address'];
        $map = $_POST['map'];
        // Prepare the UPDATE statement using placeholders
        $updatestatus = "UPDATE workplaces
            SET workplace_name = ?,
                work_type = ?,
                description = ?,
                work_tel = ?,
                workplace_address = ?,
                map = ?
            WHERE user_id = ?";

        // Prepare the statement
        $stmt = $connection->prepare($updatestatus);

        // Bind parameters
        $stmt->bind_param("ssssssi", $workplace_name, $work_type, $description, $work_tel, $workplace_address, $map, $user_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
            Swal.fire('Success', 'แก้ไขข้อมูลสำเร็จ!', 'success').then(function() {
                window.location.href = '../index.php';
            });
        </script>";
            exit();
        } else {
            echo "<script>
            Swal.fire('Error', 'มีข้อผิดพลาดในการแก้ไขข้อมูล: " . $stmt->error . "', 'error').then(function() {
                window.location.href = '../index.php';
            });
        </script>";
        }
    } else {
        // Handle if the form was not submitted
        echo "Form not submitted!";
    }
    ?>

</body>

</html>