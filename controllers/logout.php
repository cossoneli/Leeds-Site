<?php

// $baseUrl = '/LeedsSite/public';
// Switch to this for deployment v
$baseUrl = '';

session_start();
$_SESSION = [];
session_destroy();

session_start();
$_SESSION["message"] = "signed out";

header("location: {$baseUrl}/index.php?page=home");
exit;