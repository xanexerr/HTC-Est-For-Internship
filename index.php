<?php
require('connection.php');
include 'header.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<body class="bg-white">
    <div class="container rounded-top rounded-bottom shadow p-0  my-3  border bg-white col-12">
        <div class="bg-body rounded-0  rounded">
            <?php
            $limit = 12;
            if (isset($_GET['sorting'])) {
                $sorting = ($_GET['sorting']);
                if ($sorting == 'highscore') {
                    $sort = "ORDER BY `rating` DESC";
                } elseif ($sorting == 'newest') {
                    $sort = "ORDER BY `workplace_id` DESC";
                } else {
                    $sort = "ORDER BY `workplace_id` DESC";
                }

            if (isset($_GET['search_query'])) {
                $search_query = $_GET['search_query'];
                    if (isset($_GET['work_type_filter']) && !empty($_GET['work_type_filter'])) {
                        $work_type_filter = $_GET['work_type_filter'];
                        $stmt = $conn->prepare("SELECT COUNT(*) FROM workplaces WHERE workplace_name LIKE :search_query AND work_type = :work_type");
                        $stmt->bindValue(':search_query', "%$search_query%", PDO::PARAM_STR);
                        $stmt->bindValue(':work_type', $work_type_filter, PDO::PARAM_STR);
                        $totalRows = $stmt->fetchColumn();
                        $totalPages = ceil($totalRows / $limit);
                        $stmt->execute();
                        
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $limit;
                        $query = "SELECT * FROM workplaces WHERE workplace_name LIKE :search_query AND work_type = :work_type $sort LIMIT :limit OFFSET :offset;";
                        $stmt = $conn->prepare($query);
                        $stmt->bindValue(':search_query', "%$search_query%", PDO::PARAM_STR);
                        $stmt->bindValue(':work_type', $work_type_filter, PDO::PARAM_STR);
                        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                        $stmt->execute();
                        $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $totalRows = $stmt->rowCount();

                    } else {
                        $stmt = $conn->prepare("SELECT COUNT(*) FROM workplaces WHERE workplace_name LIKE :search_query");
                        $stmt->bindValue(':search_query', "%$search_query%", PDO::PARAM_STR);
                        $stmt->execute();
                        $totalRows = $stmt->fetchColumn();
                        $totalPages = ceil($totalRows / $limit);

                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $limit;
                        $stmt = $conn->prepare("SELECT * FROM workplaces WHERE workplace_name LIKE :search_query $sort LIMIT :limit OFFSET :offset;");
                        $stmt->bindValue(':search_query', "%$search_query%", PDO::PARAM_STR);
                        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                        $stmt->execute();
                        
                    }

                }

                $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $totalRows = $stmt->rowCount();

                if ($search_query == '' && !isset($_GET['work_type_filter']) && $_GET['work_type_filter'] == 'newest' && $sorting == '') {
                    echo '<script>window.location.href = "index.php";</script>';
                    exit();
                }



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
                $sort = "ORDER BY `workplace_id` DESC";
                $stmt = $conn->prepare("SELECT * FROM workplaces WHERE `show` = '1' $sort LIMIT :limit OFFSET :offset;");
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                $workplacesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            ?>
            <p class='h4 py-2 px-auto bg-dark  text-white mb-0 text-center '>รายชื่อสถานประกอบการ</p>
            <form class="m-0  col-12" method="GET">

                <div class="input-group container  bg-secondary p-3  ">
                    <div class="col-2">
                        <select class="form-control rounded-0  rounded-start h-100 " name="work_type_filter" onchange="this.form.submit()">
                            <option value="">ประเภทงาน : ทั้งหมด</option>
                            <option value="เขียนโปรแกรม" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'เขียนโปรแกรม')
                                echo 'selected'; ?>>ประเภทงาน : เขียนโปรแกรม
                            </option>
                            <option value="ทำกราฟิก" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ทำกราฟิก')
                                echo 'selected'; ?>>ประเภทงาน : ทำกราฟิก</option>
                            <option value="ระบบเครือข่าย" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ระบบเครือข่าย')
                                echo 'selected'; ?>>ประเภทงาน : ระบบเครือข่าย
                            </option>
                            <option value="ทำเว็บไซต์" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ทำเว็บไซต์')
                                echo 'selected'; ?>>ประเภทงาน : ทำเว็บไซต์
                            </option>
                            <option value="ด้านบริการ" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ด้านบริการ')
                                echo 'selected'; ?>>ประเภทงาน : ด้านบริการ
                            </option>
                        </select>
                    
                    </div>
                    <div class="col-2 me-2 ">
                        <select class="form-control rounded-0 rounded-end h-100" name="sorting" onchange="this.form.submit()">
                            <option value="newest">เรียงจากเพิ่มล่าสุด</option>
                            <option value="highscore" <?php if (isset($_GET['sorting']) && $_GET['sorting'] === 'highscore')
                                echo 'selected'; ?>>เรียงจากคะแนนรีวิว</option>
                        </select>
                    </div>
        
                    <input type="text" class="form-control rounded-0 px-3  rounded-start" placeholder="ค้นหาสถานประกอบการ...."
                        name="search_query" value="<?php if (isset($search_query)) {
                            echo $search_query;
                        }
                        ?>">
                    <button class="btn btn-primary rounded-0  px-3 me-2 col-2 rounded-end" type="submit" style="font-size: 1em;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16" style="vertical-align: middle;">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg> ค้นหา
                    </button>

    
                </div>
            </form>

            <table class="container table table-hover mb-0  ">
                <thead class="thead-dark">
                    <tr class="col-9">
                        <th class="py-2 table-secondary  col-3">ชื่อสถานประกอบการ</th>
                        <th class="py-2 table-secondary  col-1">ประเภทงาน</th>
                        <th class="py-2 table-secondary col-3">ลักษณะงาน</th>
                        <th class="py-2 table-secondary text-center col-1">คะแนนรีวิว</th>
                        <th class="py-2 table-secondary col-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($workplacesData)) {
                        echo '<tr ">
                        <td colspan="6" class="bg-danger text-white " >ไม่พบสถานประกอบการ!</td> </tr>';
                    }
                    ?>
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
                                    <a class="btn btn-sm btn-primary " href="wp-detail.php?id=<?php echo $row['workplace_id']; ?>">
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
            <div class="container my-3 ">
                <nav aria-label=" Page navigation example">
                    <ul class="pagination justify-content-center m-0">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link bg-dark text-white" href="?page=<?php echo ($currentPage - 1); ?>"
                                    aria-label="Previous">
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
                                <a class="page-link bg-dark text-white" href="?page=<?php echo ($currentPage + 1); ?>"
                                    aria-label="Next">
                                    <span aria-hidden="true"> &#62;</span>
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
<script>
    addClassToElement("index");
</script>

</body>

</html>