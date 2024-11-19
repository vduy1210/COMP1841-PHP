<?php
session_start();
require 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postId = $_POST['id'];

    // Delete post from database
    $sql = "DELETE FROM posts WHERE id = :id AND author = :author";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $postId);
    $stmt->bindParam(':author', $_SESSION['user']['id']);
    $stmt->execute();

    // Redirect after post deletion
    header("Location: index.php");
    exit();
}
?>