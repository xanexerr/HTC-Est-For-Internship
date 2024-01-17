<?php
if (!isset($_SESSION["user_id"])) {
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
} else {
    if ($_SESSION["role"] !== 'admin') {
        echo '<script>';
        echo 'Swal.fire({
            title: "คุณไม่มีสิทธิเข้าถึง!",
            icon: "warning",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php";
                }
            });';
        echo '</script>';
        exit();
    }
}
?>