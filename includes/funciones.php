<?php
// Funciones que se usan en todas las páginas. Se incluye desde cabecera.php.

// Mostrar errores de PHP mientras desarrollamos
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Escapa un texto antes de mostrarlo en HTML para evitar ataques XSS.
function e($valor)
{
    if ($valor === null) {
        return '';
    }
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Redirige a otra página del mismo directorio (la URL tiene que ser absoluta).
// $pagina puede llevar parámetros, por ejemplo 'index.php?error=vacio'.
function redirigir($pagina)
{
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/$pagina");
    exit;
}
