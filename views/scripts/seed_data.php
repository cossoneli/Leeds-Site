<?php

include __DIR__ . '/../models/db_connection.php';
include __DIR__ . '/../includes/api.php';
include __DIR__ . '/../models/team_model.php';
include __DIR__ . '/../models/table_model.php';
include __DIR__ . '/../models/fixtures_model.php';

$plTeams = getFootballData("competitions/PL/teams");

$plTable = getFootballData("competitions/PL/standings");
$plTableCleaned = $plTable["standings"][0]["table"];

$allLeedsFixtures = getFootballData("teams/341/matches")['matches'];

// echo '<pre>';
// print_r($allLeedsFixtures);
// echo '</pre>';

initialise_team_database($plTeams, $connection);
initialize_table_database($plTableCleaned, $connection);
initialize_fixture_database($allLeedsFixtures, $connection);