<?php
// Añadir foto a anuncio (parte privada).
// - Desde el menú: anadir-foto.php → el usuario elige el anuncio.
// - Desde "Mis anuncios" o "Ver anuncio": anadir-foto.php?anuncio=N → el anuncio ya está elegido y no se puede cambiar.
// La subida de la foto y la respuesta se harán en otra práctica.
$titulo = 'Añadir foto a anuncio';
$zona = 'privada';
require 'includes/cabecera.php';
require 'includes/inicio.php';

$anuncios = require 'datos/anuncios.php';
$elegido = $_GET['anuncio'] ?? '';   // id del anuncio que viene en la URL ('' si se llega desde el menú)
?>
<main id="contenido">
<h1>Añadir una foto a un anuncio</h1>
<form class="conBorde" action="error-404.php" method="post" enctype="multipart/form-data">
<p>
<label for="anuncio">Anuncio *</label><br>
<?php if ($elegido === ''): ?>
<select id="anuncio" name="anuncio">
<option value="" selected>(Elige un anuncio)</option>
<?php foreach ($anuncios as $anuncio): ?>
<option value="<?= $anuncio['id'] ?>"><?= e($anuncio['titulo']) ?></option>
<?php endforeach; ?>
</select>
<?php else: ?>
<!-- disabled: no se puede cambiar. Un select disabled no se envía, por eso va también un campo oculto -->
<select id="anuncio" disabled>
<?php foreach ($anuncios as $anuncio): ?>
<option value="<?= $anuncio['id'] ?>"<?= $anuncio['id'] == $elegido ? ' selected' : '' ?>><?= e($anuncio['titulo']) ?></option>
<?php endforeach; ?>
</select>
<input type="hidden" name="anuncio" value="<?= e($elegido) ?>">
<?php endif; ?>
</p>
<p>
<label for="foto">Foto *</label><br>
<input type="file" id="foto" name="foto" accept="image/*">
</p>
<p>
<label for="texto-alternativo">Texto alternativo * (mínimo 10 caracteres)</label><br>
<input type="text" id="texto-alternativo" name="texto-alternativo" minlength="10">
</p>
<p>
<label for="titulo-foto">Título *</label><br>
<input type="text" id="titulo-foto" name="titulo">
</p>
<p><button type="submit">Añadir foto</button></p>
</form>
</main>
<?php require 'includes/pie.php'; ?>
