<?php
require_once 'connect.php';
require_once 'auth.php';

// Kiểm tra xem người dùng hiện tại có phải là admin không
if ($_SESSION['user']['role'] != 'admin') {
    die('Access denied');
}

// Kiểm tra xem có tham số id được truyền từ URL không
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Xóa người dùng từ database
    $query = $db->prepare('DELETE FROM users WHERE id = :id');
    $query->bindValue(':id', $userId);
    $query->execute();
    // Chuyển hướng người dùng trở lại trang users.php sau khi xóa
    header("Location: users.php");
    exit();
} else {
    // Nếu không có tham số id, chuyển hướng người dùng về trang users.php
    header("Location: users.php");
    exit();
}
?>