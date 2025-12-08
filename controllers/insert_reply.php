<?php

require __DIR__ . '/../models/db_connection.php';

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $baseUrl = '/LeedsSite/public'; // local
} else {
    $baseUrl = ''; // production
}

session_start();

$comment = trim($_POST['comment']);
$parent_comment_id = (int) $_GET['parent_id'];

$username = $_SESSION['username'];
$thread_id = $_SESSION['thread_id'];

echo "parent id", $parent_comment_id, "\ncomment:", $comment, "\n username", $username, "\nthread id", $thread_id;

$stmt = $connection->prepare("INSERT INTO thread_comments (thread_id, username, text, parent_comment) VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi", $thread_id, $username, $comment, $parent_comment_id);
$stmt->execute();

header("Location: $baseUrl/index.php?page=home");
exit();