<!-- ไว้ใส่ script ต่างๆ -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function updateItemsPerPage(select) {
        var selectedValue = select.value;
        window.location.href = window.location.pathname + '?itemsPerPage=' + selectedValue;
    }
</script>
<div class="text-center p-3 bg-primary text-white"">
        <a>&copy; วิทยาลัยเทคนิคหาดใหญ่</a>
    </div>