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
    $updatestatus = "SELECT COUNT(*) FROM comments";
    $stmt = $conn->query($updatestatus);
    $totalcomment = $stmt->fetchColumn();
    $commentData = $conn->query("SELECT * FROM comments")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <?php
    $limit = 12;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM comments");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();
    $totalPages = ceil($totalRows / $limit);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $limit;
    $stmt = $conn->prepare("SELECT * FROM comments ORDER BY comment_time DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $commentData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="flex-container">
        <div class="container p-0">
            <div class="my-3 bg-body  shadow">
                <div class=" justify-content-center ">
                    <div class="border p-0 ">
                        <p class='h4 py-2 px-auto bg-dark border text-white mb-0 text-center '>
                            เมนูแก้ไขข้อมูลสถานประกอบการ </p>
                        <div class="px-4">
                            <div class="">
                                <p class="fs-5 rounded p-1 px-3 m-0 form-control border-0 text-center">
                                    ความคิดเห็น :
                                    <?php echo $totalcomment; ?>
                                </p>
                            </div>
                            <div class="col">
                                <div class="table-responsive">
                                    <?php if ($totalcomment > 0): ?>
                                        <table class="table table-bordered table-sm m-0">
                                            <thead>
                                                <tr class="text-center text-light bg-dark col-12">
                                                    <th class='col-2'>รหัสนักศึกษา</th>
                                                    <th class='col-2'>รหัสสถานประกอบการ</th>
                                                    <th class='col-4'>ความคิดเห็น</th>
                                                    <th class='col-2'>เวลาแสดงความคิดเห็น</th>
                                                    <th class='col-1'>จัดการ</th>
                                                    <th class='col-1'>สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($commentData as $row): ?>
                                                    <tr class="text-left">
                                                        <td>
                                                            <?php echo $row['user_id']; ?>
                                                        </td>
                                                        <td class='text-center'>
                                                            <?php echo $row['workplace_id']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['comment_text']; ?>
                                                        </td>

                                                        <td class='text-center'>
                                                            <?php echo $row['comment_time']; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group ">
                                                                <a href="php/show-status.php?comment_id=<?php echo $row['comment_id']; ?>"
                                                                    class="btn btn-sm btn-warning">แก้ไขสถานะ</a>
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
        addClassToElement("cmtmanage");
    </script>
</body>

</html>