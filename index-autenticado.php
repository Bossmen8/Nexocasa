<?php
/* Página principal de la parte privada: igual que la pública pero sin el formulario de acceso. */
<<<<<<< HEAD
require_once 'includes/funciones.php';
requerirAcceso();   // práctica 8: página protegida, sin sesión redirige a index.php
=======
>>>>>>> main
$titulo = 'Inicio';
$zona = 'privada';
require_once 'includes/cabecera.php';
require_once 'includes/inicio.php';
require_once 'includes/anuncios.php';
?>
<main id="contenido" class="columnas">
<<<<<<< HEAD
<h1>Encuentra tu próximo hogar en España</h1>
<?php require 'includes/busqueda-rapida.php'; ?>
<section>
<h2>Últimos anuncios publicados</h2>
<?php listaAnuncios(require 'datos/ultimos-anuncios.php', 'detalle-anuncio.php', 'h3'); ?>
</section>
</main>
<?php require_once 'includes/pie.php'; ?>
=======
    <h1>Encuentra tu próximo hogar en España</h1>
    <?php require 'includes/busqueda-rapida.php'; ?>
    <section>
        <h2>Últimos anuncios publicados</h2>
        <?php listaAnuncios(require 'datos/ultimos-anuncios.php', 'detalle-anuncio.php', 'h3'); ?>
    </section>
</main>
<?php require_once 'includes/pie.php'; ?>
>>>>>>> main
