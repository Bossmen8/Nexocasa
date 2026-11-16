<?php
/*
<<<<<<< HEAD
 * PLANTILLA (3/3) - Pie de página y cierre del documento: <footer>, scripts, </body></html>.
 *
 * Variables opcionales que puede definir la página:
 *   $scripts             Ficheros JavaScript que se cargan siempre (por ejemplo, la tabla del folleto).
 *   $scriptsValidacion   Ficheros JavaScript de validación: solo se cargan si VALIDACION_CLIENTE es true.
 *
 * Práctica 8: en todas las páginas de la parte pública (y pública restringida) se muestra el panel
 * "Últimos anuncios visitados", para cualquier usuario.
 */
require_once __DIR__ . '/ultimos-visitados.php';
=======
 * PLANTILLA 3 - Pie de página y cierre del documento: <footer>, scripts, </body></html>.
 */
>>>>>>> main
$scripts = $scripts ?? [];
if (VALIDACION_CLIENTE && !empty($scriptsValidacion)) {
    $scripts = array_merge($scripts, $scriptsValidacion);
}
?>
<<<<<<< HEAD
<?php if (($zona ?? 'publica') !== 'privada') {
    panelUltimosVisitados();
} ?>
=======
>>>>>>> main
<footer>
<p>&copy; 2026 Nexocasa · <a href="accesibilidad.php">Accesibilidad</a></p>
</footer>
<?php foreach ($scripts as $script): ?>
<script src="<?= e($script) ?>"></script>
<?php endforeach; ?>
</body>
</html>
