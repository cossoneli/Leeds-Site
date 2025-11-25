<?php

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
        header('location:../views/home.php');
    } else {
        header('location:../views/signup.php');
    }
} else {
    header('location:../views/login.php?error=invalid');
}