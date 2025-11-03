<?php

include("../models/api_connection.php");
include("../includes/api.php");
include('partials/header.php');
include('../helpers/table_helper.php');
include('../models/table_model.php');

// ----------------------------------FETCH API FOR CURRENT STANDINGS

$table = getTable(connection: $connection);

// TODO eventually need to get rid of all getFootballData() calls

$nextLeedsFixture = getFootballData("teams/341/matches?status=SCHEDULED")['matches'][0];  // LUFC ID ---> 341

$previousLeedsFixture = end(getFootballData('teams/341/matches?status=FINISHED')['matches']);

// find leeds index
$leedsIndex = null;

foreach ($table as $index => $team) {
    if ($team['abr'] === "LEE") {
        $leedsIndex = $index;
        break;
    }
}

if ($leedsIndex === null) {
    echo "leeds not found";
    exit;
}


// get window around leeds
$start = max(0, $leedsIndex - 3);
$end = min(count($table) - 1, $leedsIndex + 3);

$window = array_slice($table, $start, $end - $start + 1);

// Fixture UTC time
$fixtureUtc = new DateTime($nextLeedsFixture['utcDate'], new DateTimeZone("UTC"));

?>


<header class="hero-banner text-white text-center">
    <div class="overlay d-flex flex-column justify-content-center align-items-center">
        <img src="../public/imgs/leeds-logo.png" alt="Leeds United Logo" class="mb-3 hero-logo">
        <h1 class="display-5 fw-bold">LU Americas</h1>
        <p class="lead fst-italic">MOT ALAW</p>
    </div>
</header>

<div class="container mt-3 text-center fs-6 fst-italic">
    Tip - Click any panel to go to said chat ( MOT )
</div>

