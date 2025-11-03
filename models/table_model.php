<?php

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
    }

    $stmt = $connection->prepare("UPDATE prem_table p
                                JOIN team t ON p.team_name = t.name
                                SET p.team_id = t.id
                                WHERE p.team_id IS NULL");
    $return = $stmt->execute();
}

function update_table_database($plTable, $connection)
{
    foreach ($plTable as $team) {
        $position = $team["position"];
        $wins = $team['won'];
        $draws = $team['draw'];
        $losses = $team['lost'];
        $points = $team['points'];
        $goal_differential = $team['goalDifference'];
        $name = $team['team']['shortName'];

        $stmt = $connection->prepare("UPDATE `prem_table`
                                    SET position = ?, wins = ?, draws = ?, losses = ?, goal_differential = ?, points = ? WHERE team_name = ?");
        $stmt->bind_param("iiiiiis", $position, $wins, $draws, $losses, $goal_differential, $points, $name);
        $result = $stmt->execute();
    }
}