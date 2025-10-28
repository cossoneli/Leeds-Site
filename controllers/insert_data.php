<?php

include("../models/thread_model.php");

session_start();

if (isset($_POST['post_comment'])) {

    $username = $_SESSION['username'];
    $comment = $_POST['comment'];
    $votes = 0;

    $query = "insert into `table_comments` (username, comment, votes) values ('$username', '$comment', '$votes')";
    $result = mysqli_query($connection, $query);

    header('location:../views/thread.php');
}