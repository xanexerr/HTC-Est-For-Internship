<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบรวบรวมสถานประกอบการ แผนกเทคโนโลยีสารสนเทศ</title>
</head>

<body>
    <div class="container   shadow-sm p-0">
        <?php
        include 'navbar.php';
        ?>
        <?php
        require('connection.php');
        $sql = "SELECT COUNT(*) FROM workplaces";
        $stmt = $conn->query($sql);
        $totalWorkplaces = $stmt->fetchColumn();
        $workplacesData = $conn->query("SELECT * FROM workplaces")->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <!-- conternt tabel -->
        <table class="container table table-hover">
            <thead>
                <tr class="text-center ">
                    <th class="py-2">ชื่อสถานประกอบการ</th>
                    <th>ประเภทงาน</th>
                    <th>ลักษณะงาน</th>
                    <th>คะแนนรีวิว</th>
                    <th></th>
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

    <!-- footer -->
    <?php
    include 'script.php';
    ?>
</body>

</html>