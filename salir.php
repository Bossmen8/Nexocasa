<?php
/*
 * Opción "Salir" (cerrar sesión). NO es una página visible: no genera HTML, solo redirige.
 * - Borra la sesión (variables, cookie PHPSESSID y datos del servidor).
 * - Borra los datos de "Recordarme en este equipo" (cookie y token del servidor), si existían.
 * - Borra la cookie del panel "Últimos anuncios visitados".
 * Después inicia una sesión nueva y vacía solo para dejar el mensaje flash de despedida.
 */
require_once 'includes/funciones.php';

$usuario = usuarioActual();
cerrarSesion();

session_start();
if ($usuario !== null) {
    guardarFlash('aviso', 'Has cerrado la sesión. ¡Hasta pronto, ' . $usuario . '!');
}
redirigir('index.php');
