<?php

require_once __DIR__ . '/../models/db_connection.php';
require_once __DIR__ . '/thread_helpers.php';
require_once __DIR__ . '/auth_helper.php';



$id = (int) $_POST['comment_id']; // always sanitize


$newVotes = incrementVotes($connection, $id);

echo json_encode([
    'newVotes' => $newVotes
]);