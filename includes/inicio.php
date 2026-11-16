<?php
/*
<<<<<<< HEAD
 * PLANTILLA (2/3) - Inicio del cuerpo: <body>, logotipo, nombre del sitio y barra de navegación.
 *
 * Variables opcionales que puede definir la página:
 *   $zona     'publica' (por defecto) o 'privada'. Cambia los enlaces de la barra de navegación.
 *
 * PRÁCTICA 8:
 *   - El nombre del usuario se lee de la SESIÓN (ya no de la URL) y se saluda según la hora
 *     ("Buenos días, Pepito"...) en la cabecera de todas las páginas cuando hay sesión.
 *   - En la parte pública, si hay un usuario autenticado o recordado, "Registrarse" se cambia por
 *     "Mi cuenta" y "Salir" (se muestra el sitio como si el usuario se hubiese autenticado).
 *   - Se muestran los mensajes flash de aviso (por ejemplo, "Has cerrado la sesión").
 *   - Si el usuario acaba de entrar con "Recordarme" directamente en una página privada o restringida,
 *     se muestra su nombre y la fecha y hora de su última visita.
 */
$zona = $zona ?? 'publica';
$paginaActual = basename($_SERVER['PHP_SELF']);
$navUsuario = usuarioActual();
=======
 * PLANTILLA 2 - Inicio del cuerpo: <body>, logotipo, nombre del sitio y barra de navegación.
 */
$zona = $zona ?? 'publica';
$paginaActual = basename($_SERVER['PHP_SELF']);
>>>>>>> main

// Enlaces de la barra de navegación: fichero => [icono, texto]
if ($zona === 'privada') {
    $enlacesNav = [
        'index-autenticado.php' => ['fa-house', 'Inicio'],
        'busqueda.php'          => ['fa-magnifying-glass', 'Buscar'],
        'menu-usuario.php'      => ['fa-circle-user', 'Mi cuenta'],
<<<<<<< HEAD
        'salir.php'             => ['fa-right-from-bracket', 'Salir'],
    ];
    $navInicio = 'index-autenticado.php';
} elseif ($navUsuario !== null) {
    $enlacesNav = [
        'index.php'        => ['fa-house', 'Inicio'],
        'busqueda.php'     => ['fa-magnifying-glass', 'Buscar'],
        'menu-usuario.php' => ['fa-circle-user', 'Mi cuenta'],
        'salir.php'        => ['fa-right-from-bracket', 'Salir'],
    ];
    $navInicio = 'index.php';
=======
        'index.php'             => ['fa-right-from-bracket', 'Cerrar sesión'],
    ];
    $navInicio = 'index-autenticado.php';
>>>>>>> main
} else {
    $enlacesNav = [
        'index.php'    => ['fa-house', 'Inicio'],
        'busqueda.php' => ['fa-magnifying-glass', 'Buscar'],
        'registro.php' => ['fa-user-plus', 'Registrarse'],
    ];
    $navInicio = 'index.php';
}
unset($enlacesNav[$paginaActual]);
<<<<<<< HEAD

$avisoFlash = leerFlash('aviso');
$mostrarUltimaVisita = !empty($accesoRecordadoAhora) && !empty($paginaProtegida)
                       && !empty($_SESSION['ultimaVisita']);
=======
$navUsuario = $zona === 'privada' ? leer($_GET, 'usuario') : '';
>>>>>>> main
?>
<body>
<a class="saltar" href="#contenido">Saltar al contenido principal</a>
<header>
<p>
<img src="img/Logo Nexocasa.png" alt="">
<a href="<?= $navInicio ?>">Nexocasa</a>
</p>
<nav>
<ul>
<?php foreach ($enlacesNav as $navHref => [$navIcono, $navTexto]): ?>
<li><a href="<?= $navHref ?>"><i class="fa-solid <?= $navIcono ?>" aria-hidden="true"></i><?= $navTexto ?></a></li>
<?php endforeach; ?>
</ul>
</nav>
<<<<<<< HEAD
<?php if ($navUsuario !== null): ?>
<p><a class="saludo" href="menu-usuario.php"><i class="fa-solid fa-circle-user" aria-hidden="true"></i><?= e(saludo($navUsuario)) ?></a></p>
<?php endif; ?>
</header>
<?php if ($avisoFlash): ?>
<p class="aviso" role="status"><i class="fa-solid fa-circle-info" aria-hidden="true"></i><?= e($avisoFlash) ?></p>
<?php endif; ?>
<?php if ($mostrarUltimaVisita): ?>
<p class="aviso ultima-visita" role="status"><i class="fa-regular fa-clock" aria-hidden="true"></i>Hola, <strong><?= e($navUsuario) ?></strong>: te estábamos recordando en este equipo. Tu última visita fue <?= e(textoUltimaVisita($_SESSION['ultimaVisita'])) ?>.</p>
<?php endif; ?>
=======
<?php if ($navUsuario !== ''): ?>
<p>Hola, <strong><?= e($navUsuario) ?></strong></p>
<?php endif; ?>
</header>
>>>>>>> main
