<?php include('partials/header.php'); ?>

<div class="container my-5">
    <form action="../controllers/login_validate.php" method="POST">
        <div class="mb-3">
            <label for="user_name" class="form-label">Username</label>
            <input type="text" class="form-control" name="user_name" id="user_name">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" name="logged_in" class="btn btn-primary">Register</button>
    </form>
</div>



<?php include('partials/footer.php'); ?>