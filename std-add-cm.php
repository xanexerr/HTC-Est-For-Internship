<?php
include 'header.php';
?>
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
        text-shadow: 0 0 2px #FFD700;
        transform: scale(1.03);
    }

    input#rate-3:checked~label {
        color: #fd4;
        text-shadow: 0 0 3px #FFD700;
        transform: scale(1.05);
    }

    input#rate-4:checked~label {
        color: #fd4;
        text-shadow: 0 0 4px #FFD700;
        transform: scale(1.07);
    }

    input#rate-5:checked~label {
        color: #fd4;
        text-shadow: 0 0 5px #FFD700;
        transform: scale(1.1);
    }
</style>
<?php include 'navbar.php';
$stmt_userwp = $connection->prepare("SELECT workplace_id FROM users WHERE user_id = ?");
$stmt_userwp->bind_param("s", $user_id);
$stmt_userwp->execute();
$stmt_userwp = $stmt_userwp->get_result();
$wpresult = $stmt_userwp->fetch_assoc();
$workplace_id = $wpresult["workplace_id"];
?>
<div class="flex-container">
    <div class="container ">
        <div class="my-3 bg-body  shadow  col-6  mx-auto">
            <p class='h4 py-2 px-auto bg-dark border text-white mb-0 text-center'>
                แสดงความคิดเห็น </p>
            <div class="p-3">
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
                    <button button type="submit" name="submit" class="btn btn-success w-100 ">ยืนยัน</button>
                    <a href="std-wp-edit.php" type="button" class="btn btn-secondary w-100 mt-1">ยกเลิก</a>
                </form>
            </div>
        </div>
    </div>
</div>