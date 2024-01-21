<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<body>
    <!-- ตรวจสอ login & role-->
    <?php
    require('connection.php');
    include 'navbar.php';
    include('php/admin-check.php');
    ?>
    <?php
    $updatestatus = "SELECT COUNT(*) FROM workplaces";
    $stmt = $conn->query($updatestatus);
    $totalWorkplaces = $stmt->fetchColumn();
    $workplacesData = $conn->query("SELECT * FROM workplaces")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <?php
    $limit = 12;
    if (isset($_GET['search_query'])) {
        $search_query = $_GET['search_query'];
        $work_type_filter = ($_GET['work_type_filter']);
        if (isset($_GET['work_type_filter']) && !empty($_GET['work_type_filter'])) {
            $work_type_filter = $_GET['work_type_filter'];
            $query = "SELECT * FROM workplaces WHERE workplace_name LIKE ? AND work_type = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute(["%$search_query%", $work_type_filter]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM workplaces WHERE workplace_name LIKE ?");
            $stmt->execute(["%$search_query%"]);
        }
        $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $totalRows = $stmt->rowCount();
        $totalPages = ceil($totalRows / $limit);
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $limit;
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM workplaces ");
        $stmt->execute();
        $totalRows = $stmt->fetchColumn();
        $totalPages = ceil($totalRows / $limit);
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $limit;
        $stmt = $conn->prepare("SELECT * FROM workplaces LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>
    <div class="flex-container">
        <div class="container p-0">
            <div class="my-3 bg-body  shadow">
                <div class=" justify-content-center ">
                    <div class="border p-0 ">
                        <p class='h4 py-2 px-auto bg-dark text-white mb-0 text-center '>
                            เมนูแก้ไขข้อมูลสถานประกอบการ </p>
                        <form class="m-0 rounded-0 " method="GET">

                            <div class="input-group container  bg-secondary p-3 ">
                                <div class="col col-lg-2 col-md-auto ">
                                    <select class="form-control rounded-0  h-100 rounded-start " name="work_type_filter"
                                        onchange="this.form.submit()">
                                        <option value="">ประเภทงานทั้งหมด</option>
                                        <option value="เขียนโปรแกรม" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'เขียนโปรแกรม')
                                            echo 'selected'; ?>>ประเภทงานเขียนโปรแกรม
                                        </option>
                                        <option value="ทำกราฟิก" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ทำกราฟิก')
                                            echo 'selected'; ?>>ประเภทงานทำกราฟิก</option>
                                        <option value="ระบบเครือข่าย" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ระบบเครือข่าย')
                                            echo 'selected'; ?>>ประเภทงานระบบเครือข่าย
                                        </option>
                                        <option value="ทำเว็บไซต์" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ทำเว็บไซต์')
                                            echo 'selected'; ?>>ประเภทงานทำเว็บไซต์
                                        </option>
                                        <option value="ด้านบริการ" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ด้านบริการ')
                                            echo 'selected'; ?>>ประเภทงานด้านบริการ
                                        </option>
                                    </select>
                                </div>
                                <input type="text" class="form-control rounded-0 " placeholder="ค้นหาสถานประกอบการ...."
                                    name="search_query" value="<?php if (isset($search_query)) {
                                        echo $search_query;
                                    }
                                    ?>">
                                <button class="btn btn-primary rounded-0 px-3 col-2 rounded-end" type="submit"
                                    style="font-size: 1em;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                                        class="bi bi-search d-md-inline" viewBox="0 0 16 16"
                                        style="vertical-align: middle;">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                    </svg>
                                    ค้นหา
                                </button>
                            </div>
                        </form>
                        <div class="col  text-center bg-dark px-4 mx-auto">
                            <a href="admin-add-form.php" class="text-white btn btn-none ">เพิ่มสถานประกอบการ</a>
                        </div>
                        <div class="px-4">
                            <div class="">
                                <p class="fs-5 rounded p-1 px-3 m-0 form-control border-0 text-center">
                                    จำนวนสถานประกอบการ :
                                    <?php echo $totalWorkplaces; ?>
                                </p>
                            </div>
                            <div class="col">
                                <div class="table-responsive">
                                    <?php if ($totalWorkplaces > 0): ?>
                                        <table class="table table-bordered table-sm m-0">
                                            <thead>
                                                <tr class="text-center text-light bg-dark col-12">
                                                    <th class='col-1'>#</th>
                                                    <th class='col-2'>ชื่อสถานประกอบการ</th>
                                                    <th class='col-1'>ประเภทงาน</th>
                                                    <th class='col-3'>รายละเอียด</th>
                                                    <th class='col-2'>จัดการ</th>
                                                    <th class='col-1'>สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($workplacesData as $row): ?>
                                                    <tr class="text-left">
                                                        <td class='text-center'>
                                                            <?php echo $row['workplace_id']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['workplace_name']; ?>
                                                        </td>
                                                        <td class='text-center'>
                                                            <?php echo $row['work_type']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['description']; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group  ">
                                                                <a class="btn btn-sm btn-primary"
                                                                    href="wp-detail.php?id=<?php echo $row['workplace_id']; ?>">รายละเอียด
                                                                </a>
                                                                <a href="admin-wp-edit.php?id=<?php echo $row['workplace_id']; ?>"
                                                                    class="btn btn-sm btn-warning">แก้ไขข้อมูล</a>
                                                            </div>
                                                        </td>

                                                        <td class="text-center <?php echo ($row['show'] == 1) ? ' bg-success text-white' : 'bg-danger text-white'; ?>"
                                                            style="vertical-align: middle;">
                                                            <p class="m-0">
                                                                <?php echo ($row['show'] == 1) ? 'แสดง' : 'ไม่แสดง'; ?>
                                                            </p>
                                                        </td>


                                                    </tr>
                                                    <div class="modal fade" id="my-modal<?php echo $row['workplace_id']; ?>"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    </div>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p class='mt-5'>No data available</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="container my-3 ">
                            <nav aria-label=" Page navigation example">
                                <ul class="pagination justify-content-center m-0">
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link bg-dark text-white"
                                                href="?page=<?php echo ($currentPage - 1); ?>" aria-label="Previous">
                                                <span aria-hidden="true">
                                                    &#60;
                                                </span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                            <a class="page-link  " href="?page=<?php echo $i; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link bg-dark text-white"
                                                href="?page=<?php echo ($currentPage + 1); ?>" aria-label="Next">
                                                <span aria-hidden="true"> &#62;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    include "script.php";
    ?>
    <script>
        addClassToElement("wmanage");
    </script>
</body>

</html>