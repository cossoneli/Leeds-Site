<!DOCTYPE html>
<html lang="en">

<?php
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $baseUrl = '/LeedsSite/public'; // local
} else {
    $baseUrl = ''; // production
}

session_start();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>American Leeds</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/home.css">
    <link rel="icon" href="<?= $baseUrl ?>/imgs/leeds_americas.png">
</head>


<?php
// include __DIR__ . '/partials/header.php';
include __DIR__ . '/../helpers/thread_helpers.php';
include __DIR__ . '/../models/db_connection.php';
include __DIR__ . '/../includes/api.php';
include __DIR__ . '/../helpers/table_helper.php';
include __DIR__ . '/../helpers/fixtures_helper.php';
include __DIR__ . '/../helpers/auth_helper.php';

//----------------------------------------FETCH APIS FOR DATA

$table = getTable($connection);
$playedFixtures = getPlayedFixtures($connection);
$scheduledFixtures = getScheduledFixtures($connection);
$nextLeedsFixture = $scheduledFixtures[0];
$previousLeedsFixture = end($playedFixtures);

// ------------------------------------------------------------

$topic = $_GET['topic'] ?? $_SESSION['topic'] ?? 'Live Table';

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

$_SESSION['topic'] = $topic;
$_SESSION['thread_id'] = $thread_id;

$comments = getComments($connection, $thread_id);

// echo "<pre>";
// while ($row = mysqli_fetch_assoc($comments)) {
//     print_r($row);
// }
// echo "</pre>";

?>

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

                <form action="<?= $baseUrl ?>/index.php?page=insert_comment" method="POST">
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
                <h6 class="card-title mb-2 text-center">Please <a href="<?= $baseUrl ?>/index.php?page=login">log
                        in</a> to post comments.</h6>
            </div>
        </div>
    </div>

<?php } ?>

<div class="container my-4">
    <div class="row">
        <!-- Left column: Comments -->
        <div class="col-md-7 d-flex flex-column">
            <div class="comments-panel p-3">
                <h5 class="mb-3">Comments</h5>
                <?php
                $organized = [];
                $replies = [];

                // First pass: separate parents and replies
                while ($row = mysqli_fetch_assoc($comments)) {
                    if (is_null($row['parent_comment_id'])) {
                        // Parent comment
                        $organized[$row['comment_id']] = $row;
                        $organized[$row['comment_id']]['replies'] = [];
                    } else {
                        // Reply
                        $replies[] = $row;
                    }
                }

                // Second pass: attach replies to their parents
                foreach ($replies as $reply) {
                    $parentId = $reply['parent_comment_id'];
                    if (isset($organized[$parentId])) {
                        $organized[$parentId]['replies'][] = $reply;
                    }
                }

                if (empty($organized)) { ?>

                    <div class="text-muted small">No comments yet — be the first to post.</div>

                <?php } else {

                    foreach ($organized as $parent) {
                        showComment($parent, false);    // parent
                        foreach ($parent['replies'] as $reply) {
                            showComment($reply, true);  // each reply
                        }
                    }
                }

                function showComment($row, $isChild = false)
                {
                    $username = htmlspecialchars($row['username']);
                    $text = nl2br(htmlspecialchars($row['comment_text']));
                    $votes = (int) $row['votes'];
                    $padding = $isChild ? 'ms-5' : ''; // indent replies
                    ?>

                    <div class="comment-panel d-flex flex-column <?php echo $padding; ?>">
                        <div class="comment d-flex mb-3" data-parent-comment="<?php echo $row['comment_id'] ?>">
                            <div class="comment-avatar me-3">
                                <div class="avatar-circle"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                            </div>

                            <div class="comment-body flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong class="username"><?php echo $username; ?></strong>
                                        <span
                                            class="ms-2 text-muted small"><?php formatCommentTime($row['created_at']); ?></span>
                                    </div>

                                    <!-- <div class="text-end">
                                        <button class="vote-count small bg-light border rounded p-1 text-muted"
                                            data-id="<?php echo $row['comment_id'] ?>">
                                            👍 <?php echo $votes; ?>
                                        </button>
                                    </div> -->
                                </div>

                                <div class="comment-text mt-2 text-dark"><?php echo $text; ?></div>

                                <div class="comment-actions mt-2 small">
                                    <?php if (!$isChild) { ?>
                                        <span class="reply-button me-3 text-primary text-decoration-none">Reply</span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>
        </div>

        <!-- Right column: Stats / Sidebar -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 p-3">

                <!-- ------------------------- LIVE TABLE -->
                <?php if ($topic === "Live Table") { ?>
                    <div class="row">
                        <div class="col-10 mx-auto fw-bold">Premier League Full Table</div>
                    </div>
                    <div class="container">
                        <div class="row my-2">
                            <span class="col-3"></span>
                            <span class="col-2">W</span>
                            <span class="col-2">D</span>
                            <span class="col-2">L</span>
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
                                <span class="col-3">
                                    <img style="width: 30px; height: 30px;" src="<?php echo $team['crest'] ?>" alt="">
                                </span>
                                <span class="col-2"><?php echo $team['wins']; ?></span>
                                <span class="col-2"><?php echo $team['draws']; ?></span>
                                <span class="col-2"><?php echo $team['losses']; ?></span>
                                <span class="col-3 border-start"><?php echo $team['points']; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <!-- ----------------------------------- NEXT FIXTURE -->
                <?php if ($topic === "Next Fixture") { ?>
                    <div class="row">
                        <div style="font-size: 14px;" class="col-4 mx-auto text-center">
                            <?php echo "Premier League" ?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="font-size: 10px;" class="col-4 mx-auto text-center text-muted">
                            <?php echo "Matchday " . $nextLeedsFixture['matchday'] ?>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-between mx-1 mb-3">
                        <img style="width: 120px;" src="<?php echo $nextLeedsFixture['home_crest'] ?>" alt="">
                        <img style="width: 120px;" src="https://crests.football-data.org/PL.png" alt="">
                        <img style="width: 120px;" src="<?php echo $nextLeedsFixture['away_crest'] ?>" alt="">
                    </div>
                    <iframe width="520" height="300" src="https://www.youtube.com/embed/SU_uLR5oM7U?si=S3QaX6v3aMY92ymR"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <?php } ?>

                <!-- ----------------------------------- PREVIOUS FIXTURE -->
                <?php if ($topic === "Previous Fixture") { ?>
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
                    <div class="row my-2">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/swi_OUnpEoc?si=KGbmXC_jL1DmWxfS"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>






<?php include __DIR__ . '/partials/footer.php';
?>