<?php
/*
<<<<<<< HEAD
 * Datos de los anuncios de ejemplo que se muestran en "Detalle anuncio" y "Ver anuncio",
 * indexados por su identificador. Este fichero SOLO guarda estos datos (en una práctica posterior
 * se leerán de una base de datos).
 *
 * Práctica 8: además de los dos anuncios de la práctica 7 (1 = impar y 2 = par) hay tres más (3, 4 y 5),
 * para que el panel "Últimos anuncios visitados" no repita siempre la misma información.
 * Si se pide un identificador que no está aquí, se sigue mostrando el anuncio 2 (par) o el 1 (impar).
 *
 * El campo 'usuario' indica de quién es el anuncio: se usa en "Mis anuncios".
 */
return [
    1 => [
=======
 * Datos de los DOS anuncios de ejemplo que se muestran en "Detalle anuncio" y "Ver anuncio".
 * Este fichero SOLO guarda estos datos. En una práctica posterior se leerán de una base de datos.
 *
 *   'par'   → se muestra cuando el identificador recibido es un número par.
 *   'impar' → se muestra cuando el identificador recibido es un número impar.
 *
 * También se usan como anuncios del usuario en "Mis anuncios" (con el identificador 'id').
 */
return [
    'impar' => [
>>>>>>> main
        'id'           => 1,
        'tipoAnuncio'  => 'venta',
        'tipoVivienda' => 'vivienda',
        'foto'         => 'img/casa-madrid.svg',
        'altFoto'      => 'Fachada del chalet adosado de diseño en Madrid',
        'titulo'       => 'Chalet adosado de diseño',
        'precio'       => 340000,
        'texto'        => 'Chalet adosado de reciente construcción situado en una zona tranquila de Madrid, '
                        . 'con jardín privado y a pocos minutos del centro.',
        'fecha'        => '2026-09-20',
        'ciudad'       => 'Madrid',
        'pais'         => 'espana',
        'caracteristicas' => [
            'superficie'   => 180,
            'habitaciones' => 4,
            'banos'        => 3,
            'planta'       => 2,
            'anio'         => 2021,
        ],
        'fotos' => [
            ['src' => 'img/casa-madrid.svg',   'alt' => 'Fachada del chalet'],
            ['src' => 'img/casa-madrid-2.svg', 'alt' => 'Balcón del chalet'],
            ['src' => 'img/casa-madrid-3.svg', 'alt' => 'Cocina del chalet'],
            ['src' => 'img/casa-madrid-4.svg', 'alt' => 'Salón del chalet'],
        ],
        'usuario' => 'paquito123',
    ],
<<<<<<< HEAD
    2 => [
=======
    'par' => [
>>>>>>> main
        'id'           => 2,
        'tipoAnuncio'  => 'alquiler',
        'tipoVivienda' => 'vivienda',
        'foto'         => 'img/casa-barcelona.svg',
        'altFoto'      => 'Ático luminoso con terraza en Barcelona',
        'titulo'       => 'Ático luminoso con terraza',
        'precio'       => 1350,
        'texto'        => 'Ático exterior muy luminoso en el Eixample, con una terraza de 30 m² con vistas, '
                        . 'cocina equipada y cerca del metro.',
        'fecha'        => '2026-09-19',
        'ciudad'       => 'Barcelona',
        'pais'         => 'espana',
        'caracteristicas' => [
            'superficie'   => 95,
            'habitaciones' => 2,
            'banos'        => 2,
            'planta'       => 7,
            'anio'         => 2008,
        ],
        'fotos' => [
            ['src' => 'img/casa-barcelona.svg', 'alt' => 'Terraza del ático'],
            ['src' => 'img/casa-madrid-3.svg',  'alt' => 'Cocina del ático'],
            ['src' => 'img/casa-madrid-4.svg',  'alt' => 'Salón del ático'],
        ],
        'usuario' => 'mlopez23',
    ],
<<<<<<< HEAD
    3 => [
        'id'           => 3,
        'tipoAnuncio'  => 'venta',
        'tipoVivienda' => 'vivienda',
        'foto'         => 'img/casa-valencia.svg',
        'altFoto'      => 'Piso moderno reformado en Valencia',
        'titulo'       => 'Piso moderno reformado',
        'precio'       => 185000,
        'texto'        => 'Piso completamente reformado junto a la Ciudad de las Artes y las Ciencias, '
                        . 'con suelos de madera, cocina abierta y ascensor.',
        'fecha'        => '2026-09-18',
        'ciudad'       => 'Valencia',
        'pais'         => 'espana',
        'caracteristicas' => [
            'superficie'   => 85,
            'habitaciones' => 3,
            'banos'        => 1,
            'planta'       => 4,
            'anio'         => 1985,
        ],
        'fotos' => [
            ['src' => 'img/casa-valencia.svg', 'alt' => 'Fachada del edificio'],
            ['src' => 'img/casa-madrid-3.svg', 'alt' => 'Cocina abierta del piso'],
        ],
        'usuario' => 'jgarcia10',
    ],
    4 => [
        'id'           => 4,
        'tipoAnuncio'  => 'venta',
        'tipoVivienda' => 'vivienda',
        'foto'         => 'img/casa-sevilla.svg',
        'altFoto'      => 'Finca rústica con piscina en Sevilla',
        'titulo'       => 'Finca rústica con piscina',
        'precio'       => 420000,
        'texto'        => 'Finca rústica a 20 minutos de Sevilla con casa de dos plantas, piscina, '
                        . 'olivos y un amplio porche.',
        'fecha'        => '2026-09-18',
        'ciudad'       => 'Sevilla',
        'pais'         => 'espana',
        'caracteristicas' => [
            'superficie'   => 250,
            'habitaciones' => 5,
            'banos'        => 3,
            'planta'       => 0,
            'anio'         => 1998,
        ],
        'fotos' => [
            ['src' => 'img/casa-sevilla.svg',  'alt' => 'Vista de la finca y la piscina'],
            ['src' => 'img/casa-madrid-4.svg', 'alt' => 'Salón de la casa'],
        ],
        'usuario' => 'amartinez',
    ],
    5 => [
        'id'           => 5,
        'tipoAnuncio'  => 'venta',
        'tipoVivienda' => 'vivienda',
        'foto'         => 'img/casa-alicante.svg',
        'altFoto'      => 'Estudio céntrico reformado en Alicante',
        'titulo'       => 'Estudio céntrico reformado',
        'precio'       => 95000,
        'texto'        => 'Estudio reformado en pleno centro de Alicante, a cinco minutos de la playa '
                        . 'del Postiguet. Ideal como primera vivienda o para invertir.',
        'fecha'        => '2026-09-17',
        'ciudad'       => 'Alicante',
        'pais'         => 'espana',
        'caracteristicas' => [
            'superficie'   => 40,
            'habitaciones' => 1,
            'banos'        => 1,
            'planta'       => 3,
            'anio'         => 1970,
        ],
        'fotos' => [
            ['src' => 'img/casa-alicante.svg', 'alt' => 'Interior del estudio'],
        ],
        'usuario' => 'mlopez23',
    ],
=======
>>>>>>> main
];
