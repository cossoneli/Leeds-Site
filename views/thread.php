<?php
include('partials/header.php');
include('../helpers/thread_helpers.php');
include('../models/db_connection.php');
include('../includes/api.php');
include('../helpers/table_helper.php');
include('../helpers/fixtures_helper.php');

//----------------------------------------FETCH APIS FOR DATA

$table = getTable($connection);
$playedFixtures = getPlayedFixtures($connection);
$scheduledFixtures = getScheduledFixtures($connection);
$nextLeedsFixture = $scheduledFixtures[0];
$previousLeedsFixture = end($playedFixtures);

// ------------------------------------------------------------


$topic = $_GET['topic'] ?? 'Discussion Thread';

$thread_id = 1;
switch ($topic) {
    case 'Live Table':
        $thread_id = 1;
        break;
    case 'Next Fixture':
        $thread_id = 2;
        break;
    case 'Previous Fixture':
        $thread_id = 3;
        break;
    default:
        $thread_id = 1;
}

$query = "SELECT * FROM `thread_comments` WHERE thread_id = $thread_id ORDER BY created_at DESC";

$result = mysqli_query($connection, $query);

if (!$result)
    die(mysqli_error($connection));

// ?>
<div class="bg-light text-dark py-4 mb-4 border-bottom shadow-sm">
    <div class="container text-center">
        <h2 class="mb-1 fw-semibold"><?php echo htmlspecialchars($topic); ?></h2>
        <p class="text-muted mb-0">Match Thread</p>
    </div>
</div>
<?php

if (isset($_SESSION["loggedin"])) {
    ?>
    <div class="container mt-4">
        <div class="card shadow-sm border-0 w-75 mx-auto">
            <div class="card-body">
                <h5 class="card-title mb-3">Leave a Comment</h5>
                <form action="../controllers/insert_data.php" method="POST">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"
                            placeholder="Write your comment..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" name="post_comment">
                        Post Comment
                    </button>
                </form>
            </div>
        </div>
    </div>

<?php } ?>



<div class="container my-4">
    <div class="row">
        <!-- Left column: Comments -->
        <div class="col-md-7 d-flex flex-column">
            <?php

            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-primary">
                                <span><?php echo htmlspecialchars($row['username']); ?></span>
                                <span class="fw-normal text-muted fs-6">
                                    <?php echo formatCommentTime($row['created_at']); ?>
                                </span>
                            </h6>
                            <span class="badge bg-light text-dark">
                                👍 <?php echo htmlspecialchars($row['votes']); ?>
                            </span>
                        </div>
                        <p class="card-text text-dark mb-0">
                            <?php echo nl2br(htmlspecialchars($row['text'])); ?>
                        </p>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Right column: Stats / Sidebar -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 p-3">

                <!-- ------------------------- LIVE TABLE -->
                <?php if ($_GET['topic'] === "Live Table") { ?>
                    <div class="row">
                        <div class="col-10 mx-auto fw-bold">Premier League Full Table</div>
                    </div>
                    <div class="container">
                        <div class="row my-2">
                            <span class="col-1"></span>
                            <span class="col-5">Club</span>
                            <span class="col-1">W</span>
                            <span class="col-1">D</span>
                            <span class="col-1">L</span>
                            <span class="col-3">Pts</span>
                        </div>

                        <?php foreach ($fullStandings as $team) { ?>
                            <?php
                            $borderClass = "";
                            if ($team['position'] === 5)
                                $borderClass = "border-top border-success";
                            else if ($team['position'] === 6)
                                $borderClass = "border-top border-info";
                            else if ($team['position'] === 18)
                                $borderClass = "border-top border-danger";
                            ?>
                            <div class="row my-1 <?php echo $borderClass; ?>">
                                <span class="col-1">
                                    <img style="width: 20px; height: 20px;" src="<?php echo $team['team']['crest']; ?>" alt="">
                                </span>
                                <span class="col-5"><?php echo $team['team']['shortName']; ?></span>
                                <span class="col-1"><?php echo $team['won']; ?></span>
                                <span class="col-1"><?php echo $team['draw']; ?></span>
                                <span class="col-1"><?php echo $team['lost']; ?></span>
                                <span class="col-3 border-start"><?php echo $team['points']; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <!-- ----------------------------------- PREVIOUS FIXTURE -->
                <?php if ($_GET['topic'] === "Previous Fixture") { ?>
                    <div class="row">
                        <div style="font-size: 14px;" class="col-4 mx-auto text-center">
                            <?php echo "Premier League" ?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="font-size: 10px;" class="col-4 mx-auto text-center text-muted">
                            <?php echo "Matchday " . $previousLeedsFixture['matchday'] ?>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-between mx-1">
                        <img style="width: 120px;" src="<?php echo $previousLeedsFixture['home_crest'] ?>" alt="">
                        <img style="width: 120px;" src="https://crests.football-data.org/PL.png" alt="">
                        <img style="width: 120px;" src="<?php echo $previousLeedsFixture['away_crest'] ?>" alt="">
                    </div>
                    <div class="row my-2 d-flex justify-content-between">
                        <span class="col-4 fs-2 text-center"><?php echo $previousLeedsFixture['home_score'] ?></span>
                        <span class="col-4 fw-bold text-center">FT</span>
                        <span class="col-4 fs-2 text-center"><?php echo $previousLeedsFixture['away_score'] ?></span>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>






<?php include('partials/footer.php'); ?>