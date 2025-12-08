<?php

require __DIR__ . '/../models/db_connection.php';

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $baseUrl = '/LeedsSite/public'; // local
} else {
    $baseUrl = ''; // production
}

session_start();

$comment = trim($_POST['comment']);
$parent_comment_id = (int) $_POST['parent_id'];

$username = $_SESSION['username'];
$thread_id = $_SESSION['thread_id'];

echo $parent_comment_id, $comment, $username, $thread_id;