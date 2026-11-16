<?php
<<<<<<< HEAD
/*
 * Bloque reutilizable: acceso a la parte privada (se muestra en index.php).
 *
 * Tres casos:
 *   1. Nadie ha iniciado sesión → formulario de acceso con la casilla "Recordarme en este equipo".
 *      Si el acceso ha fallado, control-acceso.php deja el error como FLASHDATA en la sesión
 *      (práctica 8: ya no viaja por la URL). leerFlash() lo lee y lo borra: si se recarga la
 *      página, el mensaje ya no aparece.
 *   2. Se está recordando al usuario (ha entrado con la cookie) → en lugar del formulario se muestra
 *      su nombre y la fecha y hora de su última visita, con los botones Acceder y Salir (Figura 2).
 *   3. El usuario ha iniciado sesión con el formulario → no hay mensaje de última visita, solo
 *      los botones para ir a su cuenta o salir.
 */
$mensajesAcceso = [
    'vacio'      => 'Debes escribir tu nombre de usuario y tu contraseña (no valen solo espacios o tabuladores).',
    'incorrecto' => 'El nombre de usuario o la contraseña no son correctos.',
];
$usuarioAcceso = usuarioActual();
?>
<section class="conBorde">
<?php if ($usuarioAcceso !== null): ?>
<h2><?= e(saludo($usuarioAcceso)) ?></h2>
<?php if (!empty($_SESSION['recordado']) && !empty($_SESSION['ultimaVisita'])): ?>
<p class="ultima-visita"><i class="fa-regular fa-clock" aria-hidden="true"></i>Te estábamos recordando en este equipo. Tu última visita fue <?= e(textoUltimaVisita($_SESSION['ultimaVisita'])) ?>.</p>
<?php else: ?>
<p>Has iniciado sesión como <strong><?= e($usuarioAcceso) ?></strong>.</p>
<?php endif; ?>
<p class="botones">
<a class="boton" href="menu-usuario.php"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>Acceder</a>
<a class="boton secundario" href="salir.php"><i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>Salir</a>
</p>
<?php else: ?>
<?php
    $errorAcceso = $mensajesAcceso[leerFlash('error_acceso', '')] ?? null;
    $usuarioEscrito = (string) leerFlash('usuario_acceso', '');
?>
<h2>Acceder como usuario registrado</h2>
<p>Los campos marcados con un asterisco (*) son obligatorios.</p>
<form id="formulario-login" action="control-acceso.php" method="post"<?= novalidate() ?>>
<?php if ($errorAcceso): ?>
<?php mostrarErrores([$errorAcceso], 'No se ha podido iniciar sesión'); ?>
<?php else: ?>
<div class="resumen-errores oculto" role="alert" tabindex="-1"></div>
<?php endif; ?>
<p>
<label for="usuario-login"><i class="fa-solid fa-user" aria-hidden="true"></i>Nombre de usuario *</label><br>
<input type="text" id="usuario-login" name="usuario" autocomplete="username" value="<?= e($usuarioEscrito) ?>">
</p>
<p>
<label for="password-login"><i class="fa-solid fa-lock" aria-hidden="true"></i>Contraseña *</label><br>
<input type="password" id="password-login" name="password" autocomplete="current-password">
</p>
<p class="casilla">
<input type="checkbox" id="recordar" name="recordar" value="1" aria-describedby="ayuda-recordar">
<label for="recordar">Recordarme en este equipo</label><br>
<small class="ayuda" id="ayuda-recordar">Durante 90 días no tendrás que volver a escribir tus datos. No lo marques en un ordenador compartido.</small>
</p>
<p><button type="submit"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>Iniciar sesión</button></p>
</form>
<?php endif; ?>
</section>
=======

$mensajesAcceso = [
    'vacio' => 'Debes escribir tu nombre de usuario y tu contraseña (no valen solo espacios o tabuladores).',
    'incorrecto' => 'El nombre de usuario o la contraseña no son correctos.',
];
$errorAcceso = $mensajesAcceso[leer($_GET, 'error')] ?? null;
?>
<section class="conBorde">
    <h2>Acceder como usuario registrado</h2>
    <p>Los campos marcados con un asterisco (*) son obligatorios.</p>
    <form id="formulario-login" action="control-acceso.php" method="post" <?= novalidate() ?>>
        <?php if ($errorAcceso): ?>
            <?php mostrarErrores([$errorAcceso], 'No se ha podido iniciar sesión'); ?>
        <?php else: ?>
            <div class="resumen-errores oculto" role="alert" tabindex="-1"></div>
        <?php endif; ?>
        <p>
            <label for="usuario-login"><i class="fa-solid fa-user" aria-hidden="true"></i>Nombre de usuario
                *</label><br>
            <input type="text" id="usuario-login" name="usuario" autocomplete="username">
        </p>
        <p>
            <label for="password-login"><i class="fa-solid fa-lock" aria-hidden="true"></i>Contraseña *</label><br>
            <input type="password" id="password-login" name="password" autocomplete="current-password">
        </p>
        <p><button type="submit"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>Iniciar sesión</button>
        </p>
    </form>
</section>
>>>>>>> main
