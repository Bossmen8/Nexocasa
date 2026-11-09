<?php
// Detalle de un anuncio: detalle-anuncio.php?id=N
// Si N es par se muestra el anuncio 'par' y si es impar el anuncio 'impar' (datos/anuncios.php).
$titulo = 'Detalle del anuncio';
require 'includes/cabecera.php';
require 'includes/inicio.php';

$id = $_GET['id'] ?? '';
$anuncios = require 'datos/anuncios.php';
?>
<main id="contenido" class="columnas">
<?php if (!ctype_digit($id)): ?>
<h1>Anuncio no encontrado</h1>
<p>El enlace no es correcto. <a href="index.php">Volver al inicio</a></p>
<?php else:
    $anuncio = ($id % 2 == 0) ? $anuncios['par'] : $anuncios['impar'];
    require 'includes/ficha-anuncio.php'; ?>
<section>
<h2>Anunciante</h2>
<p>Usuario: <?= e($anuncio['usuario']) ?></p>
<p><a href="enviar-mensaje.php">Enviar mensaje al anunciante</a></p>
</section>
<?php endif; ?>
</main>
<?php require 'includes/pie.php'; ?>
