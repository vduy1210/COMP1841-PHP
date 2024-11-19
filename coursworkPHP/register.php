<?php
require_once 'connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL statement
    $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");

    // Execute the statement with the form data
    $stmt->execute([$username, $hashedPassword, $email]);

    // Redirect to the login page after successful sign up
    header('Location: login.php');
}
?>