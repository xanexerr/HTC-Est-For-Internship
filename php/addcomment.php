<?php

session_start();
require '../connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["std_comment"])) {
    $user_id = $_SESSION["user_id"];
    $std_comment = $_POST["std_comment"];
    $rating = $_POST['rating'];

    $insertQuery = "INSERT INTO comments (user_id, workplace_id, comment_text, rating, comment_time) 
                    VALUES (?, ?, ?, ?, current_timestamp())";

    $stmt = $connection->prepare($insertQuery);

    $user_id = $_SESSION["user_id"];
    $get_workplace_id = "SELECT workplace_id FROM users WHERE user_id = ?";
    $stmt_userwp = $connection->prepare($get_workplace_id);
    $stmt_userwp->bind_param("s", $user_id);
    $stmt_userwp->execute();
    $wpresult = $stmt_userwp->get_result();
    $workplace_data = $wpresult->fetch_assoc();
    $workplace_id = $workplace_data['workplace_id'];

    if ($stmt) {
        $workplace_id = 74; // Replace with the actual workplace ID
        $stmt->bind_param("ssss", $user_id, $workplace_id, $std_comment, $rating);
        $stmt->execute();
        $stmt->close();

        echo "<script>
                alert('แก้ไขข้อมูลสำเร็จ!');
                window.location.href = '../index.php';
              </script>";
        exit();

    } else {
        echo "Failed to prepare the SQL statement.";
    }

}
$connection->close();

?>