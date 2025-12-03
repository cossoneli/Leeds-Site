<?php

require __DIR__ . '/../models/db_connection.php';

session_start();

$thread_id = $_SESSION['thread_id'];
$comment = trim($_POST['comment']);
$username = $_SESSION['username'];

$stmt = $connection->prepare("INSERT INTO thread_comments (thread_id, username, text) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $thread_id, $username, $comment);
$stmt->execute();

header("Location: /LeedsSite/public/index.php?page=home" . $thread_id);
exit();