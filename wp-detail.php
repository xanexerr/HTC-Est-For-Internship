<!DOCTYPE html>
<html lang="en">

<?php
include "header.php";
include "navbar.php";
?>

<body>


    <?php
    require 'connection.php';
    if (isset($_GET['id'])) {
        $workplace_id = $_GET['id'];


        $query = "SELECT * FROM `show_data_view` WHERE workplace_id = ?";
        $stmt = $connection->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $workplace_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<div class="container d-flex justify-content-center align-items-center p-2  min-vh-100">';
                echo '<div class="border rounded shadow p-5 mx-auto " style="width:1024px; min-width:450px">';

                echo '<p class="h1 mt-3 mb-3"> ' . $row['workplace_name'] . '</p>';
                echo '<p>ประเภทงาน : ' . $row['work_type'] . '</p>';
                echo '<p>รายละเอียดงาน : ' . $row['description'] . '</p>';
                echo '<p>เบอร์ติดต่อ : ' . $row['work_tel'] . '</p>';
                echo '<p>ที่อยู่: ' . $row['workplace_address'] . '</p>';

                $queryAvgRating = "SELECT AVG(rating) AS average_rating FROM comments WHERE workplace_id = ?";
                $stmtAvgRating = $connection->prepare($queryAvgRating);

                if ($stmtAvgRating) {
                    $stmtAvgRating->bind_param("i", $workplace_id);
                    $stmtAvgRating->execute();
                    $resultAvgRating = $stmtAvgRating->get_result();


                    $queryComments = "SELECT comment_text FROM comments WHERE workplace_id = ?";
                    $stmtComments = $connection->prepare($queryComments);

                    if ($stmtComments) {
                        $stmtComments->bind_param("i", $workplace_id);
                        $stmtComments->execute();
                        $resultComments = $stmtComments->get_result();

                        if ($resultComments && $resultComments->num_rows > 0) {
                            if ($resultAvgRating && $resultAvgRating->num_rows > 0) {
                                $rowAvgRating = $resultAvgRating->fetch_assoc();
                                $averageRating = $rowAvgRating["average_rating"];

                                echo '<span>คะแนน : ' . number_format($averageRating, 2) . '/5 คะแนน | </span>';
                                if ($averageRating == 5) {
                                    echo '<span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>';
                                } elseif ($averageRating > 4) {
                                    echo '<span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star "></span>';
                                } elseif ($averageRating > 3) {
                                    echo '<span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>';
                                } elseif ($averageRating > 2) {
                                    echo '<span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>';
                                } elseif ($averageRating > 1) {
                                    echo '<span class="fa fa-star checked"></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>';
                                }
                                echo '<span id="rateMe4"  class="feedback"></span>';
                                echo "<p class='h4 mt-4 mb-3'>ความคิดเห็น</p>";
                                $commentCount = 0;

                                echo "<div class='comment-container px-2' >"; // Use 'auto' to enable scrolling
    
                                while ($comment = $resultComments->fetch_assoc()) {
                                    echo "<div class='mb-2'><p class='mb-0 text-secondary'>ความคิดเห็นที่ " . $commentCount + 1 . " : " . $comment['comment_text'] . "</p></div>";
                                    $commentCount++;
                                }

                                echo '</div>';

                                if ($commentCount > 3) {
                                    echo '<p style="font-size: 16px; color: gray; "></p>';
                                }

                            } else {
                                echo "ยังไม่มีความคิดเห็นสำหรับสถานประกอบการนี้";
                            }
                        }
                        ;
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo "ไม่พบคะแนนสถานประกอบการ";
                    }


                    $stmtAvgRating->close();
                }
            } else {
                header("location: index.php");

            }

            $stmt->close();
        } else {
            echo "Prepare statement error: " . $connection->error;

        }

        $connection->close();
    } else {
        echo "No workplace ID provided";
    }
    ?>
    <div class="text-center p-3 bg-primary text-white"">
        <header><a>&copy; วิทยาลัยเทคนิคหาดใหญ่</a></header>
    </div>
</body>
</html>