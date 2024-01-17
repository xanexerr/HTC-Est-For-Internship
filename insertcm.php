<?php
session_start();
require_once "connection.php";

if (isset($_POST['submit'])) {
    // Assuming user_id is stored in the session
    if (!isset($_SESSION['user_id'])) {
        // Redirect or handle the case where user_id is not available in the session
        exit("User ID not found");
    }

    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];
    $img = $_FILES['img'];

    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode(".", $img['name']);
    $fileActExt = strtolower(end($extension));
    $fileNew = rand() . "." . $fileActExt;
    $filePath = "img/" . $fileNew;

    if (in_array($fileActExt, $allow)) {
        if ($img['size'] > 0 && $img['error'] == 0) {
            if (move_uploaded_file($img['tmp_name'], $filePath)) {
                try {
                    $sql = $conn->prepare("INSERT INTO comments(comment_text, img, user_id) VALUES(:comment, :img, :user_id)");
                    $sql->bindParam(":comment", $comment);
                    $sql->bindParam(":img", $fileNew);
                    $sql->bindParam(":user_id", $user_id);
                    $sql->execute();

                    $_SESSION['success'] = "Data has been inserted successfully";
                    header("location: std-wp-edit.php");
                    exit();
                } catch (PDOException $e) {
                    $_SESSION['error'] = "Error inserting data: " . $e->getMessage();
                    header("location: std-wp-edit.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Error uploading image";
            }
        } else {
            $_SESSION['error'] = "Invalid image file";
        }
    } else {
        $_SESSION['error'] = "File format not allowed";
    }
}

// Redirect if form submission failed or not completed
// header("location: std-wp-edit.php");
// exit();
?>