<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0"></script>
</head>

<body>
    <?php
    session_start();
    require_once "../connection.php";

    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rate'];
    $workplace_id = $_POST['workplace_id'];
    $comment_text = $_POST['comment'];

    // Check if an image file is present
    if (isset($_FILES['img']) && $_FILES['img']['error'] !== 4) {  // Check for error code 4 (UPLOAD_ERR_NO_FILE)
        $img = $_FILES['img'];
        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode(".", $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "img/" . $fileNew;

        // Move uploaded image to the destination directory
        if (move_uploaded_file($img['tmp_name'], $filePath)) {
            // Image moved successfully, now insert into the database
            $stmt = $conn->prepare("INSERT INTO comment (user_id, rating, workplace_id, comment_text, img_path) VALUES 
            (:user_id, :rating, :workplace_id, :comment_text, :img_path)");

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':workplace_id', $workplace_id);
            $stmt->bindParam(':comment_text', $comment_text);
            $stmt->bindParam(':img_path', $filePath);

            if ($stmt->execute()) {
                echo "<script>";
                echo "Swal.fire('Success', 'แสดงความคิดเห็นแล้ว!', 'success').then(function() {
                window.location.href = '../admin-users-manage.php';
            });
            </script>";
                exit();
            } else {
                echo "<script>
                Swal.fire('Error', 'มีข้อผิดพลาดในการแก้ไขข้อมูล: , 'error').then(function() {
                    window.location.href = '../admin-users-manage.php';
                });
            </script>";
            }
        } else {
            echo "<script>
            Swal.fire('Error', 'มีข้อผิดพลาดในการอัปโหลดรูปภาพ: , 'error').then(function() {
                window.location.href = '../admin-users-manage.php';
            });
        </script>";
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO comments (user_id, rating, workplace_id, comment_text) VALUES 
        (:user_id, :rating, :workplace_id, :comment_text)");

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':workplace_id', $workplace_id);
        $stmt->bindParam(':comment_text', $comment_text);

        if ($stmt->execute()) {
            echo "<script>";
            echo "Swal.fire('แสดงความคิดเห็นแล้ว!', 'ความคิดของคุณ ถึงบันทึกแล้ว', 'success').then(function() {
            window.location.href = '../wp-detail.php?id=$workplace_id';
        });
        </script>";
            exit();
        } else {
            echo "<script>
            Swal.fire('Error', 'มีข้อผิดพลาดในการแก้ไขข้อมูล: , 'error').then(function() {
                window.location.href = '../admin-users-manage.php';
            });
        </script>";
        }
    }
    ?>



    // if (in_array($fileActExt, $allow)) {
    // if ($img['size'] > 0 && $img['error'] == 0) {
    // if (move_uploaded_file($img['tmp_name'], $filePath)) {
    // try {
    // $sql = $conn->prepare("INSERT INTO comments(?, ?, comment_text, img) VALUES(:comment, :img)");
    // $sql->bindParam(":comment", $comment);
    // $sql->bindParam(":img", $fileNew);
    // $sql->bindParam(":user_id", $user_id);
    // $sql->execute();

    // $_SESSION['success'] = "Data has been inserted successfully";
    // header("location: std-wp-edit.php");
    // exit();
    // } catch (PDOException $e) {
    // $_SESSION['error'] = "Error inserting data: " . $e->getMessage();
    // header("location: std-wp-edit.php");
    // exit();
    // }
    // } else {
    // $_SESSION['error'] = "Error uploading image";
    // }
    // } else {
    // $_SESSION['error'] = "Invalid image file";
    // }
    // } else {
    // $_SESSION['error'] = "File format not allowed";
    // }


    // Redirect if form submission failed or not completed
    // header("location: std-wp-edit.php");
    // exit();
</body>

</html>