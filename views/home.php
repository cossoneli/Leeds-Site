<?php

include(__DIR__ . '/../models/db_connection.php');
include(__DIR__ . '/../includes/api.php');
include(__DIR__ . '/partials/header.php');
include(__DIR__ . '/../helpers/table_helper.php');
include(__DIR__ . '/../helpers/fixtures_helper.php');
include(__DIR__ . '/../models/table_model.php');

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $baseUrl = '/LeedsSite/public'; // local
} else {
    $baseUrl = ''; // production
}

// ----------------------------------FETCH DATABASE FOR TABLE AND FIXTURES

$table = getTable(connection: $connection);
$playedFixtures = getPlayedFixtures($connection);
$scheduledFixtures = getScheduledFixtures($connection);
$nextLeedsFixture = $scheduledFixtures[0];
$previousLeedsFixture = end($playedFixtures);

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
$fixtureUtc = new DateTime($nextLeedsFixture['date'], new DateTimeZone("UTC"));

?>


<header class="hero-banner text-white text-center">
    <div class="overlay d-flex flex-column justify-content-center align-items-center">
        <img src="<?= $baseUrl ?>/imgs/leeds_americas.png" alt="Leeds United Logo" class="mb-3 hero-logo">
        <h1 class="display-5 fw-bold">American Leeds</h1>
        <p class="lead fst-italic">MOT ALAW</p>
    </div>
</header>

<div class="container my-3 py-1 text-center fs-6 fst-italic border-bottom">
    Click any panel to go to said chat ( MOT )
</div>

<div class="container my-4">

    <!-- PANEL HEADINGS -->
    <div class="row justify-content-center text-center mb-3">
        <div class="col-3 d-flex justify-content-center align-items-center">
            <span class="me-2 fw-semibold">Live Table</span>
            <span class="live-dot bg-danger rounded-circle" style="width:10px;height:10px;display:inline-block;"></span>
        </div>
        <div class="col-4 fw-semibold">Next Fixture</div>
        <div class="col-3 fw-semibold">Previous Result</div>
    </div>

    <div class="row justify-content-center g-3">

        <!-- LIVE TABLE PANEL -->
        <div data-topic="Live Table" class="my-panel col-3 p-3 border rounded shadow-sm bg-light">
            <h6 class="border-bottom pb-2 mb-3 text-center">Premier League Table</h6>
            <?php foreach ($window as $team):
                $isLeeds = $team['abr'] === "LEE";
                $isRel = $team['position'] === "18";
                $rowClass = $isLeeds ? 'fw-bold bg-white bg-opacity-25' : ($isRel ? 'border-top border-danger' : '');
                ?>
                <div
                    class="d-flex justify-content-between align-items-center py-1 px-2 mb-1 rounded <?php echo $rowClass; ?>">
                    <div class="d-flex align-items-center">
                        <span class="me-2"><?php echo $team['position']; ?></span>
                        <img src="<?php echo $team['crest']; ?>" alt="" style="width:24px;height:24px;" class="me-2">
                        <span><?php echo $team['abr']; ?></span>
                    </div>
                    <span class="fw-semibold"><?php echo $team['points']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- NEXT FIXTURE PANEL -->
        <div data-topic="Next Fixture"
            class="my-panel d-flex flex-column justify-content-center col-4 p-3 border rounded shadow-sm bg-light text-center">
            <div class="d-flex justify-content-around align-items-center mb-2">
                <div class="text-center">
                    <img src="<?php echo $nextLeedsFixture['home_crest']; ?>" alt="" style="width:50px;" class="mb-1">
                    <div><?php echo $nextLeedsFixture['home_name']; ?></div>
                    <small
                        class="text-muted">(<?php echo getTeamPosition($table, $nextLeedsFixture['home_name']); ?>th)</small>
                </div>
                <span class="fs-5 fw-bold">v</span>
                <div class="text-center">
                    <img src="<?php echo $nextLeedsFixture['away_crest']; ?>" alt="" style="width:50px;" class="mb-1">
                    <div><?php echo $nextLeedsFixture['away_name']; ?></div>
                    <small
                        class="text-muted">(<?php echo getTeamPosition($table, $nextLeedsFixture['away_name']); ?>th)</small>
                </div>
            </div>
            <div class="my-2">Countdown to kickoff</div>
            <div class="countdown fs-4 fw-semibold"></div>
        </div>

        <!-- PREVIOUS RESULT PANEL -->
        <div data-topic="Previous Fixture"
            class="my-panel d-flex justify-content-center flex-column col-3 p-3 border rounded shadow-sm bg-light text-center">
            <span class="fw-semibold mb-2 d-block">FT -
                <?php echo $previousLeedsFixture['date']; ?></span>

            <?php
            $winner = getWinner($previousLeedsFixture['home_score'], $previousLeedsFixture['away_score']);
            $isHome = $previousLeedsFixture['home_name'] === "Leeds United";
            $isAway = $previousLeedsFixture['away_name'] === "Leeds United";

            // Determine result class
            if ($winner === "DRAW" || !$winner) {
                $resultClass = "text-secondary";
                $result = "D";
            } elseif (($isHome && $winner === "HOME_TEAM") || ($isAway && $winner === "AWAY_TEAM")) {
                $resultClass = "text-success";
                $result = "W";
            } else {
                $resultClass = "text-danger";
                $result = "L";
            }

            $homeScore = $previousLeedsFixture['home_score'];
            $awayScore = $previousLeedsFixture['away_score'];
            $opponentCrest = $isHome ? $previousLeedsFixture['away_crest'] : $previousLeedsFixture['home_crest'];
            $opponentName = $isHome ? $previousLeedsFixture['away_name'] : $previousLeedsFixture['home_name'];
            $venue = $isHome ? 'v.' : '@';
            ?>

            <div class="fs-4 fw-bold my-2 <?php echo $resultClass; ?>">
                <?php echo "$result $homeScore - $awayScore"; ?>
            </div>

            <img src="<?php echo $opponentCrest; ?>" alt="" class="mx-auto mb-2" style="width:75px; border-radius:8px;">

            <div class="fs-5 fw-semibold">
                <?php echo "$venue $opponentName"; ?>
            </div>
        </div>

    </div>
</div>


<script>
    // creates a fixtureDate attribute on the window object
    window.fixtureDate = new Date(<?php echo json_encode($fixtureUtc->format(DateTime::ATOM)); ?>);
</script>

<?php include __DIR__ . '/partials/footer.php';
?>