<?php
include __DIR__ . '/partials/header.php';
include __DIR__ . '/../helpers/location_names.php';
?>


<h2 class="my-4 text-center fw-bold">Fan Support Groups</h2>

<div class="container d-flex flex-wrap justify-content-center gap-3">
    <?php foreach ($locations as $location):
        $location_lower = strtolower(str_replace(' ', '', $location));
        if ($location_lower == "d.c.") {
            $location_lower = "dc";
        }

        ?>
        <div class="border rounded-3 p-3 d-flex flex-column align-items-center justify-content-between"
            style="width: 180px; min-height: 100px; background-color: #f8f9fa; transition: transform 0.15s ease;">

            <p class="text-center fw-semibold mb-3"><?php echo $location; ?></p>

            <a class="btn btn-outline-primary btn-sm w-100" href="https://www.luamericas.com/<?php echo $location_lower; ?>"
                target="_blank">
                Visit Link
            </a>
        </div>
    <?php endforeach; ?>
</div>


<?php include __DIR__ . '/partials/footer.php';
?>