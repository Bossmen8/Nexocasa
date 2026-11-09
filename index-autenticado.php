<?php
// Página principal de la parte privada
$titulo = 'Inicio';
$zona = 'privada';
require 'includes/cabecera.php';
require 'includes/inicio.php';
?>
<main id="contenido" class="columnas">
<h1>Encuentra tu próximo hogar en España</h1>
<section class="conBorde">
<h2>Búsqueda rápida</h2>
<form action="resultado-busqueda.php" method="get">
<p>
<label for="busqueda-rapida">Ciudad o provincia</label><br>
<input type="text" id="busqueda-rapida" name="ciudad">
</p>
<p><button type="submit">Buscar</button></p>
</form>
</section>
<section>
<h2>Últimos anuncios publicados</h2>
<?php require 'includes/lista-anuncios.php'; ?>
</section>
</main>
<?php require 'includes/pie.php'; ?>
