<!DOCTYPE html>
<html lang="en">
<?php
include 'header.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require('connection.php');
    include 'navbar.php';
    include('php/admin-check.php');
    ?>
    <?php
    $updatestatus = "SELECT COUNT(*) FROM users";
    $stmt = $conn->query($updatestatus);
    $totalusers = $stmt->fetchColumn();
    $usersData = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php
    $limit = 12;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();
    $totalPages = ceil($totalRows / $limit);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $limit;

    $order = "ORDER BY user_id DESC";
    if (isset($_GET['work_type_filter'])) {
        $work_type_filter = ($_GET['work_type_filter']);
        if ($work_type_filter === 'ASC') {
            $order = "ORDER BY user_id ASC";
        } elseif ($work_type_filter === 'username_ASC') {
            $order = "ORDER BY username ASC";
        } elseif ($work_type_filter === 'username_DESC') {
            $order = "ORDER BY username DESC";
        }
    }

    if (isset($_GET['search_query'])) {
        $search = '%' . $_GET['search_query'] . '%';
        $search_query = $_GET['search_query'];
        $stmt = $conn->prepare("SELECT * FROM users 
        WHERE user_id LIKE :search_query 
        OR username LIKE :search_query 
        OR user_fname LIKE :search_query 
        OR user_lname LIKE :search_query 
        OR role LIKE :search_query 
        $order
        LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':search_query', $search, PDO::PARAM_STR);
    } else {
        $stmt = $conn->prepare("SELECT * FROM users $order LIMIT :limit OFFSET :offset");
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="flex-container">
        <div class="container ">
            <div class="my-3 bg-body  shadow ">
                <div class=" justify-content-center  ">
                    <div class="p-0 ">
                        <p class='h4 py-2 px-auto bg-dark  text-white mb-0 text-center '>
                            ข้อมูลผู้ใช้ทั้งหมด </p>



                        <form class="m-0 rounded-top  rounded col-12" method="GET">
                            <div class="input-group container bg-secondary p-3 ">
                                <div class="col-2">
                                    <select class=" form-control  mx-2" name="work_type_filter"
                                        onchange="this.form.submit()">
                                        <option value="DESC" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'DESC')
                                            echo 'selected'; ?>>ลำดับ : มาก -> น้อย
                                        </option>
                                        <option value="ASC" <?php if (isset($_GET['work_type_filter']) && $_GET['work_type_filter'] === 'ASC')
                                            echo 'selected'; ?>>ลำดับ : น้อย -> มาก
                                        </option>
                                    </select>
                                </div>

                                <input type="text" class="form-control " placeholder="ค้นหา...." name="search_query"
                                    value="<?php if (isset($search_query)) {
                                        echo $search_query;
                                    }
                                    ?>">
                                <button class="btn btn-primary rounded-end px-3 mr-2 col-1" type="submit"
                                    style="font-size: 1em;">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                                        class="bi bi-search" viewBox="0 0 16 16" style="vertical-align: middle;">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                    </svg> Search
                                </button>
                            </div>
                    </div>
                    </form>
                    <div class="col  text-center bg-dark px-4 mx-auto">
                        <a href="add-member.php" class="text-white btn btn-none ">เพิ่มบัญชี</a>
                    </div>
                    <div class="px-4">
                        <div class="">
                            <p class="fs-5 rounded p-1 px-3 m-0 form-control border-0 text-center">
                                บัญชีผู้ใช้ทั้งหมดในระบบ :
                                <?php echo $totalusers; ?>
                            </p>
                        </div>
                    </div>

                    <div class="col mx-3">
                        <div class="table-responsive">
                            <?php if ($totalusers > 0): ?>
                                <table class="table table-bordered table-sm m-0">
                                    <thead>
                                        <tr class="text-center text-light bg-dark col-10">
                                            <th class='col-2'>รหัสผู้ใช้</th>
                                            <th class='col-2'>ชื่อบัญชี</th>
                                            <th class='col-2'>ชื่อจริง</th>
                                            <th class='col-2'>นามสกุล</th>
                                            <th class='col-2'>สถานะ</th>
                                            <th class='col-2'>จัดการ/สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usersData as $row): ?>
                                            <tr class="text-center">
                                                <td>
                                                    <?php echo $row['user_id']; ?>
                                                </td>
                                                <td class='text-center'>
                                                    <?php echo $row['username']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['user_fname']; ?>
                                                </td>
                                                <td class='text-center'>
                                                    <?php echo $row['user_lname']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($row['role'] == 'student') {
                                                        echo 'นักเรียน';
                                                    } elseif ($row['role'] == 'admin') {
                                                        echo 'ผู้ดูแลระบบ';
                                                    } elseif ($row['role'] == 'teacher') {
                                                        echo 'อาจารย์';
                                                    }
                                                    ?>
                                                </td>

                                                <td class="text-center">
                                                    <div class="btn-group  ">

                                                        <a href="admin-users.php?id=<?php echo $row['user_id']; ?>"
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
                            <?php else: ?>
                                <p class='mt-5'>No data available</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="container p-3 ">
                        <nav aria-label=" Page navigation example  ">
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
    <?php
    include "script.php";
    ?>
</body>

</html>