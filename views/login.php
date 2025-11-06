<?php include('partials/header.php'); ?>

<div class="container my-5" style="max-width: 400px;">
    <h2 class="text-center mb-4" style="color:#1D428A; font-weight: bold;">Login</h2>
    <form action="../controllers/login_validate.php" method="POST">
        <div class="mb-3">
            <label for="user_name" class="form-label" style="color:#1D428A;">Username</label>
            <input type="text" class="form-control" name="user_name" id="user_name"
                style="border: 2px solid #1D428A; border-radius: 25px;">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label" style="color:#1D428A;">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                style="border: 2px solid #1D428A; border-radius: 25px;">
        </div>
        <div class="mb-4">
            <label for="exampleInputPassword1" class="form-label" style="color:#1D428A;">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1"
                style="border: 2px solid #1D428A; border-radius: 25px;">
        </div>
        <button type="submit" name="logged_in" class="btn btn-primary w-100 rounded-pill"
            style="background-color:#FFCD00; color:#1D428A; border: 2px solid #1D428A; font-weight:bold;">
            Register
        </button>
    </form>
</div>




<?php include('partials/footer.php'); ?>