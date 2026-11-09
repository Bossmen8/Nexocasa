<?php
// Menú del usuario registrado
$titulo = 'Menú de usuario';
$zona = 'privada';
require 'includes/cabecera.php';
require 'includes/inicio.php';
?>
<main id="contenido">
<h1>Menú de usuario registrado</h1>
<ul>
<li><a href="error-404.php">Modificar mis datos</a></li>
<li><a href="error-404.php">Darme de baja</a></li>
<li><a href="mis-anuncios.php">Ver mis anuncios</a></li>
<li><a href="crear-anuncio.php">Crear anuncio nuevo</a></li>
<li><a href="anadir-foto.php">Añadir foto a anuncio</a></li>
<li><a href="mis-mensajes.php">Mis mensajes</a></li>
<li><a href="solicitar-folleto.php">Solicitar folleto publicitario</a></li>
<li><a href="index.php">Salir</a></li>
</ul>
</main>
<?php require 'includes/pie.php'; ?>
