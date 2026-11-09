<?php
// Control de acceso: no muestra nada, solo comprueba los datos y redirige.
require 'includes/funciones.php';

// trim() quita espacios y tabuladores, así que un campo con solo espacios queda vacío
$usuario = trim($_POST['usuario'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($usuario === '' || $password === '') {
    redirigir('index.php?error=vacio');
}

$usuarios = require 'datos/usuarios.php';

if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $password) {
    redirigir('menu-usuario.php?usuario=' . urlencode($usuario));
} else {
    redirigir('index.php?error=incorrecto');
}
