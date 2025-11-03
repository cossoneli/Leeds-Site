<?php

// this is a cron job

include __DIR__ . "/../../includes/api.php";
include __DIR__ . "/../../models/api_connection.php";
include __DIR__ . "/../../models/table_model.php";
include __DIR__ . "/../../models/team_model.php";


// fetch the apis here ---v

$plTeams = getFootballData("competitions/PL/teams");

$plTable = getFootballData("competitions/PL/standings");
$plTableCleaned = $plTable["standings"][0]["table"];

update_table_database($plTableCleaned, $connection);
update_team_database($plTeams, $connection);

exit(0);
