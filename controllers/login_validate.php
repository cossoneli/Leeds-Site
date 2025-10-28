<?php

session_start();

if (isset($_POST["logged_in"])) {
    $_SESSION["username"] = $_POST["user_name"];
    $_SESSION["loggedin"] = "loggin";
    $_SESSION["reject_message"] = null;
    header("location:../views/home.php");
    exit();
}