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
                alert('แก้ไขข้อมูลสำเร็จ!');
                window.location.href = '../index.php';
              </script>";
        exit();
    } else {
        // Handle errors
        echo "เกิดข้อผิดพลาด : " . $connection->error;
    }
} else {
    // Handle if the form was not submitted
    echo "Form not submitted!";
}
?>