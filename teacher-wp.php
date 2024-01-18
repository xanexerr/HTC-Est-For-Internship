<!DOCTYPE html>
<html lang="en">

<?php
include 'header.php';
?>

<body>
    <?php
    include 'navbar.php';
    $limit = 12;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM workplaces WHERE user_id = '$user_id'");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();
    $totalPages = ceil($totalRows / $limit);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $limit;
    $stmt = $conn->prepare("SELECT * FROM workplaces WHERE user_id = '$user_id' ORDER BY `workplace_id` DESC LIMIT :limit OFFSET :offset ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $totalWorkplaces = $stmt->fetchColumn();
    $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="flex-container">
        <div class="container vh-100 ">
            <div class="my-3 bg-body  shadow">
                <div class=" justify-content-center ">
                    <div class="border p-0 ">
                        <p class='h4 py-2 px-auto bg-dark text-white mb-0 text-center '>
                            จัดการสถานประกอบการของฉัน</p>


                        <div class="col  text-center bg-warning px-4 mx-auto">
                            <a href="teacher-add-form.php" class=" btn btn-none border-dark">เพิ่มสถานประกอบการ</a>
                        </div>

                        <div class="px-4">

                            <div class="col">
                                <div class="table-responsive">
                                    <?php if ($totalWorkplaces > 0) { ?>
                                        <table class="table table-bordered table-sm m-0">
                                            <thead>
                                                <tr class="text-center text-light bg-dark col-12">
                                                    <th class='col-1'>#</th>
                                                    <th class='col-2'>ชื่อสถานประกอบการ</th>
                                                    <th class='col-1'>ประเภทงาน</th>
                                                    <th class='col-3'>รายละเอียด</th>
                                                    <th class='col-2'>จัดการ</th>
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
                                                                <a href="teacher-wp-edit.php?id=<?php echo $row['workplace_id']; ?>"
                                                                    class="btn btn-sm btn-warning">แก้ไขข้อมูล</a>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <div class="modal fade" id="my-modal<?php echo $row['workplace_id']; ?>"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    </div>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php } else {
                                        echo "<script src='path/to/sweetalert.min.js'></script>";
                                        echo "<script>
            Swal.fire({
                icon: 'info',
                title: 'ไม่พบข้อมูลสถานประกอบการ',
                showConfirmButton: true,
                onClose: () => {
                    // Additional code to run when the alert is closed (if needed)
                }
            });
            </script>";
                                        ?>

                                    <?php } ?>
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
        <?php include 'script.php'; ?>
</body>

</html>