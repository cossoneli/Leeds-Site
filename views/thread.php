<?php
include('partials/header.php');
include('../models/thread_model.php');

$topic = $_GET['topic'] ?? 'Discussion Thread';

$query = "select * from `table_comments`";

$result = mysqli_query($connection, $query);

if (!$result)
    die(mysqli_error($connection));

?>
<div class="bg-light text-dark py-4 mb-4 border-bottom shadow-sm">
    <div class="container text-center">
        <h2 class="mb-1 fw-semibold"><?php echo htmlspecialchars($topic); ?></h2>
        <p class="text-muted mb-0">Match Thread</p>
    </div>
</div>

<div class="container my-4">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 fw-bold text-primary">
                        <?php echo htmlspecialchars($row['username']); ?>
                    </h6>
                    <span class="badge bg-light text-dark">
                        👍 <?php echo htmlspecialchars($row['votes']); ?>
                    </span>
                </div>
                <p class="card-text text-muted mb-0">
                    <?php echo nl2br(htmlspecialchars($row['comment'])); ?>
                </p>
            </div>
        </div>
    <?php } ?>
</div>




<?php include('partials/footer.php'); ?>