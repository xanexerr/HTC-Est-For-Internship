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
    $mapdata = '7.001266781370485, 100.47979575236882';

    $stmt_fetch_images = $connection->prepare("SELECT img FROM comments WHERE workplace_id = ?");
    $stmt_fetch_images->bind_param("s", $workplace_id);
    $stmt_fetch_images->execute();
    $stmt_fetch_images->bind_result($img_path);
    $images = array();
    while ($stmt_fetch_images->fetch()) {
        $images[] = $img_path;
    }
    $stmt_fetch_images->close();
    ?>
    <div class="flex-contairner min-vh-100">
        <div class="container  px-0 border   shadow rounded my-3 col-6 ">

            <p class='h4 py-2  bg-dark border text-white  mb-0 text-center  rounded-top'>รายละเอียด </p>
            <div class="p-5 ">


                <?php foreach ($workplacesData as $row): ?>
                    <p class="h1">
                        <?php echo $row['workplace_name']; ?>
                    </p>
                    <a class="h4 btn btn-primary"
                        href="index.php?work_type_filter=<?php echo $row['work_type']; ?>&sorting=newest&search_query=">ประเภทงาน
                        :
                        <?php echo $row['work_type']; ?>
                    </a>
                    <p class="h5">ลักษณะงาน :
                        <?php echo $row['description']; ?>
                    </p>
                    <p class="h5">เบอร์โทร :
                        <?php echo $row['work_tel']; ?>
                    </p>
                    <?php if ($row['map'] != '') { ?>
                        <a class="h4 btn btn-secondary" href="<?php echo $row['map']; ?>" target="_blank">ดูแผนที่สถานประกอบการ
                        </a>
                    <?php } ?>
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


                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-content">
                                <img class="modal-image" id="modalImage" alt="Full Image">
                            </div>
                        </div>
                        <script>
                            function openModal(imageSrc) {
                                var modal = document.getElementById('myModal');
                                var modalImage = document.getElementById('modalImage');

                                modalImage.src = imageSrc;
                                modal.style.display = 'flex';

                                window.onclick = function (event) {
                                    if (event.target == modal) {
                                        modal.style.display = 'none';
                                    }
                                };
                            }
                        </script>

                        <label class="h4 m-0">
                            คะแนนรีวิว :
                            <?php
                            if (isset($row['rating'])) {
                                $rating = $row['rating'];
                                if ($rating > 0) {
                                    echo "$rating" . "/5";
                                } else {
                                    echo "<span class='text-dark'> ยังไม่มีคะแนน </span> ";
                                }
                                if (is_numeric($rating) && $rating !== '') {
                                    $rating = (float) $rating;
                                    ?>
                                    <div class="star-widget fs-2 center text-warning">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            $difference = $rating - $i + 0.5;

                                            if ($difference >= 0.5) {
                                                echo "<i class='fas fa-star'></i>";
                                            } elseif ($difference > 0) {
                                                echo "<i class='fas fa-star-half'></i>";
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php

                                } else {
                                    echo "<span class='text-danger'> ยังไม่มีความคิดเห็นต่อสถานประกอบการ </span> ";
                                }
                            }
                            ?>
                            <div>
                                <div style="max-height: 500px; overflow-y: auto;">
                                    <?php
                                    if ($resultComments->num_rows > 0) {
                                        echo "<p class='h4 mt-1 '>ความคิดเห็น</p>";
                                        $commentCount = 0;

                                        while ($comment = $resultComments->fetch_assoc()) {
                                            if ($comment['comment_text'] !== null && $comment['comment_text'] !== '') {
                                                echo "<div class='mb-3 mt-0 mb-0 text-secondary m-5 '>";
                                                echo "<p class='h6 '>ความคิดเห็นที่ " . ($commentCount + 1) . " : " . $comment['comment_text'] . "</p>";
                                                echo "</div>";
                                                $commentCount++;
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php if (!empty($images)): ?>
                                <label class="h4 m-0">ภาพจากรุ่นก่อน</label>
                                <div class="image-gallery">
                                    <?php foreach ($images as $image): ?>
                                        <?php if ($image !== null): ?>
                                            <img src="img/<?php echo $image; ?>" alt="Workplace Image" class="gallery-image"
                                                onclick="openModal('img/<?php echo $image; ?>')">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['user_id'])) {
                    $stmt_userwp = $connection->prepare("SELECT workplace_id FROM users WHERE user_id = ?");
                    $stmt_userwp->bind_param("s", $user_id);
                    $stmt_userwp->execute();
                    $stmt_userwp = $stmt_userwp->get_result();
                    $wpresult = $stmt_userwp->fetch_assoc();
                    $workplace_id = $wpresult["workplace_id"];
                    if (isset($_GET['id'])) {
                        $workid = $_GET['id'];
                    }
                    if ($workplace_id === null && $_SESSION["role"] == 'student') { ?>
                        <form class="p-3" name="select_workplace_form" method="POST" action="php/update-wp-select.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="workplace" value="<?php echo $workid; ?>">
                            <button type="submit" value="submit" class="mt-3 btn btn-success w-100">เลือก
                                <?php echo $row["workplace_name"];
                                ; ?> เป็นสถานประกอบการของฉัน
                            </button>
                        </form>
                    <?php }
                }
                ?>
            </div>
            <div class="col-sm-8"></div>
        </div>
        </div>
    <?php endforeach ?>
    </div>
    <?php
    include 'script.php';
    ?>
</body>

</html>