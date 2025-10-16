<?php

session_start();

if (isset($_POST["logged_in"])) {
    $_SESSION["name"] = $_POST["first_name"];
    $_SESSION["loggedin"] = "loggin";
    header("location:../views/home.php");
    exit();
}