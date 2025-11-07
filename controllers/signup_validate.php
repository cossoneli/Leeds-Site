<?php
require('../models/db_connection.php');

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
$stmt = $connection->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
try {
    $stmt->execute([$username, $email, $hashedPassword]);
    $_SESSION['username'] = $username;
    header('location:../views/home.php');
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo "Username or email already exists.";
    } else {
        echo "Database error: " . $e->getMessage();
    }
}