<?php
include __DIR__ . '/partials/header.php';
include __DIR__ . '/../helpers/table_helper.php';
include __DIR__ . '/../models/db_connection.php';


$table = getTable($connection);


// echo '<pre>';
// print_r($table);
// echo '</pre>';

?>

<div class="container my-5">
    <div class="col-md-7 mx-auto">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header text-dark text-center py-3">
                <h4 class="mb-0">
                    Premier League Table
                </h4>
            </div>

            <div class="card-body bg-light p-4">
                <div class="row fw-bold border-bottom pb-2 mb-2 text-secondary">
                    <div class="col-1 text-center">#</div>
                    <div class="col-3">Club</div>
                    <div class="col-1 text-center">W</div>
                    <div class="col-1 text-center">D</div>
                    <div class="col-1 text-center">L</div>
                    <div class="col-2 text-center">GD</div>
                    <div class="col-2 text-center">Pts</div>
                </div>

                <?php foreach ($table as $team): ?>
                    <?php
                    $pos = (int) $team['position'];
                    $borderClass = "";

                    if ($pos === 4)
                        $borderClass = "border-success";
                    else if ($pos === 5)
                        $borderClass = "border-info";
                    else if ($pos === 17)
                        $borderClass = "border-danger";
                    ?>
                    <div class="row align-items-center py-2 border-bottom hover-shadow-sm <?php echo $borderClass; ?>">
                        <div class="col-1 text-center fw-bold text-muted"><?php echo $team['position']; ?></div>
                        <div class="col-3 d-flex align-items-center gap-2">
                            <img src="<?php echo $team['crest']; ?>" alt="" class="rounded-circle border"
                                style="width:24px; height:24px;">
                            <span class="fw-semibold"><?php echo $team['abr']; ?></span>
                        </div>
                        <div class="col-1 text-center"><?php echo $team['wins']; ?></div>
                        <div class="col-1 text-center"><?php echo $team['draws']; ?></div>
                        <div class="col-1 text-center"><?php echo $team['losses']; ?></div>
                        <div class="col-2 text-center"><?php echo $team['goal_differential']; ?></div>
                        <div class="col-2 text-center fw-bold"><?php echo $team['points']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="card-footer text-center py-3">
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-1">
                        <span class="badge rounded-circle" style="width:15px; height:15px;"></span>
                        <small>Champions League</small>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="badge rounded-circle"
                            style="width:15px; height:15px; background-color:#cfe2ff;"></span>
                        <small>Europa League / Conference League</small>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="badge rounded-circle"
                            style="width:15px; height:15px; background-color:#f8d7da;"></span>
                        <small>Relegation</small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php include __DIR__ . '/partials/footer.php';
?>