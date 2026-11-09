<?php
// Cálculo del coste de un folleto con las tarifas de la práctica anterior.
// Lo usan solicitar-folleto.php (tabla) y respuesta-solicitar-folleto.php (coste final).
function costeFolleto($paginas, $fotos, $color, $dpi)
{
    $coste = 10; // procesamiento y envío

    // Páginas por bloques: las 4 primeras a 2 €, de la 5 a la 10 a 1,8 € y el resto a 1,6 €
    for ($pagina = 1; $pagina <= $paginas; $pagina++) {
        if ($pagina < 5) {
            $coste += 2;
        } elseif ($pagina <= 10) {
            $coste += 1.8;
        } else {
            $coste += 1.6;
        }
    }

    if ($color) {
        $coste += $fotos * 0.5;   // color: 0,5 € por foto
    }
    if ($dpi > 300) {
        $coste += $fotos * 0.2;   // más de 300 dpi: 0,2 € por foto
    }
    return $coste;
}

function euros($cantidad)
{
    return number_format($cantidad, 2, ',', '.') . ' €';
}
