<?php
// Respuesta a la solicitud de folleto: muestra los datos recibidos y el coste final.
// Como todavía no hay base de datos, el número de páginas y de fotos son valores ficticios.
$titulo = 'Solicitud de folleto registrada';
$zona = 'privada';
require 'includes/cabecera.php';
require 'includes/inicio.php';
require 'includes/tarifas.php';

$paginas = 5;   // valor ficticio
$fotos = 15;    // valor ficticio

$color = ($_POST['impresion-color'] ?? '') === 'color';
$dpi = (int) ($_POST['resolucion'] ?? 150);
$copias = max(1, (int) ($_POST['num-copias'] ?? 1));

$costeFolleto = costeFolleto($paginas, $fotos, $color, $dpi);
$costeTotal = $costeFolleto * $copias;   // el número de copias multiplica el precio de un folleto
?>
<main id="contenido">
<h1>Solicitud de folleto publicitario registrada</h1>
<p>Hemos recibido tu solicitud con los siguientes datos:</p>
<p>Texto adicional: <?= e($_POST['texto-adicional'] ?? '') ?></p>
<p>Nombre: <?= e($_POST['nombre'] ?? '') ?></p>
<p>Correo electrónico: <?= e($_POST['email'] ?? '') ?></p>
<p>Dirección: <?= e(($_POST['calle'] ?? '') . ' ' . ($_POST['numero'] ?? '') . ' ' . ($_POST['piso'] ?? '') . ' ' . ($_POST['puerta'] ?? '') . ', '
    . ($_POST['cp'] ?? '') . ' ' . ($_POST['localidad'] ?? '') . ', ' . ($_POST['provincia'] ?? '') . ', ' . ($_POST['pais-envio'] ?? '')) ?></p>
<p>Teléfono: <?= e($_POST['telefono'] ?? '') ?></p>
<p>Color de la portada: <?= e($_POST['color-portada'] ?? '') ?></p>
<p>Número de copias: <?= $copias ?></p>
<p>Resolución: <?= $dpi ?> dpi</p>
<p>Anuncio: <?= e($_POST['anuncio'] ?? '') ?></p>
<p>Fecha de recepción: <?= e($_POST['fecha-recepcion'] ?? '') ?></p>
<p>Impresión a color: <?= $color ? 'Color' : 'Blanco y negro' ?></p>
<p>Impresión del precio: <?= e($_POST['impresion-precio'] ?? '') ?></p>

<h2>Coste</h2>
<p>Folleto de <?= $paginas ?> páginas y <?= $fotos ?> fotos (valores de ejemplo): <?= euros($costeFolleto) ?> cada uno.</p>
<p><strong>Coste total (<?= $copias ?> copias): <?= euros($costeTotal) ?></strong></p>
</main>
<?php require 'includes/pie.php'; ?>
