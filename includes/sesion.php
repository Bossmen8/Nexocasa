<?php
/*
 * PRÁCTICA 8 - Sesiones, cookies y flashdata.
 * Se incluye desde includes/funciones.php, así que TODAS las páginas inician (o reanudan) la sesión
 * antes de generar cualquier salida.
 *
 * Contenido:
 *   1. Configuración e inicio de la sesión (cookie de sesión segura).
 *   2. Opciones comunes de las cookies (HttpOnly: no accesibles desde JavaScript).
 *   3. Flashdata: mensajes de un solo uso que sobreviven a una redirección.
 *   4. Autenticación: iniciar sesión, usuario actual, proteger páginas, cerrar sesión.
 *   5. "Recordarme en este equipo" con un token aleatorio (la cookie NO guarda usuario ni contraseña).
 *   6. Saludo según la franja horaria y estilo CSS del usuario.
 */

date_default_timezone_set('Europe/Madrid');

// Duraciones
const DURACION_RECORDAR = 90 * 24 * 60 * 60;   // 90 días
const DURACION_ULTIMOS  = 7 * 24 * 60 * 60;    // 1 semana

// Nombres de las cookies
const COOKIE_RECORDAR = 'nexocasa_recordar';
const COOKIE_ULTIMOS  = 'nexocasa_ultimos';

// Fichero (en el servidor) donde se guardan los tokens de "Recordarme"
const FICHERO_TOKENS = __DIR__ . '/../datos/privado/tokens-recordar.json';

// ---------- 1. Inicio de la sesión ----------

/** Ruta de la aplicación (por ejemplo /Nexocasa/): las cookies solo se envían a este sitio. */
function rutaCookies(): string
{
    $ruta = rtrim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])), '/');
    return $ruta . '/';
}

/** Opciones comunes de todas las cookies del sitio. */
function opcionesCookie(int $caduca): array
{
    return [
        'expires'  => $caduca,
        'path'     => rutaCookies(),
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', // solo HTTPS si la web va por HTTPS
        'httponly' => true,      // JavaScript no puede leer la cookie (document.cookie)
        'samesite' => 'Lax',     // no se envía en peticiones POST desde otros sitios
    ];
}

/** Crea o actualiza una cookie y la deja también en $_COOKIE para la petición actual. */
function guardarCookie(string $nombre, string $valor, int $caduca): void
{
    setcookie($nombre, $valor, opcionesCookie($caduca));
    $_COOKIE[$nombre] = $valor;
}

/** Borra una cookie: se le pone una fecha de caducidad en el pasado. */
function borrarCookie(string $nombre): void
{
    setcookie($nombre, '', opcionesCookie(time() - 42000));
    unset($_COOKIE[$nombre]);
}

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');   // no acepta identificadores de sesión inventados (fijación de sesión)
    ini_set('session.use_only_cookies', '1');  // el identificador nunca viaja en la URL
    $parametrosSesion = opcionesCookie(0);
    unset($parametrosSesion['expires']);
    $parametrosSesion['lifetime'] = 0;           // 0 = la cookie de sesión dura hasta que se cierre el navegador
    session_set_cookie_params($parametrosSesion);
    session_start();
}

// ---------- 3. Flashdata ----------
// Se guardan en $_SESSION['flash'][clave]. Al leerlos se borran: solo están disponibles una vez.

function guardarFlash(string $clave, $valor): void
{
    $_SESSION['flash'][$clave] = $valor;
}

function leerFlash(string $clave, $siNoExiste = null)
{
    if (!isset($_SESSION['flash'][$clave])) {
        return $siNoExiste;
    }
    $valor = $_SESSION['flash'][$clave];
    unset($_SESSION['flash'][$clave]);
    if (empty($_SESSION['flash'])) {
        unset($_SESSION['flash']);
    }
    return $valor;
}

// ---------- 4. Autenticación ----------

/** Datos de los usuarios (datos/usuarios.php). */
function usuariosRegistrados(): array
{
    static $usuarios = null;
    return $usuarios ??= require __DIR__ . '/../datos/usuarios.php';
}

/** Nombre del usuario que ha iniciado sesión, o null si no hay nadie. */
function usuarioActual(): ?string
{
    return $_SESSION['usuario'] ?? null;
}

