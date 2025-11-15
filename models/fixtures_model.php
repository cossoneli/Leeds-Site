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

        $stmt = $connection->prepare("insert into `fixtures` (isFinished, home_score, away_score, home_name, away_name, matchday, date) values (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissis", $isFinished, $homeScore, $awayScore, $homeName, $awayName, $matchday, $date);
        $return = $stmt->execute();

    }
}

function update_fixtures_database($plFixtures, $connection)
{
    foreach ($plFixtures as $fixture) {
        $isFinished = ($fixture['status'] === 'FINISHED') ? true : false;
        $homeScore = $fixture['score']['fullTime']['home'];
        $awayScore = $fixture['score']['fullTime']['away'];
        $date = $fixture['utcDate'];
        $matchday = $fixture['matchday'];
        $homeName = $fixture['homeTeam']['shortName'];
        $awayName = $fixture['awayTeam']['shortName'];

        $stmt = $connection->prepare("UPDATE `fixtures`
                                    SET isFinished = ?, home_score = ?, away_score = ?, home_name = ?, away_name = ?, matchday = ?, date = ? WHERE home_name = ? AND away_name = ? AND matchday = ?");
        $stmt->bind_param("iiississsi", $isFinished, $homeScore, $awayScore, $homeName, $awayName, $matchday, $date, $homeName, $awayName, $matchday);
        $result = $stmt->execute();

    }
}