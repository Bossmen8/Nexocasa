<?php
// PLANTILLA 2/3: <body>, logotipo y barra de navegación.
// Si la página define $zona = 'privada', se muestra el menú de la parte privada.
$privada = isset($zona) && $zona === 'privada';
?>
<body>
<a class="saltar" href="#contenido">Saltar al contenido principal</a>
<header>
<p>
<img src="img/Logo Nexocasa.png" alt="">
<a href="<?= $privada ? 'index-autenticado.php' : 'index.php' ?>">Nexocasa</a>
</p>
<nav>
<ul>
<?php if ($privada): ?>
<li><a href="index-autenticado.php"><i class="fa-solid fa-house" aria-hidden="true"></i>Inicio</a></li>
<li><a href="busqueda.php"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>Buscar</a></li>
<li><a href="menu-usuario.php"><i class="fa-solid fa-circle-user" aria-hidden="true"></i>Mi cuenta</a></li>
<li><a href="index.php"><i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>Cerrar sesión</a></li>
<?php else: ?>
<li><a href="index.php"><i class="fa-solid fa-house" aria-hidden="true"></i>Inicio</a></li>
<li><a href="busqueda.php"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>Buscar</a></li>
<li><a href="registro.php"><i class="fa-solid fa-user-plus" aria-hidden="true"></i>Registrarse</a></li>
<?php endif; ?>
</ul>
</nav>
<?php if ($privada && !empty($_GET['usuario'])): ?>
<p>Hola, <strong><?= e($_GET['usuario']) ?></strong></p>
<?php endif; ?>
</header>
