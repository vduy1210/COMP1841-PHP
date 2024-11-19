<?php
session_start();
require 'connect.php'; // Ensure this file contains the necessary database connection setup

function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function login($username, $password) {
    global $db;
    $query = $db->prepare("SELECT id, username, password, role FROM users WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['username'], 'role' => $user['role']];
        $_SESSION['logged_in'] = true;
        return true;
    }
    return false;
}

function logout() {
    session_destroy();
    header('Location: login.php');
    exit;
}

function handleRedirection() {
    $current_page = basename($_SERVER['SCRIPT_NAME']);
    if (isLoggedIn()) {
        if ($current_page !== 'index.php') {
            header('Location: index.php');
            exit;
        }
    } else {
        if ($current_page === 'post.php') {
            return;
        } elseif ($current_page !== 'login.php') {
            header('Location: login.php');
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (login($username, $password)) {
        handleRedirection();
    } else {
        $error = 'Invalid username or password!';
    }
} else {
    handleRedirection();
}
?>