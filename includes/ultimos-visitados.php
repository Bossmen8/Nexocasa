<?php
/*
 * PRÁCTICA 8 - Panel "Últimos anuncios visitados" (con una COOKIE que dura 1 semana).
 *
 * - La cookie solo guarda los identificadores de los anuncios, separados por comas y del más antiguo
 *   al más reciente (por ejemplo "3,1,5"). Los datos que se muestran (foto, título, ciudad, país y
 *   precio) se buscan en el servidor: así no se puede inyectar contenido manipulando la cookie.
 * - registrarVisita() se llama desde detalle-anuncio.php ANTES de generar la salida.
 * - panelUltimosVisitados() se llama desde pie.php en todas las páginas de la parte pública
 *   (también las restringidas), para cualquier usuario, aunque no esté autenticado.
 * - salir.php borra la cookie (cerrarSesion() en includes/sesion.php).
 */
require_once __DIR__ . '/anuncios.php';

const MAX_ULTIMOS = 4;

/** Identificadores guardados en la cookie (solo enteros positivos, como mucho 4). */
function idsUltimosVisitados(): array
{
    $valor = $_COOKIE[COOKIE_ULTIMOS] ?? '';
    if (!is_string($valor) || $valor === '') {
        return [];
    }
    $ids = [];
    foreach (explode(',', $valor) as $trozo) {
        $id = filter_var($trozo, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id !== false && !in_array($id, $ids, true)) {
            $ids[] = $id;
        }
    }
    return array_slice($ids, -MAX_ULTIMOS);
}

/**
 * Añade un anuncio a la lista. Si ya estaba, se mueve al final (es el más reciente).
 * Si hay más de 4, se elimina el que se visitó primero. La cookie dura 1 semana desde la última visita.
 */
function registrarVisita(int $id): void
{
    $ids = array_values(array_diff(idsUltimosVisitados(), [$id]));
    $ids[] = $id;
    $ids = array_slice($ids, -MAX_ULTIMOS);
    guardarCookie(COOKIE_ULTIMOS, implode(',', $ids), time() + DURACION_ULTIMOS);
}

/** Pinta el panel con los últimos anuncios visitados en el orden en que se visitaron. */
function panelUltimosVisitados(): void
{
    $anuncios = todosLosAnuncios();
    $lista = [];
    foreach (idsUltimosVisitados() as $id) {
        if (isset($anuncios[$id])) {
            $lista[] = $anuncios[$id];
        }
    }
    ?>
<aside class="ultimos-visitados" aria-labelledby="titulo-ultimos">
<h2 id="titulo-ultimos"><i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>Últimos anuncios visitados</h2>
<?php if (!$lista): ?>
<p>Todavía no has visitado ningún anuncio.</p>
<?php else: ?>
<ol>
<?php foreach ($lista as $a): ?>
<li>
<a href="detalle-anuncio.php?id=<?= (int) $a['id'] ?>">
<img src="<?= e($a['foto']) ?>" alt="" width="80">
<span class="titulo"><?= e($a['titulo']) ?></span>
<span><?= e($a['ciudad']) ?>, <?= e(etiqueta(PAISES, $a['pais'])) ?></span>
<span class="precio"><?= formatearPrecio($a['precio']) ?><?= $a['tipoAnuncio'] === 'alquiler' ? ' al mes' : '' ?></span>
</a>
</li>
<?php endforeach; ?>
</ol>
<?php endif; ?>
</aside>
<?php
}
