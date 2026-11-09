<?php
// Respuesta del registro.
// Comprueba usuario, contraseña y repetir contraseña. Si hay errores, vuelve a registro.php
// con los errores y los datos en la URL (sin las contraseñas). Si no, muestra los datos.
require 'includes/funciones.php';

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';
$repetir = $_POST['repetir-password'] ?? '';

$errores = [];
if ($usuario === '') {
    $errores[] = 'usuario';
}
if (trim($password) === '') {
    $errores[] = 'password';
}
if (trim($repetir) === '') {
    $errores[] = 'repetir';
} elseif ($password !== $repetir) {
    $errores[] = 'no-coinciden';
}

if ($errores) {
    $datos = [
        'errores' => implode(',', $errores),
        'usuario' => $usuario,
        'email' => $_POST['email'] ?? '',
        'sexo' => $_POST['sexo'] ?? '',
        'fecha-nacimiento' => $_POST['fecha-nacimiento'] ?? '',
        'ciudad' => $_POST['ciudad'] ?? '',
        'pais' => $_POST['pais'] ?? '',
    ];
    redirigir('registro.php?' . http_build_query($datos));
}

$titulo = 'Registro completado';
require 'includes/cabecera.php';
require 'includes/inicio.php';
?>
<main id="contenido">
<h1>Registro completado</h1>
<p>Nombre de usuario: <?= e($usuario) ?></p>
<p>Email: <?= e($_POST['email'] ?? '') ?></p>
<p>Sexo: <?= e($_POST['sexo'] ?? '') ?></p>
<p>Fecha de nacimiento: <?= e($_POST['fecha-nacimiento'] ?? '') ?></p>
<p>Ciudad: <?= e($_POST['ciudad'] ?? '') ?></p>
<p>País: <?= e($_POST['pais'] ?? '') ?></p>
</main>
<?php require 'includes/pie.php'; ?>
