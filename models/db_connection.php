<?php


define("HOSTNAME", "127.0.0.1");
define("USERNAME", "leedssite_user");
define("PASSWORD", "LeedsUnited15!a");
define("DATABASE", "leeds_site");

$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (!$connection) {
    die("Connection Failed");
}

