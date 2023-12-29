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

    // Prepare the UPDATE statement using placeholders
    $updatestatus = "UPDATE workplaces
            SET workplace_name = ?,
                work_type = ?,
                description = ?,
                work_tel = ?,
                workplace_address = ?
            WHERE user_id = ?";

    // Prepare the statement
    $stmt = $connection->prepare($updatestatus);

    // Bind parameters
    $stmt->bind_param("sssssi", $workplace_name, $work_type, $description, $work_tel, $workplace_address, $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('แก้ไขข้อมูลสำเร็จ!');
                window.location.href = '../index.php';
                </script>";
        exit();
    } else {
        // Handle errors
        echo "เกิดข้อผิดพลาด : " . $stmt->error;
    }
} else {
    // Handle if the form was not submitted
    echo "Form not submitted!";
}
?>