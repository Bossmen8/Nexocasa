<?php
// Muestra toda la información de $anuncio. Lo usan detalle-anuncio.php y ver-anuncio.php.
?>
<article>
<p><?= e($anuncio['tipoAnuncio']) ?> &middot; <?= e($anuncio['tipoVivienda']) ?></p>
<h1><?= e($anuncio['titulo']) ?></h1>
<p><img src="<?= e($anuncio['foto']) ?>" alt="Foto principal: <?= e($anuncio['titulo']) ?>" width="400"></p>
<p><?= e($anuncio['texto']) ?></p>
<p>Publicado el <?= e($anuncio['fecha']) ?></p>
<p><?= e($anuncio['ciudad']) ?>, <?= e($anuncio['pais']) ?></p>
<p><?= e($anuncio['precio']) ?></p>
<h2>Fotos</h2>
<ul>
<?php foreach ($anuncio['fotos'] as $i => $foto): ?>
<li><img src="<?= e($foto) ?>" alt="Foto <?= $i + 1 ?> de <?= e($anuncio['titulo']) ?>" width="120"></li>
<?php endforeach; ?>
</ul>
</article>
<aside>
<h2>Características</h2>
<table>
<tr><th scope="row">Superficie</th><td><?= e($anuncio['superficie']) ?></td></tr>
<tr><th scope="row">Habitaciones</th><td><?= $anuncio['habitaciones'] ?></td></tr>
<tr><th scope="row">Baños</th><td><?= $anuncio['banos'] ?></td></tr>
<tr><th scope="row">Planta</th><td><?= $anuncio['planta'] ?></td></tr>
<tr><th scope="row">Año de construcción</th><td><?= $anuncio['anio'] ?></td></tr>
</table>
</aside>
