<!DOCTYPE html>
<html lang="en">
<?php
include "header.php";
include "navbar.php";
?>

<body>
    <?php
    require 'connection.php';
    $workplace_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT COUNT(*) FROM workplaces ");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM workplaces WHERE `workplace_id` =  '$workplace_id' ");
    $stmt->execute();
    $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="container  px-0 border   shadow rounded my-3">
        <p class='h4 py-2  bg-dark border text-white  mb-0 text-center  rounded-top'>รายละเอียด </p>
        <div class="p-5 ">

            <?php foreach ($workplacesData as $row): ?>
                <p class="h1">
                    <?php echo $row['workplace_name']; ?>
                </p>
                <a class="h4 btn btn-primary"
                    href="index.php?search_query=&work_type_filter=<?php echo $row['work_type']; ?>">ประเภทงาน :
                    <?php echo $row['work_type']; ?>
                </a>
                <p class="h5">ลักษณะงาน :
                    <?php echo $row['description']; ?>
                </p>
                <p class="h5">เบอร์โทร :
                    <?php echo $row['work_tel']; ?>
                </p>
                <p class="h5">ที่อยู่ :
                    <?php echo $row['workplace_address']; ?>
                </p>
                <?php
                $queryComments = "SELECT comment_text FROM comments WHERE workplace_id = ? AND `show` = 1";
                $stmtComments = $connection->prepare($queryComments);

                if ($stmtComments) {
                    $stmtComments->bind_param("i", $workplace_id);
                    $stmtComments->execute();
                    $resultComments = $stmtComments->get_result();
                }

                ?>
                <div class="border rounded p-4 mt-5">
                    <label class="h4 m-0">
                        คะแนนรีวิว :
                        <?php
                        // Assuming $row['rating'] holds the rating value
                        if (isset($row['rating'])) {
                            $rating = $row['rating'];
                            if ($rating > 0) {
                                echo "$rating" . "/5";
                            }
                            // Check if $rating is numeric and not empty before using str_repeat
                            if (is_numeric($rating) && $rating !== '') {
                                // Convert $rating to an integer to ensure it's a whole number
                                $rating = (int) $rating;
                                ?>
                                <?php

                                // Output stars based on the rating
                                echo '<div class="h4 my-2">' .
                                    str_repeat("⭐", $rating) . '
                            </div>';
                            } else {
                                echo "<span class='text-danger'> ยังไม่มีความคิดเห็นต่อสถานประกอบการ </span> ";
                            }
                        }
                        ?>
                        <div>

                            <?php
                            if ($resultComments->num_rows > 0) {
                                echo "<p class='h4 '>ความคิดเห็น</p>";
                                $commentCount = 0;
                                while ($comment = $resultComments->fetch_assoc()) {
                                    echo "<div class='mb-3 mt-0 mb-0 text-secondary m-5 '>";
                                    echo " <p class='h6 '>ความคิดเห็นที่ " . ($commentCount + 1) . " : " . $comment['comment_text'] . "</p>";
                                    echo " </div>";
                                    $commentCount++;
                                }
                            } else {

                            }
                            ?>

                        </div>
                </div>
            </div>


        </div>
        <div class="col-sm-8"></div>


        </div>

        </div>



        </div>
    <?php endforeach ?>
    </div>
    <?php
    include 'script.php';
    ?>
</body>

</html>