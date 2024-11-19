<?php
require_once 'connect.php';

// Kiểm tra xem có tham số id được truyền từ URL không
if (isset($_GET['id'])) {
    $moduleId = $_GET['id'];

    // Xóa module từ database

    $query = $db->prepare('DELETE FROM module WHERE id = :id');
    $query->bindValue(':id', $moduleId);
    $query->execute();

    // Chuyển hướng người dùng trở lại trang modules.php sau khi xóa
    header("Location: modules.php");
    exit();
} else {
    // Nếu không có tham số id, chuyển hướng người dùng về trang modules.php
    header("Location: modules.php");
    exit();
}
?>
