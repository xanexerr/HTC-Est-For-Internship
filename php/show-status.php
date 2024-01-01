<?php
require('../connection.php');
if (isset($_GET['id'])) {
    $workplace_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT `show` FROM workplaces WHERE `workplace_id` = :workplace_id");
    $stmt->bindParam(':workplace_id', $workplace_id, PDO::PARAM_INT);
    $stmt->execute();
    $workplaceData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($workplaceData) {
        $status = $workplaceData['show'];
        if ($status == '1') {
            $status = '0';

            $updatestatus = "UPDATE workplaces SET `show` = :status WHERE workplace_id = :workplace_id";
            $stmt = $conn->prepare($updatestatus);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':workplace_id', $workplace_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "<script>window.location.href = '../admin-wp-edit.php?id=$workplace_id';</script>";
                exit();
            } else {
                // Handle errors
                echo "เกิดข้อผิดพลาด : " . $stmt->errorInfo()[2];
            }
        } else {
            $status = '1';
            $updatestatus = "UPDATE workplaces SET `show` = :status WHERE workplace_id = :workplace_id";
            $stmt = $conn->prepare($updatestatus);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':workplace_id', $workplace_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "<script>window.location.href = '../admin-wp-edit.php?id=$workplace_id';</script>";
                exit();
            } else {
                // Handle errors
                echo "เกิดข้อผิดพลาด : " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo "Workplace not found.";
    }
}
?>


<?php
if (isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];

    $stmt = $conn->prepare("SELECT `show` FROM comments WHERE `comment_id` = :comment_id");
    $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    $stmt->execute();
    $commentData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($commentData) {
        $status = $commentData['show'];
        if ($status == '1') {
            $status = '0';

            $updatestatus = "UPDATE comments SET `show` = :status WHERE comment_id = :comment_id";
            $stmt = $conn->prepare($updatestatus);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "<script>window.location.href = '../admin-comment.php';</script>";
                exit();
            } else {
                // Handle errors
                echo "เกิดข้อผิดพลาด : " . $stmt->errorInfo()[2];
            }
        } else {
            $status = '1';
            $updatestatus = "UPDATE comments SET `show` = :status WHERE comment_id = :comment_id";
            $stmt = $conn->prepare($updatestatus);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "<script>window.location.href = '../admin-comment.php';</script>";
                exit();
            } else {
                // Handle errors
                echo "เกิดข้อผิดพลาด : " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo "comment not found....";
    }

}
?>