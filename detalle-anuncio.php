<?php
/*
 * Detalle de un anuncio (parte pública RESTRINGIDA). Recibe el identificador por la URL: ?id=N
 * Práctica 8:
 *   - Solo lo pueden ver los usuarios autenticados (o recordados): requerirAcceso().
 *   - Cada visita se guarda en la cookie de "Últimos anuncios visitados": registrarVisita().
 *     Las dos cosas se hacen ANTES de generar la salida, porque envían cabeceras HTTP.
 */
require_once 'includes/funciones.php';
requerirAcceso();
require_once 'includes/anuncios.php';
require_once 'includes/ultimos-visitados.php';

$anuncio = obtenerAnuncio(leerId('id'));
if ($anuncio === null) {
    // Falta el identificador o no es un número positivo
    http_response_code(404);
} else {
    registrarVisita($anuncio['id']);
}

$titulo = $anuncio['titulo'] ?? 'Anuncio no encontrado';
require_once 'includes/cabecera.php';
require_once 'includes/inicio.php';
?>
<main id="contenido" class="columnas">
<?php if ($anuncio): ?>
<?php fichaAnuncio($anuncio, false); ?>
<?php else: ?>
<h1>Anuncio no encontrado</h1>
<p>El anuncio que buscas no existe o el enlace no es correcto.</p>
<p><a href="index.php">Volver a la página principal</a></p>
<?php endif; ?>
</main>
<?php require_once 'includes/pie.php'; ?>
