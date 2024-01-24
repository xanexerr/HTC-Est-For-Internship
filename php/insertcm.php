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

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Function to safely get post data
        function getPost($key, $defaultValue = "")
        {
            return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : $defaultValue;
        }

        $user_id = $_SESSION['user_id'];
        $rating = getPost('rate');
        $workplace_id = getPost('workplace_id');
        $comment_text = getPost('comment');

        // Validate and sanitize user inputs
        $rating = filter_var($rating, FILTER_VALIDATE_FLOAT);
        $workplace_id = filter_var($workplace_id, FILTER_SANITIZE_STRING);
        $comment_text = filter_var($comment_text, FILTER_SANITIZE_STRING);

        if ($rating === false || $workplace_id === false) {
            echo "<script>
            Swal.fire('Error', 'Invalid input.', 'error').then(function() {
                window.location.href = '../index.php';
            });
        </script>";
            exit();
        }

        $check_comment_query = "SELECT COUNT(*) FROM comments WHERE user_id = ?";
        $stmt_check_comment = $connection->prepare($check_comment_query);
        $stmt_check_comment->bind_param("s", $user_id);
        $stmt_check_comment->execute();
        $stmt_check_comment->bind_result($comment_count);
        $stmt_check_comment->fetch();
        $stmt_check_comment->close();

        if ($comment_count > 0) {
            echo "<script>
            Swal.fire('คุณแสดงความเห็นไปแล้ว', 'คุณได้แสดงความเห็นไปแล้ว', 'warning').then(function() {
                window.location.href = '../index.php';
            });
        </script>";
            exit();
        }

        $get_old_rating_query = "SELECT rating FROM workplaces WHERE workplace_id = ?";
        $stmt_get_old_rating = $connection->prepare($get_old_rating_query);
        $stmt_get_old_rating->bind_param("s", $workplace_id);
        $stmt_get_old_rating->execute();
        $stmt_get_old_rating->bind_result($oldrating);
        $stmt_get_old_rating->fetch();
        $stmt_get_old_rating->close();

        $oldrating = (float) $oldrating;
        $rating = (float) $rating;
        if ($oldrating > 0) {
            $newrating = ($oldrating + $rating) / 2;
        } else {
            $newrating = $rating;
        }



        $update_rating_query = "UPDATE workplaces SET rating = ? WHERE workplace_id = ?";
        $stmt_update_rating = $connection->prepare($update_rating_query);
        $stmt_update_rating->bind_param("ds", $newrating, $workplace_id);
        $stmt_update_rating->execute();

        // Check if an image is being uploaded
        if (isset($_FILES['img']) && $_FILES['img']['error'] !== 4) {
            $img = $_FILES['img'];

            // Check image type and upload
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode(".", $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = "../img/" . $fileNew;

            if (move_uploaded_file($img['tmp_name'], $filePath)) {
                // Insert comment with image into the database
                $stmt = $connection->prepare("INSERT INTO comments (user_id, rating, workplace_id, comment_text, img) VALUES 
            (?, ?, ?, ?, ?)");

                $stmt->bind_param('dssss', $user_id, $rating, $workplace_id, $comment_text, $filePath);

                if ($stmt->execute()) {
                    echo "<script>
                    Swal.fire('แสดงความคิดเห็นสำเร็จ', 'ระบบบันทุกข้อมูลของคุณเรียบร้อบ!', 'success').then(function() {
                        window.location.href = '../index.php';
                    });
                </script>";
                    exit();
                } else {
                    echo "<script>
                    Swal.fire('Error', 'Failed to submit comment.', 'error').then(function() {
                        window.location.href = '../index.php';
                    });
                </script>";
                    exit();
                }
            } else {
                echo "<script>
                Swal.fire('Error', 'Failed to upload image.', 'error').then(function() {
                    window.location.href = '../index.php';
                });
            </script>";
                exit();
            }
        } else {
            // Insert comment without image into the database
            $stmt = $connection->prepare("INSERT INTO comments (user_id, rating, workplace_id, comment_text) VALUES 
        (?, ?, ?, ?)");

            $stmt->bind_param('dsss', $user_id, $rating, $workplace_id, $comment_text);

            if ($stmt->execute()) {
                echo "<script>
                Swal.fire('แสดงความคิดเห็นแล้ว', 'บันทึกข้อมูลของคุณเข้าสู่ระบบแล้ว', 'success').then(function() {
                    window.location.href = '../index.php';
                });
            </script>";
                exit();
            } else {
                echo "<script>
                Swal.fire('Error', 'Failed to submit comment.', 'error').then(function() {
                    window.location.href = '../index.php';
                });
            </script>";
                exit();
            }
        }
    } else {
        echo "<script>
            Swal.fire('Error', 'Form not submitted!', 'error').then(function() {
                window.location.href = '../index.php';
            });
             </script>";
    }
    ?>

</body>

</html>