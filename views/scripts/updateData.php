<?php

// this is a cron job

include __DIR__ . "/../../includes/api.php";
include __DIR__ . "/../../models/db_connection.php";
include __DIR__ . "/../../models/table_model.php";
include __DIR__ . "/../../models/team_model.php";
include __DIR__ . "/../../models/fixtures_model.php";


// fetch the apis here ---v

$plTeams = getFootballData("competitions/PL/teams");

$plTable = getFootballData("competitions/PL/standings");
$plTableCleaned = $plTable["standings"][0]["table"];

$allLeedsFixtures = getFootballData("teams/341/matches")['matches'];

update_table_database($plTableCleaned, $connection);
update_team_database($plTeams, $connection);
update_fixtures_database($allLeedsFixtures, $connection);

exit(0);
