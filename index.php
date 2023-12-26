<?php
require('connection.php');
include 'header.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container  shadow-sm p-0">
        <div class="bg-body " style="min-height:100dvh;">
            <?php

            $limit = 12;

            if (isset($_GET['search_query'])) {
                // Get search query
                $search_query = $_GET['search_query'];
                $work_type_filter = ($_GET['work_type_filter']);
                // Check if a work type filter is set
                if (isset($_GET['work_type_filter']) && !empty($_GET['work_type_filter'])) {
                    $work_type_filter = $_GET['work_type_filter'];
                    $query = "SELECT * FROM workplaces WHERE workplace_name LIKE ? AND work_type = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(["%$search_query%", $work_type_filter]);
                } else {
                    // No work type filter, retrieve all workplaces
                    $stmt = $conn->prepare("SELECT * FROM workplaces WHERE workplace_name LIKE ?");
                    $stmt->execute(["%$search_query%"]);
                }

                $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $totalRows = $stmt->rowCount();

                // Redirect if search query is empty
                if ($search_query == '' && $work_type_filter == '') {
                    echo '<script>window.location.href = "index.php";</script>';
                    exit();
                }

                // Pagination logic (assuming $limit, $currentPage, and $offset are defined)
                $totalPages = ceil($totalRows / $limit);
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($currentPage - 1) * $limit;

                // Display message if no workplaces are found
                if (empty($workplacesData)) {
                    echo '<script>';
                    echo 'alert("ไม่พบสถานประกอบการ!!");';
                    echo 'window.location.href = "index.php";';
                    echo '</script>';
                }

            } else {
                // If no search query, retrieve all workplaces
                $stmt = $conn->prepare("SELECT COUNT(*) FROM workplaces");
                $stmt->execute();
                $totalRows = $stmt->fetchColumn();

                // Determine the total number of pages
                $totalPages = ceil($totalRows / $limit);

                // Get the current page number from the URL query parameter
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($currentPage - 1) * $limit;

                $stmt = $conn->prepare("SELECT * FROM workplaces LIMIT :limit OFFSET :offset");
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            ?>


            <!-- conternt tabel -->
            <form class="m-0" method="GET">

                <div class="input-group container bg-secondary p-3 ">
                    <input type="text" class="form-control rounded px-3" placeholder="ค้นหาสถานประกอบการ...."
                        name="search_query">

                    <button class="btn btn-primary rounded px-3 mx-2" type="submit" style="font-size: 1em;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16" style="vertical-align: middle;">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg> Search
                    </button>



                    <div class="col-xs-2 ">
                        <select class="form-control rounded text-center text-primary" name="work_type_filter"
                            onchange="this.form.submit()">
                            <option value="">ทั้งหมด</option>
                            <option value="เขียนโปรแกรม" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'เขียนโปรแกรม')
                                echo 'selected'; ?>>เขียนโปรแกรม</option>
                            <option value="ทำกราฟิก" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ทำกราฟิก')
                                echo 'selected'; ?>>ทำกราฟิก</option>
                            <option value="ระบบเครือข่าย" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ระบบเครือข่าย')
                                echo 'selected'; ?>>ระบบเครือข่าย</option>
                            <option value="ทำเว็บไซต์" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ทำเว็บไซต์')
                                echo 'selected'; ?>>ทำเว็บไซต์</option>
                            <option value="ด้านบริการ" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ด้านบริการ')
                                echo 'selected'; ?>>ด้านบริการ</option>
                        </select>

                    </div>
                </div>


            </form>
            <table class="container table table-hover">
                <thead class="thead-dark">
                    <tr class="">
                        <th class="py-2 ">ชื่อสถานประกอบการ</th>
                        <th class="py-2 ">ประเภทงาน</th>
                        <th class="py-2 ">ลักษณะงาน</th>
                        <th class="py-2 ">คะแนนรีวิว</th>
                        <th class="py-2 "></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($workplacesData as $row): ?>
                        <tr class="text-left ">
                            <td>
                                <?php echo $row['workplace_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['work_type']; ?>
                            </td>
                            <td>
                                <?php echo $row['description']; ?>
                            </td>
                            <td class="text-center">
                                <?php $rating = $row['rating'];
                                if (is_numeric($rating)) {
                                    echo str_repeat("⭐", $rating);
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group ">
                                    <a class="btn btn-primary " href="wp-detail.php?id=<?php echo $row['workplace_id']; ?>">
                                        รายละเอียด
                                    </a>

                                </div>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="my-modal<?php echo $row['workplace_id']; ?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <!-- Modal Content -->
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container">
        <nav aria-label="Page navigation example">
            <ul class="my-2 pagination justify-content-center">

                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($currentPage - 1); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($currentPage + 1); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    </div>
    </div>
    <!-- footer -->
    <?php
    include 'script.php';


    ?>
</body>

</html>