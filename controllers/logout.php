<?php

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $baseUrl = '/LeedsSite/public'; // local
} else {
    $baseUrl = ''; // production
}

session_start();
$_SESSION = [];
session_destroy();

session_start();
$_SESSION["message"] = "signed out";

header("location: {$baseUrl}/index.php?page=home");
exit;