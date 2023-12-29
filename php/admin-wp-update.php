<?php
require_once("../connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST['workplace_name']) && isset($_POST['work_type']) && isset($_POST['description']) && isset($_POST['work_tel']) && isset($_POST['workplace_address'])) {

        // Sanitize and retrieve the form data
        $workplace_id = ($_POST['workplace_id']);
        $workplace_name = htmlspecialchars($_POST['workplace_name']);
        $work_type = htmlspecialchars($_POST['work_type']);
        $description = htmlspecialchars($_POST['description']);
        $work_tel = htmlspecialchars($_POST['work_tel']);
        $workplace_address = htmlspecialchars($_POST['workplace_address']);

        $updatestatus = "UPDATE workplaces
            SET workplace_name = ?,
                work_type = ?,
                description = ?,
                work_tel = ?,
                workplace_address = ?
            WHERE workplace_id = ?";

        $stmt = $connection->prepare($updatestatus);

        $stmt->bind_param("sssssi", $workplace_name, $work_type, $description, $work_tel, $workplace_address, $workplace_id);
        if ($stmt->execute()) {
            echo "<script>
                alert('แก้ไขข้อมูลสำเร็จ!');
                window.location.href = '../admin-wp.php';
                </script>";
            exit();
        } else {
            // Handle errors
            echo "เกิดข้อผิดพลาด : " . $stmt->error;
        }
    } else {
        echo "Please fill all the required fields.";
    }
} else {
    echo "Form submission error.";
}
?>