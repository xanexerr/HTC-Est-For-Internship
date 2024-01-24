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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $wp_name = htmlspecialchars($_POST['wp_name']);
        $row['work_type'] = ($_POST['work_type']);
        $description = htmlspecialchars($_POST['wp_des']);
        $wp_address = htmlspecialchars($_POST['wp_address']);
        $work_tel = htmlspecialchars($_POST['wp_tel']);
        $map = $_POST['map'];

        // require the database connection
        require '../connection.php';

        $updatewp = "INSERT INTO workplaces (workplace_name, workplace_address, work_type, description, work_tel, user_id , map) 
        VALUES (:wp_name, :wp_address, :work_type, :description, :work_tel, NULL, :map'')";

        // Prepare the SQL statement
        $stmt = $conn->prepare($updatewp);

        // Bind parameters with values
        $stmt->bindParam(':wp_name', $wp_name);
        $stmt->bindParam(':wp_address', $wp_address);
        $stmt->bindParam(':work_type', $row['work_type']);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':work_tel', $work_tel);
        $stmt->bindParam(':map', $map);
        // Execute the query
        if ($stmt->execute()) {
            echo '<script>
            Swal.fire({
                title: "เพิ่มสถานประกอบการสำเร็จ!",
                icon: "success",
                confirmButtonText: "ตกลง"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../admin-wp.php";
                }
            });
        </script>';
            exit();
        } else {
            // Handle errors
            echo "เกิดข้อผิดพลาด : " . $stmt->errorInfo()[2];
        }
    }
    ?>
</body>
<in </html>