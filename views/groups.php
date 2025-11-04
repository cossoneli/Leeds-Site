<?php
include('partials/header.php');
include('../helpers/location_names.php');
?>


<h2 class="my-4 text-center">Fan support groups</h2>

<div class="container d-flex flex-wrap justify-content-center">
    <?php
    for ($i = 0; $i < count($locations); $i++) { ?>
        <div class="card m-2" style="width: 14rem;">
            <i class="fa fa-info ms-auto p-2" aria-hidden="true"></i>
            <div class="card-body d-flex justify-content-between align-items-center">
                <p class="card-text text-center"><?php echo $locations[$i]; ?></p>
                <a class="btn btn-outline-dark" href="https://www.luamericas.com/" role="button">Link</a>
            </div>
        </div>
    <?php } ?>
</div>

<?php include('partials/footer.php'); ?>