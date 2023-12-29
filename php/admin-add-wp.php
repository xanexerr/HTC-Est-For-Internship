<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $wp_name = htmlspecialchars($_POST['wp_name']);
    $row['work_type'] = ($_POST['work_type']);
    $description = htmlspecialchars($_POST['wp_des']);
    $wp_address = htmlspecialchars($_POST['wp_address']);
    $work_tel = htmlspecialchars($_POST['wp_tel']);

    // require the database connection
    require '../connection.php';

    $updatewp = "INSERT INTO workplaces (workplace_name, workplace_address, work_type, description, work_tel, user_id, rating) 
        VALUES (:wp_name, :wp_address, :work_type, :description, :work_tel, NULL, '')";

    // Prepare the SQL statement
    $stmt = $conn->prepare($updatewp);

    // Bind parameters with values
    $stmt->bindParam(':wp_name', $wp_name);
    $stmt->bindParam(':wp_address', $wp_address);
    $stmt->bindParam(':work_type', $row['work_type']);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':work_tel', $work_tel);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มที่ฝึกงานสำเร็จ')
        window.location.href = '../admin-add-form.php';
        ;</script>
        
        ";

        exit();
    } else {
        // Handle errors
        echo "เกิดข้อผิดพลาด : " . $stmt->errorInfo()[2];
    }
}
?>