function estaAutenticado(): bool
{
    return usuarioActual() !== null;
}

/**
 * Guarda en la sesión los datos del usuario que acaba de entrar.
 *   $recordado  true si ha entrado gracias a la cookie de "Recordarme".
 *   $ultimaVisita  fecha (timestamp) de la última visita que se mostrará en el mensaje de bienvenida.
 */
function iniciarSesionUsuario(string $usuario, bool $recordado = false, ?int $ultimaVisita = null): void
{
    // Nuevo identificador de sesión al cambiar de privilegios: evita la fijación de sesión
    session_regenerate_id(true);
    $_SESSION['usuario']      = $usuario;
    $_SESSION['estilo']       = usuariosRegistrados()[$usuario]['estilo'] ?? ESTILO_PRINCIPAL;
    $_SESSION['recordado']    = $recordado;
    $_SESSION['ultimaVisita'] = $ultimaVisita;
}

/**
 * Protección de rutas privadas. Se llama al principio de cada página privada o restringida,
 * ANTES de generar ninguna salida. Si el usuario no está autenticado (ni recordado),
 * redirige a la página principal, que tiene el formulario de acceso.
 */
function requerirAcceso(): void
{
    $GLOBALS['paginaProtegida'] = true;   // inicio.php la usa para mostrar el mensaje de "usuario recordado"
    if (estaAutenticado()) {
        return;
    }
    // Se recuerda la página pedida para volver a ella después de iniciar sesión
    $destino = basename($_SERVER['PHP_SELF']);
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_SERVER['QUERY_STRING'])) {
        $destino .= '?' . $_SERVER['QUERY_STRING'];
    }
    $_SESSION['destino'] = $destino;
    guardarFlash('aviso', 'Tienes que iniciar sesión para ver esa página.');
    redirigir('index.php');
}

/** Página a la que hay que ir después de iniciar sesión (solo páginas .php de este sitio). */
function destinoTrasLogin(): string
{
    $destino = $_SESSION['destino'] ?? '';
    unset($_SESSION['destino']);
    return preg_match('/^[a-z0-9-]+\.php(\?[^\r\n]*)?$/i', $destino) ? $destino : 'menu-usuario.php';
}

/**
 * Cierra la sesión (opción "Salir"): borra los datos de "Recordarme", la cookie de los últimos
 * anuncios visitados y la sesión completa.
 */
function cerrarSesion(): void
{
    olvidarUsuario();
    borrarCookie(COOKIE_ULTIMOS);

    $_SESSION = [];                                  // 1. borra todas las variables de sesión
    if (isset($_COOKIE[session_name()])) {           // 2. borra la cookie con el identificador
        setcookie(session_name(), '', opcionesCookie(time() - 42000));
    }
    session_destroy();                               // 3. destruye la sesión en el servidor
}

// ---------- 5. "Recordarme en este equipo" ----------
// La cookie solo guarda un token aleatorio de 64 caracteres. En el servidor (datos/privado/) se guarda
// el HASH del token junto con el usuario, la fecha de caducidad y la fecha de la última visita.
// Si alguien roba el fichero del servidor, no puede reconstruir el token de la cookie.

function leerTokens(): array
{
    if (!is_file(FICHERO_TOKENS)) {
        return [];
    }
    $tokens = json_decode((string) file_get_contents(FICHERO_TOKENS), true);
    return is_array($tokens) ? $tokens : [];
}

function guardarTokens(array $tokens): void
{
    // Se eliminan los tokens caducados para que el fichero no crezca sin límite
    $ahora = time();
    $tokens = array_filter($tokens, fn($t) => ($t['caduca'] ?? 0) > $ahora);
    if (!is_dir(dirname(FICHERO_TOKENS))) {
        mkdir(dirname(FICHERO_TOKENS), 0700, true);
    }
    file_put_contents(FICHERO_TOKENS, json_encode($tokens, JSON_PRETTY_PRINT), LOCK_EX);
}

/** Crea el token, lo guarda en el servidor y envía la cookie (caduca a los 90 días). */
function recordarUsuario(string $usuario): void
{
    olvidarUsuario(); // en un equipo solo se recuerda a un usuario: el último que marcó la opción

    $token  = bin2hex(random_bytes(32));
    $caduca = time() + DURACION_RECORDAR;

    $tokens = leerTokens();
    $tokens[hash('sha256', $token)] = [
        'usuario'      => $usuario,
        'caduca'       => $caduca,
        'ultimaVisita' => time(), // si no se ha usado nunca la cookie, la última visita es este inicio de sesión
    ];
    guardarTokens($tokens);
    guardarCookie(COOKIE_RECORDAR, $token, $caduca);
}

