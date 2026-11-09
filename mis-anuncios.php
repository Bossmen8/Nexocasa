<?php
// Mis anuncios (parte privada): foto, título, ciudad, país y precio de cada anuncio del usuario
$titulo = 'Mis anuncios';
$zona = 'privada';
require 'includes/cabecera.php';
require 'includes/inicio.php';
$anuncios = require 'datos/anuncios.php';
?>
<main id="contenido">
<h1>Mis anuncios</h1>
<table>
<tr>
<th scope="col">Foto</th>
<th scope="col">Título</th>
<th scope="col">Ciudad</th>
<th scope="col">País</th>
<th scope="col">Precio</th>
<th scope="col">Opciones</th>
</tr>
<?php foreach ($anuncios as $anuncio): ?>
<tr>
<td><img src="<?= e($anuncio['foto']) ?>" alt="<?= e($anuncio['titulo']) ?>" width="100"></td>
<td><?= e($anuncio['titulo']) ?></td>
<td><?= e($anuncio['ciudad']) ?></td>
<td><?= e($anuncio['pais']) ?></td>
<td><?= e($anuncio['precio']) ?></td>
<td>
<a href="ver-anuncio.php?id=<?= $anuncio['id'] ?>">Ver anuncio</a><br>
<a href="anadir-foto.php?anuncio=<?= $anuncio['id'] ?>">Añadir foto</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</main>
<?php require 'includes/pie.php'; ?>
