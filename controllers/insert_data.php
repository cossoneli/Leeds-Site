<?php

include("../models/api_model.php");
include("../includes/api.php");

$plTeams = getFootballData("competitions/PL/teams");

$plTable = getFootballData("competitions/PL/standings");
$plTableCleaned = $plTable["standings"][0]["table"];

// echo '<pre>';
// var_dump($plTableCleaned);
// echo '</pre>';

// initialise_team_database($plTeams, $connection); // resets and seeds the database

// ----------------------------TEAM DB----------------------------------------
function initialise_team_database($plTeams, $connection)
{
    // RESET DB
    $stmt = $connection->prepare("delete from `team`");
    $return = $stmt->execute();

    foreach ($plTeams['teams'] as $team) {
        $name = $team['shortName'];
        $crest = $team['crest'];
        $venue = $team['venue'];
        $abr = $team['tla'];

        $stmt = $connection->prepare("insert into `team` (name, crest, venue, abr) values (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $crest, $venue, $abr); // 
        $return = $stmt->execute();

        // echo "Inserted: $name<br>";
    }
}

function update_team_database($plTeams, $connection)
{
    foreach ($plTeams['teams'] as $team) {
        $name = $team['shortName'];
        $crest = $team['crest'];
        $venue = $team['venue'];
        $abr = $team['tla'];

        $stmt = $connection->prepare("update `team` set name = ?, crest = ?, venue = ? WHERE abr = ?");
        $stmt->bind_param('ssss', $name, $crest, $venue, $abr); // 
        $return = $stmt->execute();

        // echo "Updated: $name<br>";
    }
}

update_team_database($plTeams, $connection);

// ----------------------------TABLE DB----------------------------------------

function initialize_table_database($plTable, $connection)
{
    // RESET DB
    $stmt = $connection->prepare("delete from `prem_table`");
    $return = $stmt->execute();

    // LOOP THROUGH EVERY TEAM
    foreach ($plTable as $team) {
        $name = $team["team"]['shortName'];
        $position = $team["position"];
        $wins = $team["won"];
        $draws = $team["draw"];
        $losses = $team["lost"];
        $points = $team["points"];
        $goal_differential = $team["goalDifference"];

        $stmt = $connection->prepare("insert into `prem_table` (team_name, position, wins, draws, losses, goal_differential, points) values (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiiii", $name, $position, $wins, $draws, $losses, $goal_differential, $points);
        $return = $stmt->execute();
        var_dump($return);
        echo "Inserted: $position<br>";
    }

    $stmt = $connection->prepare("UPDATE prem_table p
                                JOIN team t ON p.team_name = t.name
                                SET p.team_id = t.id
                                WHERE p.team_id IS NULL");
    $return = $stmt->execute();
}

initialize_table_database($plTableCleaned, $connection);