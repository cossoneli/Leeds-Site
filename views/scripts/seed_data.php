<?php

include("../models/api_connection.php");
include("../includes/api.php");
include("../models/team_model.php");

$plTeams = getFootballData("competitions/PL/teams");

$plTable = getFootballData("competitions/PL/standings");
$plTableCleaned = $plTable["standings"][0]["table"];

initialise_team_database($plTeams, $connection);
initialize_table_database($plTableCleaned, $connection);