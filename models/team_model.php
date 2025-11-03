<?php

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
    }
}