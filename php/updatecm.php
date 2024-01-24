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
    session_start();
    require_once "../connection.php";

    $user_id = $_SESSION['user_id'];
    $workplace_id = $_POST['workplace_id'];
    $comment_text = $_POST['comment'];

    if (isset($_FILES['img']) && $_FILES['img']['error'] !== 4) {
        if (!empty($_POST['old_img'])) {
            $old_img_path = 'img/' . $_POST['old_img'];
            if (file_exists($old_img_path)) {
                unlink($old_img_path);
            }
        }

        $new_img = $_FILES['img'];


        $new_img_path = '../img/' . basename($new_img['name']);
        move_uploaded_file($new_img['tmp_name'], $new_img_path);

        $stmt = $conn->prepare("UPDATE comments SET comment_text = :comment_text, img = :new_img WHERE user_id = :user_id");
        $stmt->bindParam(':comment_text', $comment_text);
        $stmt->bindParam(':new_img', $new_img_path);
        $stmt->bindParam(':user_id', $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE comments SET comment_text = :comment_text WHERE user_id = :user_id");
        $stmt->bindParam(':comment_text', $comment_text);
        $stmt->bindParam(':user_id', $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>";
        echo "Swal.fire('แสดงความคิดเห็นแล้ว!', 'ความคิดของคุณถูกบันทึกแล้ว', 'success').then(function() {
        window.location.href = '../wp-detail.php?id=$workplace_id';
    });
    </script>";
        exit();
    } else {
        echo "<script>
        Swal.fire('Error', 'มีข้อผิดพลาดในการแก้ไขข้อมูล', 'error').then(function() {
            window.location.href = '../index.php';
        });
    </script>";
    }
    ?>

</body>

</html>