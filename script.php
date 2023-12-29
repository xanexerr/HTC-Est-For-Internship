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
<script>
    function updateItemsPerPage(select) {
        var selectedValue = select.value;
        window.location.href = window.location.pathname + '?itemsPerPage=' + selectedValue;
    }
</script>
<?php
if (isset($_SESSION["user_id"])) {

} else {
    echo '<nav class="bg-warning d-flex justify-content-center  px-5">';
    echo '<div class="">
        <a href="#" class="p-2 px-3 btn btn-warning mx-1">ลงทะเบียนใช้งานระบบ | ติดต่อทีมงาน</a>
        </div>';
    echo '</nav>';
}
?>
<div class="text-center p-3 bg-primary text-white"">
        <a>&copy; วิทยาลัยเทคนิคหาดใหญ่</a>
    </div>

