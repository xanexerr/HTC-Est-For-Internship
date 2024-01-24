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

$getusercomment = "SELECT * FROM comments WHERE user_id = ?";
$stmt_usercomment = $connection->prepare($getusercomment);
$stmt_usercomment->bind_param("s", $user_id);
$stmt_usercomment->execute();
$usercomment = $stmt_usercomment->get_result();
$com = $usercomment->fetch_assoc();
$comrate = $com["rating"];
$comtext = $com["comment_text"];
if (isset($com["img"])) {
    $u_image = $com["img"];
}

?>
<div class="flex-container min-vh-100">
    <div class="container ">
        <div class="my-3 bg-body  shadow  col-6  mx-auto">
            <p class='h4 py-2 px-auto bg-dark border text-white mb-0 text-center'>
                แสดงความคิดเห็น </p>
            <div class="p-3">
                <form action="php/updatecm.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="workplace_id" readonly value="<?php echo $workplace_id; ?> ">
                    <input type="hidden" value="<?php echo $user_id; ?>">
                    <input type="hidden" value="<?php echo $workplace_id; ?>">
                    <input type="hidden" value="<?php echo $comrate; ?>">
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
                        <textarea maxlength="250" class="form-control" name="comment" rows="3" style="resize: vertical;"
                            required><?php echo $comtext; ?></textarea>

                    </div>
                    <div class="mb-3">
                        <label for="img" class="col-form-label">แก้ไขรูปภาพ</label>
                        <input type="file" required class="form-control" id="imgInput" name="img"
                            onchange="previewImage(event)">

                        <img id="imgPreview" alt="Preview Image"
                            style="width: 100% ;margin-top: 10px; display: none; align-items-center">

                        <input type="hidden" name="old_img" value="<?php echo isset($u_image) ? $u_image : ''; ?>">
                    </div>
                    <button button type="submit" name="submit" class="btn btn-success w-100 ">ยืนยัน</button>
                    <a href="std-wp-edit.php" type="button" class="btn btn-secondary w-100 mt-1">ยกเลิก</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'script.php'; ?>
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imgPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>