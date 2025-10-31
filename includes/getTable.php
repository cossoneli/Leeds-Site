<?php

function getTable($connection)
{
    $stmt = "SELECT t.crest, t.abr, s.position, s.wins, s.draws, s.losses, s.goal_differential, s.points
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