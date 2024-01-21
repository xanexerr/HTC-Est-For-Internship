<!DOCTYPE html>
<html lang="en">

<!-- header  -->

<?php include 'header.php'; ?>
<style>
    .star-widget input {
        display: none;
    }

    .star-widget label {
        font-size: 2rem;
        color: #444;
        float: right;
        transition: all 0.2s ease;
        margin: 2px;
    }

    .star-widget input:not(:checked)~label:hover,
    .star-widget input:not(:checked)~label:hover~label {
        color: #fd4;
    }

    input:checked~label {
        color: #fd4;
    }

    input#rate-2:checked~label {
        color: #fd4;
        text-shadow: 0 0 3px #444;
    }

    input#rate-3:checked~label {
        color: #fd4;
        text-shadow: 0 0 5px #440;
    }

    input#rate-4:checked~label {
        color: #fd4;
        text-shadow: 0 0 7px #F0F;
    }

    input#rate-5:checked~label {
        color: #fd4;
        text-shadow: 0 0 10px #F00;
    }
</style>
<!-- body -->

<body>
    <!-- top banner  -->
    <?php
    include 'navbar.php';
    if (!isset($_SESSION['user_id'])) {
        echo '<script>';
        echo 'Swal.fire({
        title: "คุณยังไม่ได้เข้าสู่ระบบ",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "login.php";
            }
        });';
        echo '</script>';
        exit();
    }
    $user_id = $_SESSION["user_id"];

    $get_user_workplace = "SELECT* FROM workplaces WHERE user_id = ?";
    $stmt_usercomment = $connection->prepare($get_user_workplace);
    $stmt_usercomment->bind_param("s", $user_id);
    $stmt_usercomment->execute();
    $result = $stmt_usercomment->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $workplace_id = $row['workplace_id'];
        $workplace_name = $row['workplace_name'];
        $workplace_address = $row['workplace_address'];
        $work_type = $row['work_type'];
        $description = $row['description'];
        $work_tel = $row['work_tel'];
        $new_user_id = $row['user_id'];
        $map = $row['map'];
    }
    $getusercomment = "SELECT * FROM comments WHERE user_id = $user_id";
    $getusercomment = $conn->prepare($getusercomment);
    $stmt_usercomment->execute();
    $usercomment = $stmt_usercomment->get_result();
    $com = $usercomment->fetch_assoc();

    $stmt_userwp = $connection->prepare("SELECT workplace_id FROM users WHERE user_id = ?");
    $stmt_userwp->bind_param("s", $user_id);
    $stmt_userwp->execute();
    $stmt_userwp = $stmt_userwp->get_result();
    $wpresult = $stmt_userwp->fetch_assoc();
    $workplace_id = $wpresult["workplace_id"];
    ?>
    <!-- เพิ่มcomment modal -->
    <div class="modal fade" id="usermodal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แสดงความคิดเห็น</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="php/insertcm.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="workplace_id" readonly value="<?php echo $workplace_id; ?> ">
                        <input type="hidden" value="<?php echo $user_id; ?>">
                        <input type="hidden" value="<?php echo $workplace_id; ?>">
                        <label for="rating" class="col-form-label">ให้คะแนนสถานประกอบการ</label>
                        <div class="d-flex align-items-center justify-content-start">
                            <div class="star-widget center">
                                <input type="radio" name="rate" id="rate-5" value="5">
                                <label for="rate-5" class="fas fa-star"></label>
                                <input type="radio" name="rate" id="rate-4" value="4">
                                <label for="rate-4" class="fas fa-star"></label>
                                <input type="radio" name="rate" id="rate-3" value="3">
                                <label for="rate-3" class="fas fa-star"></label>
                                <input type="radio" name="rate" id="rate-2" value="2">
                                <label for="rate-2" class="fas fa-star"></label>
                                <input type="radio" name="rate" id="rate-1" value="1">
                                <label for="rate-1" class="fas fa-star"></label>
                            </div>
                        </div>
                        <script>
                            document.querySelectorAll('.star-widget label').forEach(function (label) {
                                label.addEventListener('click', function () {
                                    var selectedRating = this.getAttribute('for').split('-')[1];
                                    document.getElementById('selectedRating').value = selectedRating;
                                });
                            });
                        </script>
                        <div class="mb-3">
                            <label for="comment" class="col-form-label">ความคิดเห็น :</label>
                            <textarea class="form-control" name="comment" rows="3" style="resize: vertical;"
                                required></textarea>

                        </div>
                        <div class="mb-3">
                            <label for="img" class="col-form-label">เพิ่มรูปภาพ</label>
                            <input type="file" require class="form-control" id="imgInput" name="img">
                            <img width="100%" id="previewImg" alt="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button button type="submit" name="submit" class="btn btn-success">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--แก้ไข comment modal -->
    <div class="modal fade" id="usereditcomment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขความคิดเห็น</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $stmt_userwp = $connection->prepare("SELECT workplace_id FROM users WHERE user_id = ?");
                    $stmt_userwp->bind_param("s", $user_id);
                    $stmt_userwp->execute();
                    $stmt_userwp = $stmt_userwp->get_result();
                    $wpresult = $stmt_userwp->fetch_assoc();
                    $workplace_id = $wpresult["workplace_id"];
                    if ($workplace_id !== null) {
                        $getusercomment = "SELECT * FROM comments WHERE user_id = $user_id";
                        $getusercomment = $conn->prepare($getusercomment);
                        $stmt_usercomment->execute();
                        $usercomment = $stmt_usercomment->get_result();
                        $com = $usercomment->fetch_assoc();
                        $comrate = $com["rating"];
                        $comtext = $com["comment_text"];
                    }
                    ?>
                    <form action="insertcm.php" method="post" enctype="multipart/form-data">
                        <input type="text" value="<?php echo $workplace_id; ?>">
                        <input type="text" value="<?php echo $user_id; ?>">
                        <label for="rating" class="col-form-label">ให้คะแนนสถานประกอบการ</label>
                        <div class="d-flex align-items-center justify-content-start">
                            <div class="star-widget center">
                                <input type="radio" name="rate" id="rate-5" value="5">
                                <label for="rate-5" class="fas fa-star"></label>
                                <input type="radio" name="rate" id="rate-4" value="4">
                                <label for="rate-4" class="fas fa-star"></label>
                                <input type="radio" name="rate" id="rate-3" value="3">
                                <label for="rate-3" class="fas fa-star"></label>
                                <input type="radio" name="rate" id="rate-2" value="2">
                                <label for="rate-2" class="fas fa-star"></label>
                                <input type="radio" name="rate" id="rate-1" value="1">
                                <label for="rate-1" class="fas fa-star"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="col-form-label">ความคิดเห็น :</label>
                            <input type="text" require class="form-control" name="comment"
                                value="<?php echo $comtext; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="col-form-label">เพิ่มรูปภาพ</label>
                            <input type="file" require class="form-control" id="imgInput" name="img" required>
                            <img width="100%" id="previewImg" alt="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button button type="submit" name="submit" class="btn btn-success">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="usermodal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มสถานประกอบการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insertwp.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="workplace_name" class="col-form-label">ชื่อบริษัท:</label>
                            <input type="text" require class="form-control" name="workplace_name">
                        </div>
                        <div class="mb-3">
                            <label for="workplace_address" class="col-form-label">ที่อยู่บริษัท:</label>
                            <input type="text" require class="form-control" name="workplace_address">
                        </div>
                        <div class="mb-3">
                            <label for="work_type" class="col-form-label">ประเภทงาน:</label>
                            <?php
                            echo '<select class="form-control" name="work_type">';
                            echo '<option value="เขียนโปรแกรม"' . ($row['work_type'] === 'เขียนโปรแกรม' ? ' selected' : '') . '>เขียนโปรแกรม</option>';
                            echo '<option value="ทำกราฟิก"' . ($row['work_type'] === 'ทำกราฟิก' ? ' selected' : '') . '>ทำกราฟิก</option>';
                            echo '<option value="ระบบเครือข่าย"' . ($row['work_type'] === 'ระบบเครือข่าย' ? ' selected' : '') . '>ระบบเครือข่าย</option>';
                            echo '<option value="ทำเว็บไซต์"' . ($row['work_type'] === 'ทำเว็บไซต์' ? ' selected' : '') . '>ทำเว็บไซต์</option>';
                            echo '<option value="ด้านบริการ"' . ($row['work_type'] === 'ด้านบริการ' ? ' selected' : '') . '>ด้านบริการ</option>';
                            echo '<option value=""' . ($row['work_type'] === '' ? ' selected' : '') . '>อื่นๆ</option>';
                            echo '</select>';
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="work_des" class="col-form-label">ลักษณะงาน:</label>
                            <input type="text" require class="form-control" name="work_des">
                        </div>
                        <div class="mb-3">
                            <label for="workplace_tel" class="col-form-label">เบอร์โทรติดต่อ:</label>
                            <input type="text" require class="form-control" name="workplace_tel">
                        </div>

                        <div class="form-group">
                            <label for="map">แผนที่</label>
                            <input type="text" class="form-control" name="map" id="map" rows="4">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button button type="submit" name="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- content -->
    <div class="flex-container">
        <div class="container ">
            <?php if ($result->num_rows > 0) { ?>
                <div class="my-3 bg-body  shadow  col-6  mx-auto">
                    <p class='h4 py-2 px-auto bg-dark border text-white mb-0 text-center'>
                        เมนูแก้ไขข้อมูลสถานประกอบการ </p>
                    <form class="border p-3" name="edit_workplace_form" method="POST" action="php/update-wp-data.php"
                        enctype="multipart/form-data">
                        <label for="workplace_name" class="form-label">ชื่อสถานประกอบการ</label>
                        <input type="text" class="form-control" name="workplace_name" value="<?= $workplace_name ?>"
                            required>
                        <label for="work_type" class="form-label mt-1">ประเภทงาน</label>
                        <select class="form-control" name="work_type">
                            <option value="เขียนโปรแกรม" <?= ($row['work_type'] === 'เขียนโปรแกรม' ? ' selected' : '') ?>>
                                เขียนโปรแกรม</option>
                            <option value="ทำกราฟิก" <?= ($row['work_type'] === 'ทำกราฟิก' ? ' selected' : '') ?>>ทำกราฟิก
                            </option>
                            <option value="ระบบเครือข่าย" <?= ($row['work_type'] === 'ระบบเครือข่าย' ? ' selected' : '') ?>>
                                ระบบเครือข่าย</option>
                            <option value="ทำเว็บไซต์" <?= ($row['work_type'] === 'ทำเว็บไซต์' ? ' selected' : '') ?>>
                                ทำเว็บไซต์</option>
                            <option value="ด้านบริการ" <?= ($row['work_type'] === 'ด้านบริการ' ? ' selected' : '') ?>>
                                ด้านบริการ</option>
                            <option value="" <?= ($row['work_type'] === '' ? ' selected' : '') ?>>อื่นๆ</option>
                        </select>
                        <label for="description" class="form-label mt-1">ลักษณะงาน</label>
                        <input type="text" class="form-control" name="description" value="<?= $description ?>" required>

                        <label for="work_tel" class="form-label mt-1">เบอร์โทรติดต่อ</label>
                        <input type="text" class="form-control" name="work_tel" value="<?= $work_tel ?>" required>

                        <label for="workplace_address" class="form-label mt-1">ที่อยู่บริษัท</label>
                        <textarea class="form-control" name="workplace_address" rows="5"
                            required><?= $workplace_address ?></textarea>

                        <div class="form-group">
                            <label for="map">แผนที่</label>
                            <input type="text" class="form-control" name="map" id="map" rows="4" value="<?= $map ?>">
                        </div>

                        <button type="submit" value="submit"
                            class="mt-3 btn btn-success w-100">บันทึกการเปลี่ยนแปลง</button>

                        <div class="d-flex flex-column justify-content-end mt-1" style="height: 100%;">
                            <?php if ($usercomment->num_rows > 0): ?>
                                <a href="#" type="button" class="btn btn-primary w-100">แก้ไขความคิดเห็น</a>
                            <?php else: ?>
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#usermodal1">เพิ่มความคิดเห็น</button>
                            <?php endif; ?>
                        </div>
                        <a href="index.php" class="mt-1 btn btn-danger w-100">ยกเลิก</a>
                    </form>
                </div>
            <?php } else {
                $stmt_userwp = $connection->prepare("SELECT workplace_id FROM users WHERE user_id = ?");
                $stmt_userwp->bind_param("s", $user_id);
                $stmt_userwp->execute();
                $stmt_userwp = $stmt_userwp->get_result();
                $wpresult = $stmt_userwp->fetch_assoc();
                $workplace_id = $wpresult["workplace_id"];
                if ($workplace_id !== null) {
                    $get_user_workplace = "SELECT * FROM workplaces WHERE workplace_id = ?";
                    $stmt_usercomment = $connection->prepare($get_user_workplace);
                    $stmt_usercomment->bind_param("s", $workplace_id);
                    $stmt_usercomment->execute();
                    $result = $stmt_usercomment->get_result();
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="my-3 bg-body  shadow  col-6   mx-auto">
                        <p class='h4 py-2 px-auto bg-dark border text-white mb-0 text-center'>สถานประกอบการของคุณ </p>
                        <div class='p-4'>
                            <p class="h1 mt-3 mb-3">
                                <?php echo $row['workplace_name']; ?>
                            </p>
                            <p>ประเภทงาน :
                                <?php echo $row['work_type']; ?>
                            </p>
                            <p>รายละเอียดงาน :
                                <?php echo $row['description']; ?>
                            </p>
                            <p>เบอร์ติดต่อ :
                                <?php echo $row['work_tel']; ?>
                            </p>
                            <p>ที่อยู่:
                                <?php echo $row['workplace_address']; ?>
                            </p>
                            <?php if ($usercomment->num_rows > 0): ?>
                                <a href="std-edit-cm.php" type="button" class="btn btn-primary w-100">แก้ไขความคิดเห็น
                                    <?php $usercomment ?>
                                </a>
                            <?php else: ?>
                                <a href="std-add-cm.php" type="button" class="btn btn-primary w-100">เพิ่มความคิดเห็น</a>
                            <?php endif; ?>
                            <a href="index.php" class="mt-1 btn btn-danger w-100">ยกเลิก</a>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="my-3 bg-body    col-6  vh-100 mx-auto">
                    <script>
                        Swal.fire({
                            icon: 'info',
                            title: 'ไม่พบข้อมู!',
                            text: "กรุณาเลือกสถานประกอบการของคุณก่อน!",
                            showConfirmButton: true,
                            onClose: () => {
                                window.location.href = 'index.php';
                            }
                        });
                    </script>

                </div>
            </div>
        <?php }
            } ?>

    <?php
    include 'script.php';
    ?>
    <script type="text/javascript">
        addClassToElement("std-edit");
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }


        $(document).ready(function () {
            $('select[name="workplace"]').select2();
        });
    </script>

</body>

</html>