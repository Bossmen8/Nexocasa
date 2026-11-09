<?php
// Formulario para enviar un mensaje al anunciante (POST a respuesta-enviar-mensaje.php)
$titulo = 'Enviar mensaje';
require 'includes/cabecera.php';
require 'includes/inicio.php';
?>
<main id="contenido">
<h1>Enviar mensaje al anunciante</h1>
<form class="conBorde" action="respuesta-enviar-mensaje.php" method="post" novalidate>
<fieldset>
<legend>Tipo de mensaje *</legend>
<label><input type="radio" name="tipo-mensaje" value="mas-informacion"> Más información</label>
<label><input type="radio" name="tipo-mensaje" value="solicitar-cita"> Solicitar una cita</label>
<label><input type="radio" name="tipo-mensaje" value="comunicar-oferta"> Comunicar una oferta</label>
</fieldset>
<p>
<label for="texto-mensaje">Texto *</label><br>
<textarea id="texto-mensaje" name="texto-mensaje" rows="6" cols="50"></textarea>
</p>
<p><button type="submit">Enviar mensaje</button></p>
</form>
</main>
<?php require 'includes/pie.php'; ?>
