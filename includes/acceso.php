<?php
// Formulario de acceso. Si control-acceso.php devuelve un error en la URL (?error=...), se muestra aquí.
$mensajeError = '';
if (isset($_GET['error']) && $_GET['error'] === 'vacio') {
    $mensajeError = 'Tienes que escribir el usuario y la contraseña.';
} elseif (isset($_GET['error']) && $_GET['error'] === 'incorrecto') {
    $mensajeError = 'El usuario o la contraseña no son correctos.';
}
?>
<section class="conBorde">
<h2>Acceder como usuario registrado</h2>
<form action="control-acceso.php" method="post" novalidate>
<?php if ($mensajeError !== ''): ?>
<div class="resumen-errores" role="alert"><?= $mensajeError ?></div>
<?php endif; ?>
<p>
<label for="usuario-login">Nombre de usuario *</label><br>
<input type="text" id="usuario-login" name="usuario">
</p>
<p>
<label for="password-login">Contraseña *</label><br>
<input type="password" id="password-login" name="password">
</p>
<p><button type="submit">Iniciar sesión</button></p>
</form>
</section>
