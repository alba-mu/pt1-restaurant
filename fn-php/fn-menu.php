<?php
/**
 * Llegeix els fitxers de categories i menú i retorna un array amb les taules HTML agrupades per categoria
 * @param string $menu_filepath
 * @param string $categories_filepath
 * @return array Associatiu: 'categoria' => 'taula HTML'
 */
function generateMenuTables(string $menu_filepath, string $categories_filepath): array {
    $menu_by_category = [];

    // Comprovar que els fitxers existeixin
    if (!file_exists($menu_filepath) || !file_exists($categories_filepath)) {
        return ['error' => "No s'ha trobat un dels fitxers (categories.txt o menu.txt)."];
    }

    // Llegir categories per garantir l'ordre
    $categories = file($categories_filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Llegir menú línia per línia
    if ($handle_menu = fopen($menu_filepath, 'r')) {
        while (($line = fgets($handle_menu)) !== false) {
            $line = trim($line);
            // Ignorar línies buides i capçalera
            if ($line === '' || $line === 'id;category;name;price') continue;

            // Separar els elements de cada línia
            $parts = explode(';', $line);
            $id = $parts[0];
            $category = $parts[1];
            $name = $parts[2];
            $price = $parts[3] . ' €';

            // Guardar cada fila dins de la seva categoria
            $menu_by_category[$category][] = "<tr><td>$name</td><td>$price</td></tr>";
        }
        fclose($handle_menu);
    } else {
        return ['error' => 'Error en obrir el fitxer del menú.'];
    }

    // Gerenar les taules HTML per cada categoria en l'ordre de categories.txt
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
 * Llegeix els fitxers de categories i menú del dia i retorna un array amb llites HTML agrupades per categoria,
 * incloent una targeta final amb el preu del menú.
 * @param string $dayMenu_filepath
 * @param string $categories_filepath
 * @param float $menu_price Preu del menú per persona
 * @return array Associatiu: 'categoria' => 'llista HTML'
 */
function generateDayMenuLists(string $dayMenu_filepath, string $categories_filepath, float $menu_price = 23.90): array {
    $menu_by_category = [];

    // Comprovar que els fitxers existeixin
    if (!file_exists($dayMenu_filepath) || !file_exists($categories_filepath)) {
        return ['error' => "No s'ha trobat un dels fitxers (categories.txt o daymenu.txt)."];
    }

    // Llegir categories per garantir l'ordre
    $categories = file($categories_filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Llegir menú del dia línia per línia
    if ($handle_menu = fopen($dayMenu_filepath, 'r')) {
        while (($line = fgets($handle_menu)) !== false) {
            $line = trim($line);
            // Ignorar línies buides i capçalera
            if ($line === '' || $line === 'id;category;name') continue;

            // Separar els elements de cada línia
            $parts = explode(';', $line);
            $id = $parts[0];
            $category = $parts[1];
            $name = $parts[2];

            // Guardar cada fila dins de la seva categoria
            $menu_by_category[$category][] = "<li class='list-group-item mb-1 mt-1 p-0'>$name</li>";
        }
        fclose($handle_menu);
    } else {
        return ['error' => 'Error en obrir el fitxer del menú.'];
    }

    // Gerenar les taules HTML per cada categoria en l'ordre de categories.txt
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

    // Afegir targeta final amb el preu del menú
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
