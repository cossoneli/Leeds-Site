<?php

session_start();
$_SESSION = [];
session_destroy();

session_start();
$_SESSION["message"] = "signed out";

header("location:../views/home.php");
exit;