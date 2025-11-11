<?php
session_start();
$current_page = 'viewmenus.php';

$menu_filepath = 'files/menu.txt';
$categories_filepath = 'files/categories.txt';

if (file_exists($menu_filepath) && file_exists($categories_filepath)) {
    $handle_menu = fopen($menu_filepath, 'r'); // Abrir el fichero en modo lectura
    $handle_categories = fopen($categories_filepath, 'r');
    if ($handle_menu && $handle_categories) {
        $menu_by_category = []; // Array asociativo: 'categoria' => [filas]
        while (($line = fgets($handle_menu)) !== false) { // Leer línea por línea
            $line = trim($line); // Quitar posibles saltos de línea
            if ($line === '') continue; // Ignorar líneas vacías
            if ($line === 'id;category;name;price') continue; // Ignorar fila de cabecera
            
            // Aquí procesaremos cada línea
            $parts = explode(';', $line);
            $id = $parts[0];
            $category = $parts[1];
            $name = $parts[2];
            $price = $parts[3];

            
            $tr = "<tr><td>$name</td><td>$price</td></tr>";
            $menu_by_category[$category][] = $tr;
            
        }
        fclose($handle_menu); // Cerrar el fichero menu.txt
        fclose($handle_categories); // Cerrar el fichero categories.txt
    } else {
        echo "No se pudo abrir el fichero.";
    }
} else {
    echo "El fichero no existe.";
}
?>

<!--Barra de navegació-->
<?php include_once "topmenu.php"; ?>

<!-- Contingut de la pàgina -->
<main class="flex-grow-1 container py-4">
    <div class="container-fluid">

        <div class="container">            
            <?php
            foreach ($menu_by_category as $cat => $rows) {
                echo "<h3>$cat</h3>";
                echo "<table class='table table-striped'>";
                echo "<thead><tr><th>Nom</th><th>Preu</th></tr></thead>";
                echo "<tbody>";
                foreach ($rows as $row) {
                    echo $row;
                }
                echo "</tbody></table>";
            }
            ?>

        </div>
    </div>
</main>

<!-- Footer -->
<?php include_once "footer.php"; ?>

</body>

</html>