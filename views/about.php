<?php
include('partials/header.php');
?>

<section class="hero text-center py-5 bg-light">
    <h1 class="fw-bold text-primary mb-3">Welcome to American Leeds!</h1>
    <p class="lead text-dark w-75 mx-auto">
        Connecting Leeds United supporters across North and South America. Share the passion, cheer for every goal,
        and unite with fellow fans no matter where you are!
    </p>

    <!-- Carousel -->
    <div id="carouselExampleInterval" class="carousel slide mt-4 w-75 mx-auto rounded shadow" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="../public/imgs/lu_americas_1.png" class="d-block w-100 rounded" alt="LU Fans">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="../public/imgs/lu_americas_2.png" class="d-block w-100 rounded" alt="LU Events">
            </div>
            <div class="carousel-item">
                <img src="../public/imgs/lu_americas_3.png" class="d-block w-100 rounded" alt="LU Community">
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
</section>

<section class="about py-5 bg-white">
    <div class="container">
        <h2 class="text-center fw-bold mb-4 text-primary">Who We Are</h2>
        <p class="text-center w-75 mx-auto mb-5">
            American Leeds is a community of Leeds United supporters across the Americas. Whether it's
            early-morning
            matches, local watch parties, or flying the club colors wherever you are, we bring fans together to share
            their love for the club. Our mission is simple: unite, celebrate, and support Leeds United, no matter the
            distance.
        </p>

        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-primary rounded">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Watch Parties</h5>
                        <p class="card-text">Join fans across the Americas for live match screenings. Experience every
                            goal and tackle with fellow supporters!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-warning rounded">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Fan Events</h5>
                        <p class="card-text">Connect with the community at social events, meetups, and charity drives
                            organized by American Leeds.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-info rounded">
                    <div class="card-body">
                        <h5 class="card-title text-info">News & Updates</h5>
                        <p class="card-text">Stay up to date on all things Leeds United — match schedules, transfers,
                            fan campaigns, and more!</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="signup.php" class="btn btn-primary btn-lg rounded-pill px-5">Join the Community 💛💙🤍</a>
        </div>
    </div>
</section>

<section class="cta py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Marching On Together!</h2>
        <p class="mb-4 w-75 mx-auto">No matter where you are in the Americas, American Leeds brings Leeds United
            supporters
            together.
            Join us today and celebrate your passion for the club with fellow fans!</p>
        <a href="signup.php" class="btn btn-outline-primary btn-lg rounded-pill px-5">Become a Member</a>
    </div>
</section>

<?php include('partials/footer.php'); ?>