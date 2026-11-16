<?php
/*
 * Control de acceso a la parte privada. NO es una página visible: no genera HTML, solo redirige.
 *
 * 1. Comprueba que se han escrito el usuario y la contraseña (trim() quita espacios y tabuladores,
 *    así que un campo con solo espacios o tabuladores cuenta como vacío).
<<<<<<< HEAD
 * 2. Comprueba que el usuario y la contraseña están en datos/usuarios.php.
 * 3. Si hay un error → redirige a index.php. PRÁCTICA 8: el error ya NO viaja en la URL,
 *    se guarda como FLASHDATA en la sesión (se lee una sola vez y desaparece).
 * 4. Si todo es correcto → guarda el usuario en la SESIÓN, y si se ha marcado "Recordarme en este
 *    equipo" crea la cookie de 90 días. Después redirige al menú de usuario (o a la página privada
 *    que se intentaba abrir antes de iniciar sesión).
=======
 * 2. Comprueba que el usuario y la contraseña están en datos/usuarios.php (4 usuarios permitidos).
 * 3. Si todo es correcto → redirige a menu-usuario.php.
 *    Si no → redirige a index.php con un código de error en la URL (?error=vacio o ?error=incorrecto).
>>>>>>> main
 */
require_once 'includes/funciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir('index.php');
}

<<<<<<< HEAD
$usuario  = leer($_POST, 'usuario');
$password = leer($_POST, 'password');
$recordar = isset($_POST['recordar']);

if ($usuario === '' || $password === '') {
    guardarFlash('error_acceso', 'vacio');
    guardarFlash('usuario_acceso', $usuario);   // para volver a rellenar el campo
    redirigir('index.php');
}

$usuarios = usuariosRegistrados();

if (!isset($usuarios[$usuario]) || !hash_equals($usuarios[$usuario]['password'], $password)) {
    guardarFlash('error_acceso', 'incorrecto');
    guardarFlash('usuario_acceso', $usuario);
    redirigir('index.php');
}

// Acceso correcto: se guarda en la sesión (con un identificador de sesión nuevo)
$destino = destinoTrasLogin();
iniciarSesionUsuario($usuario);

if ($recordar) {
    recordarUsuario($usuario);
} else {
    olvidarUsuario(); // si se estaba recordando a otro usuario en este equipo, se deja de recordar
}

redirigir($destino);
=======
$usuario = leer($_POST, 'usuario');
$password = leer($_POST, 'password');

if ($usuario === '' || $password === '') {
    redirigir('index.php', ['error' => 'vacio']);
}

$usuarios = require 'datos/usuarios.php';

if (!isset($usuarios[$usuario]) || $usuarios[$usuario] !== $password) {
    redirigir('index.php', ['error' => 'incorrecto']);
}

// Acceso correcto. Todavía no hay sesiones (práctica 8): el nombre se pasa por la URL para saludar al usuario.
redirigir('menu-usuario.php', ['usuario' => $usuario]);
>>>>>>> main
