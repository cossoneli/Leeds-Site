<?php

function getTeamPosition(array $table, string $teamName)
{
    foreach ($table as $position => $teamData) {
        if (strcasecmp($teamData['team_name'], $teamName) === 0) {
            return $position + 1;
        }
    }
    return null;
}

function getTable($connection)
{
    $stmt = "SELECT t.crest, t.abr, s.position, s.team_name, s.wins, s.draws, s.losses, s.goal_differential, s.points
                                FROM prem_table s
                                JOIN team t ON s.team_id = t.id
                                ORDER BY s.position ASC
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