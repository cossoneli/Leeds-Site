<!DOCTYPE html>
<html lang="en">

<?php
// $baseUrl = '/LeedsSite/public'; // local development base URL
$baseUrl = ''; // production base URL
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

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="?page=home">
                <span class="fw-bold text-muted">Leeds United</span>
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=table">Table</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=fixtures">Fixtures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=groups">Groups</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=faq">FAQ</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php
                    session_start();
                    if (isset($_SESSION['username'])) { ?>
                        <li class="nav-item">
                            <a href="/index.php?page=logout" class="nav-link btn rounded-pill px-3 ms-2"
                                style="background-color: #1D428A; color: #FFCD00; border: 2px solid #FFCD00;">
                                Logout
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link btn rounded-pill px-3 ms-2" href="?page=login"
                                style="background-color: white; color: #1D428A; border: 2px solid #1D428A;">
                                Log in
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn rounded-pill px-3 ms-2" href="?page=signup"
                                style="background-color: #FFCD00; color: #1D428A; border: 2px solid #1D428A;">
                                Sign up
                            </a>
                        </li>
                    <?php } ?>
                </ul>

            </div>
        </div>
    </nav>