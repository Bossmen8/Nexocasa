<?php
// Respuesta al envío de un mensaje: comprueba el tipo y el texto y muestra los datos recibidos.
$titulo = 'Enviar mensaje';
require 'includes/cabecera.php';
require 'includes/inicio.php';

$tipos = [
    'mas-informacion' => 'Más información',
    'solicitar-cita' => 'Solicitar una cita',
    'comunicar-oferta' => 'Comunicar una oferta',
];
$tipo = $_POST['tipo-mensaje'] ?? '';
$texto = trim($_POST['texto-mensaje'] ?? '');

$errores = [];
if (!isset($tipos[$tipo])) {
    $errores[] = 'Tienes que elegir un tipo de mensaje válido.';
}
if ($texto === '') {
    $errores[] = 'Tienes que escribir el texto del mensaje.';
}
?>
<main id="contenido">
<?php if ($errores): ?>
<h1>No se ha podido enviar el mensaje</h1>
<div class="resumen-errores" role="alert">
<ul>
<?php foreach ($errores as $error): ?>
<li><?= $error ?></li>
<?php endforeach; ?>
</ul>
</div>
<p><a href="enviar-mensaje.php">Volver al formulario</a></p>
<?php else: ?>
<h1>Mensaje enviado con éxito</h1>
<p>Tipo de mensaje: <?= $tipos[$tipo] ?></p>
<p>Texto: <?= e($texto) ?></p>
<?php endif; ?>
</main>
<?php require 'includes/pie.php'; ?>
