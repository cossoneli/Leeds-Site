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

function getComments($connection, $thread_id)
{
    $thread_id = (int) $thread_id; // always sanitize
    $query = "SELECT 
        c.id AS comment_id,
        c.text AS comment_text,
        c.created_at,
        c.votes,
        c.parent_comment AS parent_comment_id,
        c.username,
        c.thread_id
    FROM thread_comments c
    WHERE c.thread_id = $thread_id
    ORDER BY 
        COALESCE(c.parent_comment, c.id) DESC,   -- groups replies under parents
        c.id ASC;                                -- orders within each group
    ";

    $result = mysqli_query($connection, $query);
    return $result;
}
