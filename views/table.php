<?php
include('partials/header.php');
include('../helpers/table_helper.php');
include("../models/api_connection.php");


$table = getTable($connection);


// echo '<pre>';
// print_r($table);
// echo '</pre>';

?>

<div class="container">
    <div class="col-md-5 mx-auto my-3">
        <div class="card shadow-sm border-0 p-3">
            <div class="row">
                <div class="col-10 mx-auto fw-bold">Premier League Full Table</div>
            </div>
            <div class="container">
                <div class="row my-2">
                    <span class="col-1"></span>
                    <span class="col-3">Club</span>
                    <span class="col-1">W</span>
                    <span class="col-1">D</span>
                    <span class="col-1">L</span>
                    <span class="col-2">GD</span>
                    <span class="col-3">Pts</span>
                </div>

                <?php foreach ($table as $team) { ?>
                    <?php
                    $borderClass = "";
                    if ($team['position'] === '5')
                        $borderClass = "border-top border-success";
                    else if ($team['position'] === '6')
                        $borderClass = "border-top border-info";
                    else if ($team['position'] === '18')
                        $borderClass = "border-top border-danger";
                    ?>
                    <div class="row my-1 <?php echo $borderClass; ?>">
                        <span class="col-1">
                            <img style="width: 20px; height: 20px;" src="<?php echo $team['crest']; ?>" alt="">
                        </span>
                        <span class="col-3"><?php echo $team['abr']; ?></span>
                        <span class="col-1"><?php echo $team['wins']; ?></span>
                        <span class="col-1"><?php echo $team['draws']; ?></span>
                        <span class="col-1"><?php echo $team['losses']; ?></span>
                        <span class="col-2"><?php echo $team['goal_differential']; ?></span>
                        <span class="col-3 border-start"><?php echo $team['points']; ?></span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php include('partials/footer.php'); ?>