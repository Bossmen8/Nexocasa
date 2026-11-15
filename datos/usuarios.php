<?php
/*
 * Usuarios que pueden acceder a la parte privada.
 *   nombre de usuario => ['password' => contraseña, 'estilo' => estilo CSS del usuario]
 * Práctica 8: cada usuario tiene asignado uno de los estilos del sitio (ver ESTILOS en includes/sesion.php).
 * Se aplica al iniciar sesión o cuando el usuario es recordado. En una práctica posterior el usuario
 * podrá cambiarlo desde su perfil y estos datos estarán en una base de datos.
 * Al ser un fichero .php, si alguien lo abre desde el navegador no ve su contenido.
 */
return [
    'mlopez23'   => ['password' => 'Casa_2026',  'estilo' => 'Estilo principal'],
    'paquito123' => ['password' => 'Piso_1234',  'estilo' => 'Modo noche'],
    'jgarcia10'  => ['password' => 'Garaje_99',  'estilo' => 'Alto contraste'],
    'amartinez'  => ['password' => 'Atico_2026', 'estilo' => 'Letra grande'],
];
