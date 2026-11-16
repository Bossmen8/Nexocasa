<?php
/*
 * Respuesta al formulario de registro. Recibe los datos por POST desde registro.php.
<<<<<<< HEAD
 * - Si hay errores: redirige a registro.php. PRÁCTICA 8: los códigos de error y los datos escritos
 *   (sin contraseñas) ya NO viajan en la URL: se guardan como FLASHDATA en la sesión
 *   ($_SESSION['flash']['registro']) y registro.php los lee una sola vez.
=======
 * - Si hay errores: redirige a registro.php pasando por la URL los códigos de error y los datos
 *   escritos (sin contraseñas). No se usan sesiones ni cookies.
>>>>>>> main
 * - Si todo es correcto: muestra los datos recibidos (la foto todavía no se sube ni se muestra).
 */
require_once 'includes/funciones.php';
require_once 'includes/listas.php';
require_once 'includes/registro-validacion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir('registro.php');
}

$errores = validarRegistro($_POST);

if ($errores) {
<<<<<<< HEAD
    $datosEscritos = [];
    foreach (CAMPOS_REGISTRO as $campo) {
        $datosEscritos[$campo] = leer($_POST, $campo);
    }
    guardarFlash('registro', ['errores' => $errores, 'datos' => $datosEscritos]);
    redirigir('registro.php');
}

$datos = [
    'Nombre de usuario'   => leer($_POST, 'usuario'),
    'Dirección de email'  => leer($_POST, 'email'),
    'Sexo'                => etiqueta(SEXOS, leer($_POST, 'sexo')),
    'Fecha de nacimiento' => leer($_POST, 'fecha-nacimiento'),
    'Ciudad de residencia'=> leer($_POST, 'ciudad'),
    'País de residencia'  => etiqueta(PAISES, leer($_POST, 'pais')),
=======
    $parametros = ['errores' => $errores];
    foreach (CAMPOS_REGISTRO as $campo) {
        $parametros[$campo] = leer($_POST, $campo);
    }
    redirigir('registro.php', $parametros);
}

$datos = [
    'Nombre de usuario' => leer($_POST, 'usuario'),
    'Dirección de email' => leer($_POST, 'email'),
    'Sexo' => etiqueta(SEXOS, leer($_POST, 'sexo')),
    'Fecha de nacimiento' => leer($_POST, 'fecha-nacimiento'),
    'Ciudad de residencia' => leer($_POST, 'ciudad'),
    'País de residencia' => etiqueta(PAISES, leer($_POST, 'pais')),
>>>>>>> main
];

$titulo = 'Registro completado';
require_once 'includes/cabecera.php';
require_once 'includes/inicio.php';
?>
<main id="contenido">
<<<<<<< HEAD
<h1>Registro completado</h1>
<p>Te has registrado con los siguientes datos:</p>
<dl class="conBorde">
<?php foreach ($datos as $nombre => $valor): ?>
<dt><?= e($nombre) ?></dt>
<dd><?= $valor === '' ? '(no indicado)' : e($valor) ?></dd>
<?php endforeach; ?>
</dl>
<p><a href="index.php"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>Ir a la página principal para iniciar sesión</a></p>
</main>
<?php require_once 'includes/pie.php'; ?>
=======
    <h1>Registro completado</h1>
    <p>Te has registrado con los siguientes datos:</p>
    <dl class="conBorde">
        <?php foreach ($datos as $nombre => $valor): ?>
            <dt><?= e($nombre) ?></dt>
            <dd><?= $valor === '' ? '(no indicado)' : e($valor) ?></dd>
        <?php endforeach; ?>
    </dl>
    <p><a href="index.php"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>Ir a la página principal para
            iniciar sesión</a></p>
</main>
<?php require_once 'includes/pie.php'; ?>
>>>>>>> main
