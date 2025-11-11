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

    // Lllegir categories per garantir l'ordre
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
        $tables[$cat] = "<h5 class='display-5'>$title</h5>
                        <table class='table table-striped'>
                            <thead><tr><th>Nom</th><th>Preu</th></tr></thead>
                            <tbody>$rows</tbody>
                        </table>";
    }

    return $tables;
}
