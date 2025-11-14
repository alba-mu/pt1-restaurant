<?php
/**
 * File: daymenu.php
 * Author: Alba Muñoz
 * Date: 14/11/2025
 *
 * Description:
 * This page displays the daily menu of ProvenSoft Restaurant. 
 * It reads the daily menu items from 'daymenu.txt' and organizes 
 * them by category. Each category list is displayed in a centered, 
 * responsive layout using Bootstrap. If there is an error reading 
 * the menu, an alert message is shown.
 * Access is restricted to logged-in users (registered or admin).
 */
session_start();
$current_page = 'daymenu.php';

$dayMenu_filepath = 'files/daymenu.txt';
$categories_filepath = 'files/categories.txt';

include_once 'fn-php/fn-menu.php';
include_once 'fn-php/fn-roles.php';

// Redirect if user is not allowed
if (!isGranted($_SESSION['role'] ?? '', 'daymenu')) {
    header('Location: login.php');
    exit;
}

// Generate lists by category
$lists = generateDayMenuLists($dayMenu_filepath, $categories_filepath);
?>

<?php include_once "includes/topmenu.php"; ?>

<main class="flex-grow-1 container-fluid py-4">
    <div class="container-fluid">
        <div class="container" style='max-width: 650px;'>
            <h1 class="text-center display-4 mt-0 bg-dark fw-semibold text-white pb-2 mb-3 rounded-2">Daily Menu</h1>
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

<?php include_once "includes/footer.php"; ?>

</body>

</html>