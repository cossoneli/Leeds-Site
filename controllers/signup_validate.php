<?php
require __DIR__ . '/../models/db_connection.php';
require __DIR__ . '/../helpers/auth_helper.php';

session_start();

$username = trim($_POST['user_name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Basic validation
if (empty($username) || empty($email) || empty($password)) {
    header('location:../views/signup.php');
    die("Please fill in all fields.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
if (checkDuplicateEmail($connection, $email)) {
    header('location:../views/signup.php?error=duplicate');
    die("Email already registered.");
}

$stmt = $connection->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
$stmt->execute([$username, $email, $hashedPassword]);
$_SESSION['username'] = $username;
header('location:../views/home.php');
