<?php
// Import necessary files and start session if required
session_start();
require '../connection.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_SESSION['user_id'];
    $user_fname = "" . htmlspecialchars($_POST['user_fname'], ENT_QUOTES, 'UTF-8') . "";
    $user_lname = "" . htmlspecialchars($_POST['user_lname'], ENT_QUOTES, 'UTF-8') . "";
    $password = $_POST['password']; // Note: Make sure to hash the password before storing in the database

    // Perform the update query
    $update_query = "UPDATE users SET user_fname=?, user_lname=?, password=? WHERE user_id=?";
    $stmt = $connection->prepare($update_query);

    $stmt->bind_param("ssss", $user_fname, $user_lname, $password, $user_id);

    if ($stmt->execute()) {
        // Update successful
        echo "<script>
                alert('แก้ไขข้อมูลสำเร็จ!');
                window.location.href = '../index.php';
                </script>";
        exit();
    } else {
        // Update failed
        echo "เกิดข้อผิดพลาด : " . $connection->error;
    }

    // $stmt->close();
}
?>