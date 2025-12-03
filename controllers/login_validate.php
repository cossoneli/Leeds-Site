<?php

$baseUrl = '/LeedsSite/public';
// Switch to this for deployment v
// $baseUrl = '';

require __DIR__ . '/../models/db_connection.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = $connection->prepare("SELECT id, username, email, password FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$stmt->bind_result($id, $username, $email, $hashedPassword);
$stmt->fetch();

if ($id) {
    if (password_verify($password, $hashedPassword)) {
        session_start();
        $_SESSION['username'] = $username;
        header("location: {$baseUrl}/index.php?page=home");
    } else {
        header("location: {$baseUrl}/index.php?page=signup");
    }
} else {
    header("location: {$baseUrl}/index.php?page=login&error=invalid");
}