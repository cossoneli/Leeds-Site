<?php include('partials/header.php'); ?>


<h2 class="my-2 text-center">Fan support groups</h2>

<div class="container d-flex flex-wrap justify-content-center">
    <?php for ($i = 0; $i < 30; $i++) { ?>
        <div class="card m-2" style="width: 14rem;">
            <i class="fa fa-info ms-auto p-2" aria-hidden="true"></i>
            <img src="../public/imgs/lu_americas_logo.png" class="card-img-top" alt="...">
            <div class="card-body d-flex justify-content-between align-items-center">
                <p class="card-text">Arizona</p>
                <button type="button" class="btn btn-outline-dark">Learn More</button>
            </div>
        </div>
    <?php } ?>
</div>

<?php include('partials/footer.php'); ?>