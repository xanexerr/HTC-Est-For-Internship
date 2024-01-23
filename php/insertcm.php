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

        // Get old rating from the database
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


        // Update rating in the database
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
                    Swal.fire('Success', 'Comment submitted!', 'success').then(function() {
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
                Swal.fire('Success', 'Comment submitted!', 'success').then(function() {
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