/** Borra el token del servidor y la cookie del navegador. */
function olvidarUsuario(): void
{
    $token = $_COOKIE[COOKIE_RECORDAR] ?? null;
    if (is_string($token) && $token !== '') {
        $tokens = leerTokens();
        unset($tokens[hash('sha256', $token)]);
        guardarTokens($tokens);
    }
    if (isset($_COOKIE[COOKIE_RECORDAR])) {
        borrarCookie(COOKIE_RECORDAR);
    }
}

/**
 * Si no hay sesión pero el navegador tiene una cookie de "Recordarme" válida, se inicia la sesión
 * automáticamente (como si el usuario nunca hubiese cerrado el navegador).
 * Devuelve true si el acceso automático se ha producido en esta petición.
 *
 * La cookie NO se renueva (no hay expiración deslizante): a los 90 días desaparece y el usuario
 * tiene que volver a identificarse. Lo único que se actualiza es la fecha de la última visita.
 */
function accesoRecordado(): bool
{
    if (estaAutenticado()) {
        return false;
    }
    $token = $_COOKIE[COOKIE_RECORDAR] ?? null;
    if (!is_string($token) || !preg_match('/^[0-9a-f]{64}$/', $token)) {
        if ($token !== null) {
            borrarCookie(COOKIE_RECORDAR); // cookie manipulada
        }
        return false;
    }

    $tokens = leerTokens();
    $clave  = hash('sha256', $token);
    $datos  = $tokens[$clave] ?? null;

    if ($datos === null || $datos['caduca'] <= time() || !isset(usuariosRegistrados()[$datos['usuario']])) {
        olvidarUsuario(); // token desconocido, caducado o de un usuario que ya no existe
        return false;
    }

    // Última visita: la última vez que se usaron los datos de "Recordarme" (o el inicio de sesión original)
    iniciarSesionUsuario($datos['usuario'], true, $datos['ultimaVisita']);

    $tokens[$clave]['ultimaVisita'] = time();
    guardarTokens($tokens);
    return true;
}

// ---------- 6. Saludo y estilo ----------

/** Saludo según la franja horaria (hora del servidor, zona Europe/Madrid). */
function saludo(string $usuario, ?int $hora = null): string
{
    $hora ??= (int) date('G');
    if ($hora >= 6 && $hora < 12) {
        $texto = 'Buenos días';
    } elseif ($hora >= 12 && $hora < 16) {
        $texto = 'Hola';
    } elseif ($hora >= 16 && $hora < 20) {
        $texto = 'Buenas tardes';
    } else {
        $texto = 'Buenas noches';
    }
    return "$texto, $usuario";
}

/** Texto "el 01/01/26 a las 10:00" para la última visita. */
function textoUltimaVisita(int $momento): string
{
    return 'el ' . date('d/m/y', $momento) . ' a las ' . date('H:i', $momento);
}

// Estilos del sitio (título del estilo => hojas de estilo que lo forman)
const ESTILO_PRINCIPAL = 'Estilo principal';
const ESTILOS = [
    'Estilo principal'              => ['css/estilos.css'],
    'Modo noche'                    => ['css/estilos.css', 'css/noche.css'],
    'Alto contraste'                => ['css/estilos.css', 'css/contraste.css'],
    'Letra grande'                  => ['css/estilos.css', 'css/letra-grande.css'],
    'Alto contraste y letra grande' => ['css/estilos.css', 'css/contraste.css', 'css/letra-grande.css'],
];

/** Estilo que hay que aplicar: el del usuario (guardado en la sesión) o el principal. */
function estiloActual(): string
{
    $estilo = $_SESSION['estilo'] ?? ESTILO_PRINCIPAL;
    return isset(ESTILOS[$estilo]) ? $estilo : ESTILO_PRINCIPAL;
}

// Acceso automático con "Recordarme" en cualquier página (antes de generar la salida)
$accesoRecordadoAhora = accesoRecordado();
