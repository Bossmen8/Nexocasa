<?php
// Formulario de registro (POST a respuesta-registro.php).
// Si hay errores, respuesta-registro.php vuelve aquí con los errores y los datos en la URL:
//   registro.php?errores=usuario,no-coinciden&usuario=...&email=...
// Entonces se muestran los errores arriba y los campos se rellenan con lo que se había escrito.
$titulo = 'Registro';
require 'includes/cabecera.php';
require 'includes/inicio.php';

$mensajes = [
    'usuario' => 'Tienes que escribir el nombre de usuario.',
    'password' => 'Tienes que escribir la contraseña.',
    'repetir' => 'Tienes que repetir la contraseña.',
    'no-coinciden' => 'Las contraseñas no coinciden.',
];
$errores = isset($_GET['errores']) ? explode(',', $_GET['errores']) : [];

// Valor anterior de un campo (o '' si no hay)
function valor($campo)
{
    return e($_GET[$campo] ?? '');
}
?>
<main id="contenido">
<h1>Regístrate como nuevo usuario</h1>
<form class="conBorde" action="respuesta-registro.php" method="post" enctype="multipart/form-data" novalidate>
<?php if ($errores): ?>
<div class="resumen-errores" role="alert">
<ul>
<?php foreach ($errores as $error): ?>
<?php if (isset($mensajes[$error])): ?>
<li><?= $mensajes[$error] ?></li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>
<p>
<label for="usuario">Nombre de usuario *</label><br>
<input type="text" id="usuario" name="usuario" value="<?= valor('usuario') ?>">
</p>
<p>
<label for="password">Contraseña *</label><br>
<input type="password" id="password" name="password">
</p>
<p>
<label for="repetir-password">Repetir contraseña *</label><br>
<input type="password" id="repetir-password" name="repetir-password">
</p>
<p>
<label for="email">Dirección de email *</label><br>
<input type="text" id="email" name="email" value="<?= valor('email') ?>">
</p>
<fieldset>
<legend>Sexo *</legend>
<label><input type="radio" name="sexo" value="Hombre"<?= valor('sexo') === 'Hombre' ? ' checked' : '' ?>> Hombre</label>
<label><input type="radio" name="sexo" value="Mujer"<?= valor('sexo') === 'Mujer' ? ' checked' : '' ?>> Mujer</label>
<label><input type="radio" name="sexo" value="Otro"<?= valor('sexo') === 'Otro' ? ' checked' : '' ?>> Otro</label>
</fieldset>
<p>
<label for="fecha-nacimiento">Fecha de nacimiento * (dd/mm/aaaa)</label><br>
<input type="text" id="fecha-nacimiento" name="fecha-nacimiento" value="<?= valor('fecha-nacimiento') ?>">
</p>
<p>
<label for="ciudad">Ciudad de residencia</label><br>
<input type="text" id="ciudad" name="ciudad" value="<?= valor('ciudad') ?>">
</p>
<p>
<label for="pais">País de residencia</label><br>
<select id="pais" name="pais">
<?php
$paises = ['Alemania', 'Argentina', 'Bélgica', 'Colombia', 'España', 'Francia', 'Italia', 'México', 'Portugal', 'Reino Unido'];
$paisElegido = valor('pais') !== '' ? valor('pais') : 'España';
foreach ($paises as $pais) {
    $marcado = ($pais === $paisElegido) ? ' selected' : '';
    echo "<option$marcado>$pais</option>\n";
}
?>
</select>
</p>
<p>
<label for="foto">Foto</label><br>
<input type="file" id="foto" name="foto" accept="image/*">
</p>
<p><button type="submit">Registrarse</button></p>
</form>
</main>
<?php require 'includes/pie.php'; ?>
