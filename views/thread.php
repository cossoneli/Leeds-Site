<?php
include('partials/header.php');
include('../helpers/thread_helpers.php');
include('../models/db_connection.php');
include('../includes/api.php');
include('../helpers/table_helper.php');
include('../helpers/fixtures_helper.php');
include('../helpers/auth_helper.php');

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

$_SESSION['thread_id'] = $thread_id;

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
<?php if (isLoggedIn()) { ?>
    <div class="container mt-4">
        <div class="card shadow-sm border-0 w-50 mx-auto" style="border-radius: 10px;">
            <div class="card-body py-3">
                <h6 class="card-title mb-2 text-center">Leave a Comment</h6>

                <form action="../controllers/insert_comment.php" method="POST">
                    <div class="mb-2">
                        <textarea class="form-control" id="comment" name="comment" rows="2"
                            placeholder="Write your comment..." required></textarea>
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-sm" name="post_comment">
                        Post Comment
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php
} else { ?>

    <div class="container mt-4">
        <div class="card shadow-sm border-0 w-50 mx-auto" style="border-radius: 10px;">
            <div class="card-body py-3">
                <h6 class="card-title mb-2 text-center">Please log in to post comments.</h6>
            </div>
        </div>
    </div>

<?php } ?>

<div class="container my-4">
    <div class="row">
        <!-- Left column: Comments -->
        <div class="col-md-7 d-flex flex-column">
            <div class="comments-panel my-panel p-3">
                <h5 class="mb-3">Comments</h5>
                <?php
                if (mysqli_num_rows($result) === 0) { ?>
                    <div class="text-muted small">No comments yet — be the first to post.</div>
                <?php } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $username = htmlspecialchars($row['username']);
                        $text = nl2br(htmlspecialchars($row['text']));
                        // formatCommentTime echoes formatted time directly
                        $votes = (int) $row['votes'];
                        ?>
                        <div class="comment d-flex mb-3">
                            <div class="comment-avatar me-3">
                                <?php // simple initials avatar ?>
                                <div class="avatar-circle"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                            </div>
                            <div class="comment-body flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong class="username"><?php echo $username; ?></strong>
                                        <span
                                            class="ms-2 text-muted small"><?php formatCommentTime($row['created_at']); ?></span>
                                    </div>
                                    <div class="text-end">
                                        <div class="vote-count small text-muted">👍 <?php echo $votes; ?></div>
                                    </div>
                                </div>
                                <div class="comment-text mt-2 text-dark">
                                    <?php echo $text; ?>
                                </div>
                                <div class="comment-actions mt-2 small">
                                    <a href="#" class="me-3 text-decoration-none">Reply</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
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

                        <?php foreach ($table as $team) { ?>
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
                                    <img style="width: 20px; height: 20px;" src="<?php echo $team['crest'] ?>" alt="">
                                </span>
                                <span class="col-5"><?php echo $team['team_name']; ?></span>
                                <span class="col-1"><?php echo $team['wins']; ?></span>
                                <span class="col-1"><?php echo $team['draws']; ?></span>
                                <span class="col-1"><?php echo $team['losses']; ?></span>
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