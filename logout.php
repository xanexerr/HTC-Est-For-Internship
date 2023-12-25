<?php
session_start();
session_destroy();
header("Location: index.php");
// header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>