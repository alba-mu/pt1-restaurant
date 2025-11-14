<?php
/**
 * File: fn-menu.php
 * Author: Alba Muñoz
 * Date: 14/11/2025
 *
 * Description:
 * This file contains functions to read menu and daily menu files and generate
 * HTML representations for the website. It provides:
 *  - generateMenuTables(): returns HTML tables grouped by category for the full menu.
 *  - generateDayMenuLists(): returns HTML lists grouped by category for the daily menu,
 *    including a final card showing the menu price.
 */

/**
 * Reads the category and menu files and returns an array with HTML tables grouped by category
 * @param string $menu_filepath
 * @param string $categories_filepath
 * @return array Associative: 'category' => 'HTML table'
 */
function generateMenuTables(string $menu_filepath, string $categories_filepath): array {
    $menu_by_category = [];

    // Check that the files exist
    if (!file_exists($menu_filepath) || !file_exists($categories_filepath)) {
        return ['error' => "One of the files could not be found (categories.txt or menu.txt)."];
    }

    // Read categories to keep the order
    $categories = file($categories_filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Read menu line by line
    if ($handle_menu = fopen($menu_filepath, 'r')) {
        while (($line = fgets($handle_menu)) !== false) {
            $line = trim($line);
            // Ignore empty lines and header
            if ($line === '' || $line === 'id;category;name;price') continue;

            // Split the elements of each line
            $parts = explode(';', $line);
            $id = $parts[0];
            $category = $parts[1];
            $name = $parts[2];
            $price = $parts[3] . ' €';

            // Save each row inside its category
            $menu_by_category[$category][] = "<tr><td>$name</td><td>$price</td></tr>";
        }
        fclose($handle_menu);
    } else {
        return ['error' => 'Error opening the menu file.'];
    }

    // Generate the HTML tables for each category in the order defined by categories.txt
    $tables = [];
    foreach ($categories as $cat) {
        if (!isset($menu_by_category[$cat])) continue;
        $title = ucfirst($cat);
        $rows = implode('', $menu_by_category[$cat]);
        $tables[$cat] = "<h5 class='fs-2 fw-light bg-dark-subtle p-1 ps-2 rounded-2'>$title</h5>
                        <table class='table'>
                            <tbody>$rows</tbody>
                        </table>";
    }

    return $tables;
}

/**
 * Reads the category and daily menu files and returns an array with HTML lists grouped by category,
 * including a final card with the menu price.
 * @param string $dayMenu_filepath
 * @param string $categories_filepath
 * @param float $menu_price Menu price per person
 * @return array Associative: 'category' => 'HTML list'
 */
function generateDayMenuLists(string $dayMenu_filepath, string $categories_filepath, float $menu_price = 23.90): array {
    $menu_by_category = [];

    // Check that the files exist
    if (!file_exists($dayMenu_filepath) || !file_exists($categories_filepath)) {
        return ['error' => "One of the files could not be found (categories.txt or daymenu.txt)."];
    }

    // Read categories to keep the order
    $categories = file($categories_filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Read daily menu line by line
    if ($handle_menu = fopen($dayMenu_filepath, 'r')) {
        while (($line = fgets($handle_menu)) !== false) {
            $line = trim($line);
            // Ignore empty lines and header
            if ($line === '' || $line === 'id;category;name') continue;

            // Split the elements of each line
            $parts = explode(';', $line);
            $id = $parts[0];
            $category = $parts[1];
            $name = $parts[2];

            // Save each row inside its category
            $menu_by_category[$category][] = "<li class='list-group-item mb-1 mt-1 p-0'>$name</li>";
        }
        fclose($handle_menu);
    } else {
        return ['error' => 'Error opening the menu file.'];
    }

    // Generate the HTML lists for each category in the order defined by categories.txt
    $lists = [];
    foreach ($categories as $cat) {
        if (!isset($menu_by_category[$cat])) continue;
        $title = ucfirst($cat);
        $rows = implode('', $menu_by_category[$cat]);
        $lists[$cat] = "
                        <div class='card shadow-sm'>
                            <div class='card-header bg-dark-subtle pb-0'>
                                <h5 class='fs-2 fw-light'>$title</h5>
                            </div>
                            <div class='card-body p-1 ps-5 pe-5'>
                                <ul class='list-group list-group-flush mb-0'>
                                    $rows
                                </ul>
                            </div>
                        </div>
                    ";
    }

    // Add final card with the menu price
    $lists[] = "
        <div class='col-12'>
            <div class='card border border-0'>
                <div class='card-body text-center bg-dark text-white fs-1 fw-semibold rounded-4 p-1'>
                    " . number_format($menu_price, 2, ',', '.') . " €
                </div>
            </div>
        </div>
    ";

    return $lists;
}
?>