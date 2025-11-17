<?php

function isLoggedIn()
{
    return isset($_SESSION['username']);
}

function checkDuplicateEmail($connection, $email)
{
    $stmt = $connection->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}