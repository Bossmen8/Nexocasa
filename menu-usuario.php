<?php
<<<<<<< HEAD
/*
 * Menú del usuario registrado (página principal de la parte privada). Se llega aquí desde
 * control-acceso.php tras un acceso correcto, o directamente si el usuario está recordado.
 * Práctica 8: el nombre sale de la SESIÓN y el saludo depende de la franja horaria.
 */
require_once 'includes/funciones.php';
requerirAcceso();   // práctica 8: página protegida, sin sesión redirige a index.php
=======
/* Menú del usuario registrado (parte privada). Se llega aquí desde control-acceso.php tras un acceso correcto. */
>>>>>>> main
$titulo = 'Menú de usuario';
$zona = 'privada';
require_once 'includes/cabecera.php';
require_once 'includes/inicio.php';
<<<<<<< HEAD
$usuario = usuarioActual();

$opciones = [
    'error-404.php'         => ['fa-user-pen', 'Modificar mis datos'],
    'error-404.php?baja'    => ['fa-user-minus', 'Darme de baja'],
    'mis-anuncios.php'      => ['fa-rectangle-list', 'Ver mis anuncios'],
    'crear-anuncio.php'     => ['fa-circle-plus', 'Crear anuncio nuevo'],
    'anadir-foto.php'       => ['fa-camera', 'Añadir foto a anuncio'],
    'mis-mensajes.php'      => ['fa-envelope', 'Mis mensajes'],
    'solicitar-folleto.php' => ['fa-print', 'Solicitar folleto publicitario'],
    'salir.php'             => ['fa-right-from-bracket', 'Salir'],
];
?>
<main id="contenido">
<h1><?= e(saludo($usuario)) ?></h1>
<p>Estás en el menú de usuario registrado. Tu estilo visual es <strong><?= e(estiloActual()) ?></strong>.</p>
<ul>
<?php foreach ($opciones as $href => [$icono, $texto]): ?>
<li><a href="<?= e($href) ?>"><i class="fa-solid <?= $icono ?>" aria-hidden="true"></i><?= $texto ?></a></li>
<?php endforeach; ?>
</ul>
</main>
<?php require_once 'includes/pie.php'; ?>
=======
$usuario = leer($_GET, 'usuario');

$opciones = [
    'error-404.php' => ['fa-user-pen', 'Modificar mis datos'],
    'error-404.php?baja' => ['fa-user-minus', 'Darme de baja'],
    'mis-anuncios.php' => ['fa-rectangle-list', 'Ver mis anuncios'],
    'crear-anuncio.php' => ['fa-circle-plus', 'Crear anuncio nuevo'],
    'anadir-foto.php' => ['fa-camera', 'Añadir foto a anuncio'],
    'mis-mensajes.php' => ['fa-envelope', 'Mis mensajes'],
    'solicitar-folleto.php' => ['fa-print', 'Solicitar folleto publicitario'],
    'index.php' => ['fa-right-from-bracket', 'Salir'],
];
?>
<main id="contenido">
    <h1>Menú de usuario registrado</h1>
    <?php if ($usuario !== ''): ?>
        <p>Has iniciado sesión correctamente como <strong><?= e($usuario) ?></strong>.</p>
    <?php endif; ?>
    <ul>
        <?php foreach ($opciones as $href => [$icono, $texto]): ?>
            <li><a href="<?= e($href) ?>"><i class="fa-solid <?= $icono ?>" aria-hidden="true"></i><?= $texto ?></a></li>
        <?php endforeach; ?>
    </ul>
</main>
<?php require_once 'includes/pie.php'; ?>
>>>>>>> main
