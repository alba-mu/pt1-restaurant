<?php
session_start();
$current_page = 'daymenu.php';

$dayMenu_filepath = 'files/daymenu.txt';
$categories_filepath = 'files/categories.txt';

include_once 'fn-php/fn-menu.php';

// Generar lllistes per categoria
$lists = generateDayMenuLists($dayMenu_filepath, $categories_filepath);
?>

<?php include_once "topmenu.php"; ?>

<main class="flex-grow-1 container-fluid py-4">
    <div class="container-fluid">
        <div class="container" style='max-width: 650px;'>
            <h1 class="text-center display-3 mt-0 bg-dark fw-semibold text-white pb-2 mb-3 rounded-2">Menú del Dia</h1>
            <div class="row g-3">

                <?php
                    if (isset($lists['error'])) {
                        echo "<div class='alert alert-danger'>{$lists['error']}</div>";
                    } else {
                        foreach ($lists as $list) {
                            echo "<div class='col-12 d-flex justify-content-center'>
                                    <div class='w-100 text-center' style='max-width: 650px;'>
                                        $list
                                    </div>
                                  </div>";
                        }
                    }
                ?>

            </div>
        </div>
    </div>
</main>

<?php include_once "footer.php"; ?>

</body>

</html>