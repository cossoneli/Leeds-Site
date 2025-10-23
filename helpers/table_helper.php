<?php

function getTeamPosition(array $table, string $teamName)
{
    foreach ($table as $position => $teamData) {
        if (strcasecmp($teamData['team']['shortName'], $teamName) === 0) {
            return $position + 1;
        }
    }
    return null;
}