<?php
session_start();
$current_page = 'viewmenus.php';

$menu_filepath = 'files/menu.txt';
$categories_filepath = 'files/categories.txt';

include_once 'fn-php/fn-menu.php';

// Generate tables by category
$tables = generateMenuTables($menu_filepath, $categories_filepath);

?>

<?php include_once "topmenu.php"; ?>

<main class="flex-grow-1 container-fluid py-4">
    <div class="container-fluid">
        <div class="container">
            <h1 class="text-center display-4 mt-0 bg-dark text-white fw-semibold pb-2 mb-3 rounded-2">Our Menu</h1>
            <div class="row">
                <?php
                if (isset($tables['error'])) {
                    echo "<div class='alert alert-danger'>{$tables['error']}</div>";
                } else {
                    foreach ($tables as $table) {
                        echo "<div class='col-lg-4 col-md-6 mb-3'>$table</div>";
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