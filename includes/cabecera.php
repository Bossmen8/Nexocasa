<?php
/*
 * PLANTILLA (1/3) - Cabecera del documento: DOCTYPE, <html>, <head> y hojas de estilo.
 *
 * Variables que debe definir la página antes de incluir este fichero:
 *   $titulo  Título de la página (se muestra en <title>).
 *
 * Práctica 8: funciones.php inicia la sesión, así que este fichero se puede incluir sin problemas
 * (la sesión y las cookies se envían antes que el DOCTYPE).
 */
require_once __DIR__ . '/funciones.php';
require_once __DIR__ . '/listas.php';

$titulo = $titulo ?? 'Nexocasa';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nexocasa | <?= e($titulo) ?></title>
<link rel="icon" href="img/Favicon Nexocasa.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<?php
// PRÁCTICA 8: el estilo del usuario (guardado en la sesión) es el preferido (rel="stylesheet");
// el resto quedan como estilos alternativos. Sin sesión se usa el estilo principal.
$estiloElegido = estiloActual();
foreach (ESTILOS as $tituloEstilo => $hojas):
    $rel = $tituloEstilo === $estiloElegido ? 'stylesheet' : 'alternate stylesheet';
    foreach ($hojas as $hoja): ?>
<link rel="<?= $rel ?>" href="<?= $hoja ?>" title="<?= e($tituloEstilo) ?>" media="screen">
<?php endforeach;
endforeach; ?>
<link rel="stylesheet" href="css/impresion.css" media="print">
</head>
