<?php

function initialize_fixture_database($plFixtures, $connection)
{

    // RESET DB
    $stmt = $connection->prepare("delete from `fixtures`");
    $return = $stmt->execute();

    // LOOP THROUGH ALL GAMES
    foreach ($plFixtures as $fixture) {

        // check if the match is finished
        $isFinished = ($fixture['status'] === 'FINISHED') ? true : false;
        $homeScore = $fixture['score']['fullTime']['home'];
        $awayScore = $fixture['score']['fullTime']['away'];
        $date = $fixture['utcDate'];
        $matchday = $fixture['matchday'];
        $homeName = $fixture['homeTeam']['shortName'];
        $awayName = $fixture['awayTeam']['shortName'];
        $winner = $fixture['score']['winner'];

        $stmt = $connection->prepare("insert into `fixtures` (isFinished, home_score, away_score, home_name, away_name, matchday, date) values (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissis", $isFinished, $homeScore, $awayScore, $homeName, $awayName, $matchday, $date);
        $return = $stmt->execute();

    }

    // TODO temp solution --> add crest instead of trying to join
    // Want to practice our joins tho, so preferably figure this out

    $stmt = $connection->prepare("
        UPDATE fixtures f
        JOIN team th ON f.home_name = th.name
        JOIN team ta ON f.away_name = ta.name
        SET 
            f.home_id = th.id,
            f.away_id = ta.id
        WHERE 
            f.home_id IS NULL 
            OR f.away_id IS NULL
    ");
    $return = $stmt->execute();

}