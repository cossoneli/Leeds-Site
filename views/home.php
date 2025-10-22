<?php include('partials/header.php'); ?>
<?php include('../includes/api.php'); ?>

<?php

// ----------------------------------FETCH API FOR CURRENT STANDINGS

$plStandings = getFootballData("competitions/PL/standings");

$nextLeedsFixture = getFootballData("teams/341/matches?status=SCHEDULED")['matches'][0];  // LUFC ID ---> 341

$previousLeedsFixture = end(getFootballData('teams/341/matches?status=FINISHED')['matches']);
// $previousLeedsFixture = getFootballData("teams/341/matches?status=FINISHED")['matches'][2];  // TEST
// echo '<pre>';
// print_r($data);
// echo '</pre>';


// full table as an array
$fullStandings = $plStandings["standings"][0]["table"];

// find leeds index
$leedsIndex = null;

foreach ($fullStandings as $index => $team) {
    if ($team['team']['shortName'] === "Leeds United") {
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
$end = min(count($fullStandings) - 1, $leedsIndex + 3);

$window = array_slice($fullStandings, $start, $end - $start + 1);

?>


<?php

// Current UTC time
$nowUtc = new DateTime("now", new DateTimeZone("UTC"));

// Fixture UTC time
$fixtureUtc = new DateTime($nextLeedsFixture['utcDate'], new DateTimeZone("UTC"));

// get the difference
$countdown = $nowUtc->diff($fixtureUtc);


?>


<header class="hero-banner text-white text-center">
    <div class="overlay d-flex flex-column justify-content-center align-items-center">
        <img src="../public/imgs/leeds-logo.png" alt="Leeds United Logo" class="mb-3 hero-logo">
        <h1 class="display-5 fw-bold">LU Americas</h1>
        <p class="lead fst-italic">MOT ALAW</p>
    </div>
</header>

<div class="container my-5">
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
    <!-- LIVE TABLE POSIITON PANEL -->
    <div class="row justify-content-center">
        <div class="col-3 mx-2 d-flex align-content-center flex-column border border-dark rounded bg-light">
            <div class="my-1 d-flex justify-content-between">
                <span>Premier League Table</span>
                <button class="fa fa-expand mt-1" aria-hidden="true"></button>
            </div>
            <?php foreach ($window as $team) {

                if ($team['team']['shortName'] === "Leeds United") {
                    ?>

                    <div class="team my-1 d-flex justify-content-between fw-bold">
                        <span><?php echo $team['position'] ?></span>
                        <span><?php echo $team['team']['shortName'] ?></span>
                        <span><?php echo $team['points'] ?></span>
                    </div>

                <?php } else { ?>

                    <div class="team my-1 d-flex justify-content-between">
                        <span><?php echo $team['position'] ?></span>
                        <span><?php echo $team['team']['shortName'] ?></span>
                        <span><?php echo $team['points'] ?></span>
                    </div>

                <?php } ?>


            <?php } ?>
        </div>
        <!-- NEXT FIXTURE PANEL -->
        <div
            class="col-4 mx-2 d-flex align-content-center justify-content-center flex-column border border-dark rounded bg-light">
            <div class="d-flex my-2 justify-content-around">
                <img style="width: 50px;" src="<?php echo $nextLeedsFixture['homeTeam']['crest'] ?>" alt="">
                <span><?php echo $nextLeedsFixture['homeTeam']["shortName"] ?> </span>
                <span>v.</span>
                <span> <?php echo $nextLeedsFixture['awayTeam']["shortName"] ?></span>
                <img style="width: 50px;" src="<?php echo $nextLeedsFixture['awayTeam']['crest'] ?>" alt="">
            </div>
            <div class="d-flex justify-content-center">Countdown to kickoff</div>
            <div class="d-flex justify-content-center fs-4 p-1 m-2">
                <span class="mx-2"><?php echo $countdown->days ?>D </span>
                <span class="mx-2"><?php echo $countdown->h ?>H </span>
                <span class="mx-2"><?php echo $countdown->i ?>M </span>
                <span class="mx-2"><?php echo $countdown->s ?>S </span>
            </div>
            <button type="button" class="btn btn-outline-dark">Pre-Match Chat</button>
        </div>
        <!-- PREVIOUS FIXTURE PANEL -->
        <div
            class="col-3 mx-2 d-flex align-content-center justify-content-center flex-column border border-dark rounded bg-light">
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
            <div class="row my-3">
                <div class="col-9 m-2 d-flex mx-auto justify-content-center">
                    Latest News
                </div>
            </div>
            <div class="row my-2">
                <div class="col-9 m-2 d-flex mx-auto justify-content-center border border-dark rounded bg-light">
                    <span>Latest News Here</span>
                </div>
            </div>
        </div>



        <?php include('partials/footer.php'); ?>