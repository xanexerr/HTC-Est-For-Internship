<?php

    session_start();
    require_once "connection.php";

    if(isset($_POST['submit'])){
        $workplace_name = $_POST['workplace_name'];
        $workplace_address = $_POST['workplace_address'];
        $work_type = $_POST['work_type'];
        $work_des = $_POST['work_des'];
        $work_tel = $_POST['work_type'];

        $sql = $conn->prepare("INSERT INTO workplaces(workplace_name, workplace_address, work_type, description, work_tel) VALUES(:workplace_name, :workplace_address, :work_type, :work_des, :work_tel)");
        $sql->bindParam(":workplace_name", $workplace_name);
        $sql->bindParam(":workplace_address", $workplace_address);
        $sql->bindParam(":work_type", $work_type);
        $sql->bindParam(":work_des", $work_des);
        $sql->bindParam(":work_tel", $work_tel);
        $sql->execute();

            if($sql){
                $_SESSION['success'] = "Data has been inserted successfully";
                header("location: std-wp-edit.php");
            } else{
                $_SESSION['error'] = "Data has not been inserted successfully";
                header("location: std-wp-edit.php");
                }
    }

?>