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
    $workplace_id = $_POST['workplace_id'];
    $comment_text = $_POST['comment'];

    $stmt = $conn->prepare("UPDATE comments SET comment_text = :comment_text WHERE user_id = :user_id");
    $stmt->bindParam(':comment_text', $comment_text);
    $stmt->bindParam(':user_id', $user_id);

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
                window.location.href = '../admin-users-manage.php';
            });
        </script>";
    }

    ?>
</body>

</html>