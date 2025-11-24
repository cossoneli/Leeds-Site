<?php


function formatCommentTime($timestamp)
{
    echo substr($timestamp, 5, 14);
}

function incrementVotes($connection, $comment_id)
{

    $comment_id = (int) $comment_id; // always sanitize
    $query = "UPDATE `thread_comments` SET votes = votes + 1 WHERE id = $comment_id";
    $result = mysqli_query($connection, $query);

    $query = "SELECT votes FROM `thread_comments` WHERE id = $comment_id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    return $row['votes'];
}
