<?php
// Ver anuncio (parte privada): ver-anuncio.php?id=N
// Si N es par se muestra el anuncio 'par' y si es impar el anuncio 'impar' (datos/anuncios.php).
$titulo = 'Ver anuncio';
$zona = 'privada';
require 'includes/cabecera.php';
require 'includes/inicio.php';

$id = $_GET['id'] ?? '';
$anuncios = require 'datos/anuncios.php';
?>
<main id="contenido" class="columnas">
<?php if (!ctype_digit($id)): ?>
<h1>Anuncio no encontrado</h1>
<p>El enlace no es correcto. <a href="mis-anuncios.php">Volver a mis anuncios</a></p>
<?php else:
    $anuncio = ($id % 2 == 0) ? $anuncios['par'] : $anuncios['impar'];
    require 'includes/ficha-anuncio.php'; ?>
<section>
<h2>Fotos del anuncio</h2>
<p><a href="anadir-foto.php?anuncio=<?= $anuncio['id'] ?>">Añadir una foto a este anuncio</a></p>
</section>
<?php endif; ?>
</main>
<?php require 'includes/pie.php'; ?>
