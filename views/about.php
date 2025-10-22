<?php
include('partials/header.php');

?>


<?php

if (isset($_SESSION['loggedin'])) {
    ?>
    <div class="alert alert-success alert-dismissable fade show d-flex justify-content-between" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        <div>
            Successfully Logged in!
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION['loggedin']);
} else if (isset($_SESSION['message'])) {
    ?>

        <div class="alert alert-success alert-dismissable fade show d-flex justify-content-between" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>
                Successfully Logged out!
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <?php
        unset($_SESSION['message']);
}
?>

<h1 class="fw-light text-center mt-3">Hi <?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : ""; ?>, Welcome to LU
    Americas!</h1>

<section class="main-body my-5">
    <div id="carouselExampleInterval" class="carousel slide w-25 mx-auto" style="height: 250px;"
        data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="../public/imgs/lu_americas_1.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="../public/imgs/lu_americas_2.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="../public/imgs/lu_americas_3.png" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <div class="about w-75 mx-auto my-5">
        <p>We're a community of Leeds United supporters across North and South America — united by our love for the
            club. Whether you're catching matches at dawn, connecting with fellow fans, or flying the white, yellow,
            and
            blue wherever you are, this is your home away from Elland Road.
            <br><br>
            Join us to stay up to date on watch parties, fan events, and all things Leeds. Marching on together! 💛💙🤍
        </p>
    </div>

</section>


<?php include('partials/footer.php'); ?>