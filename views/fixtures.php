<?php
include __DIR__ . '/partials/header.php';
include __DIR__ . '/../helpers/fixtures_helper.php';
include __DIR__ . '/../models/db_connection.php';

$fixtures = getScheduledFixtures($connection);
?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Upcoming Fixtures</h2>

    <?php if (!empty($fixtures)): ?>
        <div class="row g-3">
            <?php foreach ($fixtures as $fixture): ?>
                <div class="col-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex align-items-center justify-content-between py-2 px-3">
                            <!-- Home team -->
                            <div class="text-center" style="flex: 1;">
                                <img src="<?= $fixture['home_crest'] ?>" alt="<?= $fixture['home_name'] ?> Crest" width="40"
                                    class="mb-1">
                                <p class="mb-0 fw-bold"><?= $fixture['home_name'] ?></p>
                                <?php if ($fixture['home_score'] !== null): ?>
                                    <p class="mb-0"><?= $fixture['home_score'] ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- VS block -->
                            <div class="text-center mx-3" style="flex: 0 0 90px;">
                                <p class="mb-0 fw-bold">vs</p>
                                <p class="mb-0 text-muted small"><?= date("M d, Y", strtotime($fixture['date'])) ?><br>Matchday
                                    <?= $fixture['matchday'] ?>
                                </p>
                            </div>

                            <!-- Away team -->
                            <div class="text-center" style="flex: 1;">
                                <img src="<?= $fixture['away_crest'] ?>" alt="<?= $fixture['away_name'] ?> Crest" width="40"
                                    class="mb-1">
                                <p class="mb-0 fw-bold"><?= $fixture['away_name'] ?></p>
                                <?php if ($fixture['away_score'] !== null): ?>
                                    <p class="mb-0"><?= $fixture['away_score'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-muted mt-4">No upcoming fixtures scheduled.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/footer.php';
?>