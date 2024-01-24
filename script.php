<!-- ไว้ใส่ script ต่างๆ -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    function updateItemsPerPage(select) {
        var selectedValue = select.value;
        window.location.href = window.location.pathname + '?itemsPerPage=' + selectedValue;
    }
    function addClassToElement(elementId) {
        var element = document.getElementById(elementId);
        if (element) {
            element.classList.add("disabled");
        }
    }
</script>





<?php
if (isset($_SESSION["user_id"])) {

} else {
    echo '<nav class="bg-warning d-flex justify-content-center  px-5 ">';
    echo '<div class="w-100">
        <a href="https://forms.gle/MJ74K2imzm8DAvkp6" class="p-2 px-3 btn btn-warning mx-1 w-100" target="_blank">ลงทะเบียนใช้งานระบบ | ติดต่อทีมงาน</a>
        </div>';
    echo '</nav>';
}
?>
<footer class=" text-white bg-primary p-4   ">
    <div class="container ">
        <p class="text-center mb-0">&copy; วิทยาลัยเทคนิคหาดใหญ่</p>
    </div>

</footer>