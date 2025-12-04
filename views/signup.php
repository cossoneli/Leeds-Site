<?php include __DIR__ . '/partials/header.php';

// $baseUrl = '/LeedsSite'; // local development base URL
$baseUrl = ''; // production base URL
?>

<div class="container my-5" style="max-width: 400px;">
    <h2 class="text-center mb-4" style="color:#1D428A; font-weight: bold;">Sign Up</h2>
    <form action="<?= $baseUrl ?>/controllers/signup_validate.php" method="POST">
        <div class="mb-3">
            <label for="user_name" class="form-label" style="color:#1D428A;">Username</label>
            <input type="text" class="form-control" name="user_name" id="user_name"
                style="border: 2px solid #1D428A; border-radius: 25px;" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label" style="color:#1D428A;">Email address</label>
            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                style="border: 2px solid #1D428A; border-radius: 25px;" required>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label" style="color:#1D428A;">Password</label>
            <input type="password" name="password" class="form-control" id="password"
                style="border: 2px solid #1D428A; border-radius: 25px;" required>
        </div>
        <button type="submit" name="logged_in" class="btn btn-primary w-100 rounded-pill"
            style="background-color:#FFCD00; color:#1D428A; border: 2px solid #1D428A; font-weight:bold;">
            Register
        </button>
    </form>
</div>

<?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
    <div class="container my-3" style="max-width: 400px;">
        <div class="alert alert-danger text-center" role="alert">
            Account with email already exists.
        </div>
    </div>
<?php endif; ?>


<?php include __DIR__ . '/partials/footer.php';
?>