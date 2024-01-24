<!DOCTYPE html>
<html lang="en">
<?php
include("header.php");
?>

<body>
    <?php
    include("navbar.php");
    ?>
    <div
        class="row flex-lg-row container rounded d-flex  mx-auto my-4 justify-content-evenly align-items-center  flex-md-column flex-column  min-vh-100">
        <div class="card col-lg-3 col-6 p-0 mb-4" style="height: fit-content; ">
            <img class="rounded-top" src="img/xan.jpg" alt="sand"
                style="width:100%; aspect-ratio: 3.6/4; object-fit:cover" />
            <p class="card-title text-center fs-4 mt-2 mb-0">
                นายณัฐภูมินทร์ กล่ำมาตย์</p>

            <div class="card-text text-center d-inline mx-auto mb-3">
                <p class="card-text mb-0">ข้อมูลติดต่อ</p>
                <a class="text-dark fs-3 px-1" href="https://github.com/xanexerr" aria-label="github" target="_Blank">
                    <i class="fa fa-github"></i></a>
                <a class="text-dark fs-3  px-1" href="https://www.facebook.com/natthapumin.klammat/"
                    aria-label="facebook" target="_Blank">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            </div>

        </div>
        <div class="card col-lg-3  col-6  mb-3 p-0 " style="height: fit-content; ">
            <img class="rounded-top" src="img/handsome.jpg" alt="champ"
                style="width:100%; aspect-ratio: 3.6/4; object-fit:cover" />
            <p class="card-title text-center fs-4 mt-2 mb-0">
                นายธีรภัทร แซ่ตั้ง</p>
            <div class="card-text text-center d-inline mx-auto mb-3">
                <p class="card-text mb-0">ข้อมูลติดต่อ</p>
                <a class="text-dark fs-3  px-1" href="https://www.facebook.com/profile.php?id=100005825707675"
                    aria-label="facebook" target="_blank">
                    <i class="fa-brands fa-facebook"></i>
                </a>

            </div>

        </div>

        <div class="card col-lg-3  col-6  mb-3 p-0 " style="height: fit-content; ">
            <img class="rounded-top" src="img/bast.jpg" alt="bas"
                style="width:100%; aspect-ratio: 3.6/4; object-fit:cover" />
            <p class="card-title text-center fs-4 mt-2 mb-0">
                นายธนชาต นามเจริญ</p>

            <div class="card-text text-center d-inline mx-auto mb-3">
                <p class="card-text mb-0">ข้อมูลติดต่อ</p>
                <a class="text-dark fs-3  px-1" href="https://www.facebook.com/thanachart.namcharoen"
                    aria-label="facebook" target="_blank">
                    <i class="fa-brands fa-facebook"></i></a>
            </div>

        </div>

    </div>
    <?php include 'script.php'; ?>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        addClassToElement("about");
    });
</script>

</html>