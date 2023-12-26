<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<style>
    body {
        padding: 0;
        margin: 0;
        align-items: center;
        align-content: center;
    }
</style>

<body>
    <p class="h2 text-center">ระบบเพิ่มสถานประกอบการ</p>
    <div class="d-flex text-start align-content-center justify-content-center form ">
        <form class="border p-3 align-content-center shadow" action="php/admin-add-wp.php" name="addwp" method="POST">

            <label>ชื่อสถานประกอบการ</label> <br>
            <input class="form-control" type="text" name="wp_name">
            <br>
            <label>ประเภทงาน</label>
            <select class="form-control" name="work_type">';
                <option value="เขียนโปรแกรม">เขียนโปรแกรม</option>
                <option value="ทำกราฟิก">ทำกราฟิก</option>
                <option value="ระบบเครือข่าย">ระบบเครือข่าย</option>
                <option value="ทำเว็บไซต์">ทำเว็บไซต์</option>
                <option value="ด้านบริการ">ด้านบริการ</option>
                <option value="อื่นๆ">อื่นๆ</option>

            </select>
            <br>
            <label>ลักษณะงาน</label><br>
            <input type="text" name="wp_des">
            <br>
            <label>ที่อยู่</label><br>
            <textarea class="form-control" type="text" name="wp_address"></textarea>

            <br>
            <label>เบอร์โทร</label><br>
            <input type="text" name="wp_tel">
            <br>
            <input type="submit" name="submit">
        </form>
    </div>


</body>

</html>