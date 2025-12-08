<?php


define("HOSTNAME", "127.0.0.1");
// FOR DEPLOYMENT
// define("USERNAME", "leedssite_user");
// define("PASSWORD", "LeedsUnited15!a");
// define("DATABASE", "leeds_site");
// FOR LOCALHOST
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "leeds_site");

$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (!$connection) {
    die("Connection Failed");
}

