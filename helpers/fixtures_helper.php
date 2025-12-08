<?php


function getPlayedFixtures($connection)
{
    $stmt = "SELECT f.home_score, 
            f.away_score, 
            f.home_name, 
            f.away_name, 
            f.matchday, 
            f.date, 
            th.crest AS home_crest, 
            ta.crest AS away_crest
            FROM fixtures f
            JOIN team th ON f.home_name = th.name 
            JOIN team ta ON f.away_name = ta.name
            WHERE f.isFinished = 1
            ORDER BY f.matchday ASC
            ";

    $result = $connection->query($stmt);

    if (!$result) {
        // Query failed
        return [];
    }

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;
}

function getScheduledFixtures($connection)
{
    $stmt = "SELECT f.home_score, 
            f.away_score, 
            f.home_name, 
            f.away_name, 
            f.matchday, 
            f.date, 
            th.crest AS home_crest, 
            ta.crest AS away_crest
            FROM fixtures f
            JOIN team th ON f.home_name = th.name 
            JOIN team ta ON f.away_name = ta.name
            WHERE f.isFinished = 0
            ORDER BY f.matchday ASC
            ";

    $result = $connection->query($stmt);

    if (!$result) {
        // Query failed
        return [];
    }

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;
}

function getWinner($homeScore, $awayScore)
{
    if ($homeScore < $awayScore) {
        return "AWAY_TEAM";
    } else if ($homeScore > $awayScore) {
        return "HOME_TEAM";
    } else {
        return "DRAW";
    }
}