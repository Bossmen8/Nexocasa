<?php
// Resultado de la búsqueda: muestra los datos que ha enviado el usuario (por GET)
// desde la búsqueda rápida o desde el formulario de búsqueda, y un listado de ejemplo.
$titulo = 'Resultado de la búsqueda';
require 'includes/cabecera.php';
require 'includes/inicio.php';

// nombre del campo => texto que se muestra
$campos = [
    'tipo-anuncio' => 'Tipo de anuncio',
    'tipo-vivienda' => 'Tipo de vivienda',
    'ciudad' => 'Ciudad',
    'pais' => 'País',
    'precio-desde' => 'Precio desde',
    'precio-hasta' => 'Precio hasta',
    'fecha-desde' => 'Fecha desde',
    'fecha-hasta' => 'Fecha hasta',
];
?>
<main id="contenido">
<h1>Resultado de la búsqueda</h1>
<section class="conBorde">
<h2>Has buscado</h2>
<ul>
<?php
$hayDatos = false;
foreach ($campos as $nombre => $texto) {
    if (!empty($_GET[$nombre])) {
        echo '<li>' . $texto . ': ' . e($_GET[$nombre]) . '</li>';
        $hayDatos = true;
    }
}
if (!$hayDatos) {
    echo '<li>No has indicado ningún criterio.</li>';
}
?>
</ul>
</section>
<h2>Anuncios encontrados</h2>
<?php require 'includes/lista-anuncios.php'; ?>
</main>
<?php require 'includes/pie.php'; ?>