<div class="container my-3">
    <!-- -----------------------------------PANEL HEADINGS  -->

    <div class="row justify-content-center">
        <div class="col-3 m-2 d-flex justify-content-center">
            <span>Live Table Position</span>
            <span class="live-dot"></span>
        </div>
        <div class="col-4 mx-2 d-flex justify-content-center">
            <span>Next Fixture</span>
        </div>
        <div class="col-3 mx-2 d-flex justify-content-center">
            <span>Previous Result</span>
        </div>
    </div>

    <div class="row justify-content-center">

        <!------------------------------------------- LIVE TABLE POSIITON PANEL -->

        <div data-topic="Live Table"
            class="my-panel col-3 mx-2 p-2 d-flex align-content-center flex-column border border-dark rounded bg-light">
            <div class="border-bottom d-flex">
                <span>Premier League Table</span>
            </div>
            <?php foreach ($window as $team) {
                if ($team["position"] === "18") { ?>
                    <div id="rel-team"
                        class="team my-1 d-flex justify-content-between align-items-center border-top border-danger">
                        <div class="d-flex">
                            <span><?php echo $team['position'] ?></span>
                            <img style="width: 20px; height: 20px;" class="mx-2 align-self-end"
                                src="<?php echo $team['crest'] ?>" alt="">
                            <span><?php echo $team['abr'] ?></span>
                        </div>
                        <span><?php echo $team['points'] ?></span>
                    </div>
                    <?php continue;
                }

                if ($team['abr'] === "LEE") {
                    ?>

                    <div class="team my-1 d-flex justify-content-between align-items-center fw-bold">
                        <div class="d-flex">
                            <span><?php echo $team['position'] ?></span>
                            <img style="width: 20px; height: 20px;" class="mx-2 align-self-end"
                                src="<?php echo $team['crest'] ?>" alt="">
                            <span><?php echo $team['abr'] ?></span>
                        </div>
                        <span><?php echo $team['points'] ?></span>
                    </div>

                <?php } else { ?>

                    <div class="team my-1 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <span><?php echo $team['position'] ?></span>
                            <img style="width: 20px; height: 20px;" class="mx-2 align-self-end"
                                src="<?php echo $team['crest'] ?>" alt="">
                            <span><?php echo $team['abr'] ?></span>
                        </div>
                        <span><?php echo $team['points'] ?></span>
                    </div>

                <?php } ?>


            <?php } ?>
        </div>
        <!-- ------------------------------------------------------------------------------------ -->


        <!----------------------------------------- NEXT FIXTURE PANEL -->
        <div data-topic="Next Fixture"
            class="my-panel col-4 mx-2 d-flex align-content-center justify-content-center flex-column border border-dark rounded bg-light">
            <div class="d-flex my-2 justify-content-around">
                <img style="width: 50px;" src="<?php echo $nextLeedsFixture['homeTeam']['crest'] ?>" alt="">
                <div class="d-flex flex-column">
                    <span><?php echo $nextLeedsFixture['homeTeam']["shortName"] ?> </span>
                    <span style="font-size: 12px;" class="fst-italic text-muted">(
                        <?php echo getTeamPosition($table, $nextLeedsFixture['homeTeam']['tla']) ?>th in
                        PL
                        )</span>
                </div>
                <span>v.</span>
                <div class="d-flex flex-column">
                    <span><?php echo $nextLeedsFixture['awayTeam']["shortName"] ?> </span>
                    <span style="font-size: 12px;" class="fst-italic text-muted">(
                        <?php echo getTeamPosition($table, $nextLeedsFixture['awayTeam']['tla']) ?>th in
                        PL
                        )</span>
                </div>
                <img style="width: 50px;" src="<?php echo $nextLeedsFixture['awayTeam']['crest'] ?>" alt="">
            </div>
            <div class="d-flex justify-content-center">Countdown to kickoff</div>
            <div class="countdown d-flex justify-content-center fs-4 p-1 m-2">

            </div>
        </div>
        <!-- ------------------------------------------------------------------------------------------- -->

        <!---------------------------------------------- PREVIOUS FIXTURE PANEL -->
        <div data-topic="Previous Fixture"
            class="my-panel col-3 mx-2 d-flex align-content-center justify-content-center flex-column border border-dark rounded bg-light">
            <span class="mx-auto">FT - Date: <?php echo substr($previousLeedsFixture['utcDate'], 0, 10) ?></span>
            <?php
            $winner = $previousLeedsFixture['score']['winner'];
            $isHome = $previousLeedsFixture['homeTeam']['shortName'] === "Leeds United";
            $isAway = $previousLeedsFixture['awayTeam']['shortName'] === "Leeds United";

            if ($winner === "DRAW") {
                ?>
                <div class="d-flex justify-content-center my-2 fs-4"> <?php
            } else if (($isHome && $winner === "HOME_TEAM") || ($isAway && $winner === "AWAY_TEAM")) {
                ?>
                        <div class="d-flex justify-content-center fs-4 my-2 text-success"> <?php
            } else {
                ?>
                            <div class="d-flex justify-content-center fs-4 my-2 text-danger"> <?php
            }
            ?>
                        <?php


                        if ($winner === "DRAW" || !$winner) {
                            $result = "D";
                        } else {
                            // If Leeds is home and won, or away and won
                            $result = ($isHome && $winner === "HOME_TEAM") || ($isAway && $winner === "AWAY_TEAM") ? "W" : "L";
                        }

                        echo $result . " " . $previousLeedsFixture['score']['fullTime']['home']
                            . " - " . $previousLeedsFixture['score']['fullTime']['away'];


                        ?>
                    </div>
                    <img style="width: 75px; align-self: center;" src="<?php
                    if ($isHome) {
                        echo $previousLeedsFixture['awayTeam']['crest'];
                    } else {
                        echo $previousLeedsFixture['homeTeam']['crest'];
                    }

                    ?>
                     " alt="">
                    <div class="d-flex justify-content-center my-2 fs-4">
                        <?php
                        if ($isHome) {
                            echo 'v. ' . $previousLeedsFixture['awayTeam']['shortName'];
                        } else {
                            echo '@ ' . $previousLeedsFixture['homeTeam']['shortName'];
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // creates a fixtureDate attribute on the window object
            window.fixtureDate = new Date(<?php echo json_encode($fixtureUtc->format(DateTime::ATOM)); ?>);
        </script>

        <?php include('partials/footer.php'); ?>