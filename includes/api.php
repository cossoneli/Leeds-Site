<?php

function getFootballData($endpoint)
{
    $url = "https://api.football-data.org/v4/" . $endpoint;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-Auth-Token: 8d8793cd178447c392a39c9fdd5bb5c2"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    if (isset($response["errorCode"])) {
        include "error.php";
        exit;
    }

    return $response;
}