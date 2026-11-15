# Práctica 8 — PHP 2: cookies y sesiones

Este documento explica **dónde está** y **cómo funciona** cada cosa que pide el enunciado de la práctica 8.
Los números de línea son orientativos (`fichero.php:NN`).

---

## 1. Cómo ponerlo en marcha

1. Copia la carpeta `Nexocasa` dentro de `C:\xampp\htdocs\` (si ya tenías una versión anterior, **bórrala antes**).
2. Arranca **Apache** desde `xampp-control.exe`.
3. Abre **`http://localhost/Nexocasa/`**.

> Apache necesita poder **escribir** en `datos/privado/`, donde se guardan los tokens de «Recordarme»
> (en XAMPP para Windows ya puede). La carpeta se crea sola si no existe.

**Usuarios para probar** (`datos/usuarios.php`). Ahora cada usuario tiene además su **estilo**:

| Usuario      | Contraseña   | Estilo asignado  |
|--------------|--------------|------------------|
| `mlopez23`   | `Casa_2026`  | Estilo principal |
| `paquito123` | `Piso_1234`  | Modo noche       |
| `jgarcia10`  | `Garaje_99`  | Alto contraste   |
| `amartinez`  | `Atico_2026` | Letra grande     |

**Organización de la parte privada:** se mantiene la estrategia **separada** de la práctica 7. La parte
privada tiene su propia barra de navegación (Inicio · Buscar · Mi cuenta · Salir) y la parte pública
la suya. Cuando hay un usuario autenticado o recordado, en la parte pública «Registrarse» se cambia por
«Mi cuenta» y «Salir».

---

## 2. Ficheros nuevos y modificados

```
Nexocasa/
├── includes/
│   ├── sesion.php            NUEVO: sesión, cookies, flashdata, "Recordarme", saludo y estilos
│   ├── ultimos-visitados.php NUEVO: panel "Últimos anuncios visitados" (cookie de 1 semana)
│   ├── funciones.php         carga sesion.php → TODAS las páginas inician la sesión
│   ├── acceso.php            formulario con "Recordarme" / mensaje de usuario recordado
│   ├── cabecera.php          aplica el estilo del usuario
│   ├── inicio.php            saludo por franja horaria, Salir, mensajes flash
│   ├── pie.php               muestra el panel de últimos anuncios visitados
│   └── anuncios.php          anuncios por id y "Mis anuncios" del usuario de la sesión
├── control-acceso.php        guarda el usuario en la sesión, crea la cookie y usa flashdata
├── salir.php                 NUEVO: cierra la sesión y borra las cookies
├── respuesta-registro.php    errores por flashdata (antes por la URL)
├── registro.php              lee los errores del flashdata
├── datos/
│   ├── .htaccess             NUEVO: nada de datos/ se puede abrir desde el navegador
│   ├── usuarios.php          contraseña + estilo de cada usuario
│   ├── anuncios.php          5 anuncios completos (antes 2)
│   └── privado/              NUEVO: tokens de "Recordarme" (no se sube a Git)
└── css/componentes.css       estilos de los avisos, botones y panel nuevos
```

Las 12 páginas privadas o restringidas llaman a `requerirAcceso()` al principio (ver apartado 5).

---

## 3. Cookies y sesiones: conceptos usados

- **HTTP no tiene estado**: cada petición es independiente y el servidor no sabe quién la hace.
- **Cookie**: dato que el servidor pide guardar al **navegador** (cabecera `Set-Cookie`). El navegador la
  devuelve en cada petición. Se crea con `setcookie()` y se lee con `$_COOKIE`. Se borra poniendo una
  fecha de caducidad en el pasado.
- **Sesión**: los datos se guardan en el **servidor** (`$_SESSION`). El navegador solo guarda una cookie
  (`PHPSESSID`) con el identificador de la sesión. Por defecto dura hasta que se cierra el navegador.
- Como las cookies y la sesión son **cabeceras HTTP**, se tienen que enviar **antes de cualquier salida**.
  Por eso la sesión se inicia en `funciones.php`, que se carga antes del `<!DOCTYPE html>`, y por eso
  `requerirAcceso()` y `registrarVisita()` se llaman al principio de cada página.
  No se usa `output_buffering`, como recomienda el enunciado.

---

## 4. Inicio de la sesión y cookies seguras

**Dónde:** `includes/sesion.php:32-72`

| Qué | Cómo |
|---|---|
| Ruta de las cookies | `rutaCookies()` (línea 32) usa la carpeta del sitio (`/Nexocasa/`): las cookies solo se envían a esta aplicación. |
| Opciones comunes | `opcionesCookie()` (línea 39). **`httponly => true`**: JavaScript no puede leer las cookies (pregunta del apartado 5 del enunciado). `samesite => 'Lax'`: no se envían en peticiones POST desde otros sitios. `secure` se activa solo si la web va por HTTPS. |
| Crear / borrar | `guardarCookie()` y `borrarCookie()` (líneas 51 y 58). Para borrar, se pone la fecha `time() - 42000`. |
| Inicio de la sesión | Línea 64: `session.use_strict_mode` (no acepta identificadores inventados), `session.use_only_cookies` (el identificador nunca va en la URL), los mismos parámetros seguros para `PHPSESSID` y `session_start()`. |

**Problemas de seguridad del apartado 4.3.4 y cómo se tratan:**
- **Fijación de sesión:** al iniciar sesión se llama a `session_regenerate_id(true)` (`sesion.php:123`), así
  que el identificador anterior al login deja de valer. También ayuda `use_strict_mode`.
- **Secuestro de sesión:** la cookie es `HttpOnly` (un script XSS no la puede leer), el identificador nunca
  viaja en la URL y todo lo que se imprime se escapa con `e()`.
- **Envenenamiento de sesión:** en `$_SESSION` solo se guardan valores que ha comprobado el servidor
  (el usuario después de validar la contraseña y el estilo leído de `datos/usuarios.php`), nunca datos
  copiados directamente de `$_POST` o `$_GET`.

---

## 5. Protección de las páginas privadas

**Dónde:** `requerirAcceso()` en `includes/sesion.php:135`

**Cómo funciona:** al principio de cada página protegida, antes de generar HTML:

```php
require_once 'includes/funciones.php';
requerirAcceso();   // sin sesión redirige a index.php
```

1. Si `$_SESSION['usuario']` existe, la página se muestra.
2. Si no, guarda en la sesión la página que se quería ver (`$_SESSION['destino']`), deja el flash
   «Tienes que iniciar sesión para ver esa página» y **redirige a `index.php`**, que tiene el formulario.
3. Después de iniciar sesión, `destinoTrasLogin()` (línea 152) devuelve al usuario a esa página. Si no
   había ninguna, va al menú. Solo acepta nombres de páginas `.php` del sitio, así que no se puede
   usar para redirigir a otra web.

**Páginas protegidas:**
- **Parte privada:** `index-autenticado.php`, `menu-usuario.php`, `mis-anuncios.php`, `ver-anuncio.php`, `anadir-foto.php`, `crear-anuncio.php`, `mis-mensajes.php`, `solicitar-folleto.php` y `respuesta-solicitar-folleto.php`.
- **Parte pública restringida:** `detalle-anuncio.php`, `enviar-mensaje.php` y `respuesta-enviar-mensaje.php`.

Los usuarios no registrados pueden ver los listados de la portada y de las búsquedas, pero al pulsar en
un anuncio van al formulario de acceso.

---

## 6. Inicio de sesión (`control-acceso.php`)

1. Si el usuario o la contraseña están vacíos o no son correctos, guarda el **error como flashdata** y
   redirige a `index.php` (ver apartado 9). También guarda el nombre escrito para volver a rellenarlo.
   La contraseña se compara con `hash_equals()`.
2. Si son correctos, `iniciarSesionUsuario()` (`sesion.php:120`) guarda en la sesión:
   - `usuario`: el nombre;
   - `estilo`: su estilo de `datos/usuarios.php`;
   - `recordado`: `false`, porque ha entrado con el formulario;
   - `ultimaVisita`: `null`.
3. Si se ha marcado **«Recordarme en este equipo»**, se llama a `recordarUsuario()`. Si no, a
   `olvidarUsuario()`, por si el equipo estaba recordando a otro usuario.
4. Redirige al menú de usuario o a la página protegida que se quería ver.

---

## 7. «Recordarme en este equipo»

**Dónde:** `includes/sesion.php:176-268` y la casilla en `includes/acceso.php`.

### 7.1 ¿Qué se guarda en la cookie?

**Ni el usuario ni la contraseña.** Como explica el enunciado, eso permitiría a cualquiera que use el
ordenador ver los datos y entrar desde otro equipo. En su lugar:

- La cookie `nexocasa_recordar` guarda un **token aleatorio** de 64 caracteres hexadecimales, generado con
  `random_bytes(32)`. Es imposible de adivinar.
- En el servidor, en `datos/privado/tokens-recordar.json`, se guarda el **hash SHA-256 del token**, nunca el
  token original. Junto al hash se guarda el usuario, la fecha de caducidad y la fecha de la última visita:

```json
{ "66bce009...": { "usuario": "paquito123", "caduca": 1802551420, "ultimaVisita": 1794775420 } }
```

Así, aunque alguien leyera el fichero del servidor, no podría fabricar la cookie. Además, el fichero no
se puede abrir desde el navegador, por `datos/.htaccess`, y no se sube a Git, por `datos/privado/.gitignore`.

### 7.2 Crear y borrar el token

- `recordarUsuario()` (línea 201) borra primero el token anterior, porque **solo se recuerda a un usuario**:
  el último que marcó la opción. Después crea el token nuevo con caducidad `time() + 90 días`, guarda
  `ultimaVisita = ahora` y envía la cookie con la **misma caducidad de 90 días**.
- `olvidarUsuario()` (línea 219) borra el token del servidor y la cookie del navegador.

### 7.3 Acceso automático

`accesoRecordado()` (línea 240) se ejecuta en **todas las páginas**, al final de `sesion.php`:

1. Si ya hay sesión, no hace nada.
2. Si no hay sesión pero existe la cookie, comprueba que el token tenga el formato correcto, que su hash
   esté en el servidor, que no haya caducado y que el usuario exista. Si algo falla, borra la cookie.
3. Si todo es correcto, **inicia la sesión** sin pedir usuario ni contraseña, como si el usuario nunca
   hubiese cerrado el navegador. Guarda `recordado = true` y la `ultimaVisita` que había guardada.
4. Actualiza en el servidor `ultimaVisita = ahora`, para la próxima vez.

**La cookie NO se renueva** (nota 10 del enunciado): en los accesos siguientes no se vuelve a llamar a
`setcookie()`. A los 90 días del inicio de sesión desaparece y hay que volver a identificarse.
**No hay expiración deslizante.** Lo comprueba también el servidor con el campo `caduca`.

### 7.4 Fecha y hora de la última visita

Sigue exactamente el ejemplo del enunciado. La última visita es la última vez que se usaron los datos de
«Recordarme» o, si no se han usado nunca, el inicio de sesión en el que se marcó la casilla:

| Momento | Qué pasa | Mensaje |
|---|---|---|
| 1 ene, 10:00 | Inicia sesión con «Recordarme» → `ultimaVisita = 01/01 10:00` | (ninguno, ha entrado con el formulario) |
| 3 ene, 09:00 | Vuelve: entra con la cookie → se muestra lo guardado y se guarda `03/01 09:00` | «Tu última visita fue el 01/01/26 a las 10:00» |
| 5 ene, 08:00 | Vuelve: entra con la cookie | «Tu última visita fue el 03/01/26 a las 09:00» |

El formato lo da `textoUltimaVisita()` (línea 289): `el dd/mm/aa a las HH:MM`.

### 7.5 Dónde se muestra el mensaje

Como la parte privada está **separada** (nota 12):
- **En `index.php`**, la página del formulario de acceso. Si se está recordando al usuario, **en lugar del
  formulario** aparece el saludo, su nombre, la fecha y hora de la última visita y los botones **Acceder** y
  **Salir** (Figura 2). Lo hace `includes/acceso.php`.
- **Si se entra directamente en una página privada o restringida** (por ejemplo, un favorito a
  `mis-anuncios.php`), el mensaje aparece en esa página, debajo de la cabecera. `includes/inicio.php` lo
  muestra cuando el acceso automático se ha producido en esa misma petición (`$accesoRecordadoAhora`) y la
  página está protegida (`$paginaProtegida`).
- En el resto de páginas públicas no aparece nada.
- Si el usuario ha entrado con el formulario, no se muestra ningún mensaje de última visita.

---

## 8. Saludo según la franja horaria

**Dónde:** `saludo()` en `includes/sesion.php:273`. Se usa en:
- el título del menú de usuario (`menu-usuario.php`);
- la cabecera de **todas** las páginas cuando hay sesión. Es un enlace al menú, como el botón de perfil
  que sugiere el enunciado;
- el bloque de acceso de `index.php`.

| Hora | Mensaje |
|---|---|
| 06:00 – 11:59 | Buenos días, Pepito |
| 12:00 – 15:59 | Hola, Pepito |
| 16:00 – 19:59 | Buenas tardes, Pepito |
| 20:00 – 05:59 | Buenas noches, Pepito |

La hora es la del **servidor**, con la zona horaria fijada con `date_default_timezone_set('Europe/Madrid')`
(`sesion.php:16`). La nota 16 del enunciado explica que lo ideal sería calcularlo en el cliente.

---

## 9. Flashdata

**Dónde:** `guardarFlash()` y `leerFlash()` en `includes/sesion.php:77-93`

**Cómo funciona:** se guardan en `$_SESSION['flash'][clave]`. **Al leerlos se borran**, así que solo están
disponibles en la página siguiente. Si se recarga la página, el mensaje ya no aparece. Con la URL de la
práctica 7, en cambio, el error se quedaba en la barra de direcciones y en el historial.

| Origen → destino | Antes (práctica 7) | Ahora (práctica 8) |
|---|---|---|
| `control-acceso.php` → `index.php` | `index.php?error=incorrecto` | `guardarFlash('error_acceso', 'incorrecto')` + `guardarFlash('usuario_acceso', ...)` |
| `respuesta-registro.php` → `registro.php` | `registro.php?errores[0]=...&email=...` | `guardarFlash('registro', ['errores' => [...], 'datos' => [...]])` |
| `requerirAcceso()` → `index.php` | — | `guardarFlash('aviso', 'Tienes que iniciar sesión...')` |
| `salir.php` → `index.php` | — | `guardarFlash('aviso', 'Has cerrado la sesión...')` |

- Los errores de acceso se leen en `includes/acceso.php:35` y los del registro en `registro.php:17`.
- Los avisos generales los pinta `includes/inicio.php` debajo de la cabecera, con `role="status"` para que
  los anuncien los lectores de pantalla.
- En el registro **las contraseñas siguen sin devolverse**, aunque ahora irían en la sesión y no en la URL:
  el usuario las tiene que volver a escribir.

---

## 10. Estilo del usuario

**Dónde:** `ESTILOS` y `estiloActual()` en `includes/sesion.php:295-309`, y `includes/cabecera.php:24`

**Cómo funciona:**
1. Cada usuario tiene un estilo en `datos/usuarios.php`.
2. Al iniciar sesión, o al ser recordado, se copia a `$_SESSION['estilo']`.
3. `cabecera.php` genera los `<link>` a partir de `ESTILOS`. El estilo del usuario se pone como
   **preferido** (`rel="stylesheet"`) y los demás como **alternativos** (`rel="alternate stylesheet"`). Así se
   conserva al pasar de una página a otra, que era el problema que plantea el enunciado.
4. Sin sesión se usa el «Estilo principal». Al salir se vuelve al principal.

El usuario todavía **no puede cambiar** su estilo. Se hará en una práctica posterior, desde su perfil. Su
estilo actual se muestra en el menú de usuario. Ejemplo: `paquito123` ve todo el sitio en **modo noche**.

---

## 11. Salir (cerrar sesión)

**Dónde:** `salir.php` y `cerrarSesion()` en `includes/sesion.php:163`

Enlazado desde la opción **Salir** del menú de usuario, desde la barra de navegación y desde el bloque
de acceso. Hace lo siguiente:

1. `olvidarUsuario()`: borra los datos de «Recordarme», tanto el token del servidor como la cookie.
   No hay una opción «Olvidarme» aparte, como pide el enunciado.
2. Borra la cookie de **últimos anuncios visitados**.
3. Destruye la sesión como en el apartado 4.3.1: `$_SESSION = []`, borra la cookie `PHPSESSID` y llama a
   `session_destroy()`.
4. Abre una sesión nueva y vacía solo para dejar el flash «Has cerrado la sesión» y redirige a `index.php`.

Después, cualquier página privada vuelve a pedir usuario y contraseña.

---

## 12. Panel «Últimos anuncios visitados»

**Dónde:** `includes/ultimos-visitados.php`. Se llama desde `detalle-anuncio.php:19` y desde `includes/pie.php:19`.

**Cómo funciona:**
- **Cookie** `nexocasa_ultimos`, que dura **1 semana**. Guarda solo los identificadores, del más antiguo al
  más reciente, por ejemplo `2,3,5,1`. Es `HttpOnly`.
- `registrarVisita($id)` se llama en `detalle-anuncio.php` antes de generar la salida:
  - quita el anuncio si ya estaba en la lista y lo añade al final, así **no se repite** y se respeta el
    orden de visita;
  - si hay más de **4**, elimina el que se visitó primero.
- `panelUltimosVisitados()` lo pinta en `pie.php`, en **todas las páginas públicas y restringidas** y para
  **todos los usuarios**, aunque no estén autenticados. Si está vacío, muestra «Todavía no has visitado
  ningún anuncio».
- Cada anuncio es un enlace a su página de detalle y muestra la **foto principal, el título, la ciudad, el
  país y el precio**.
- **Seguridad:** los datos no se guardan en la cookie, se buscan en el servidor a partir del id. Cada id se
  valida con `FILTER_VALIDATE_INT`, así que una cookie manipulada no puede inyectar HTML.
- Al pulsar **Salir** se borra la cookie. Así, en un mismo equipo, cada usuario empieza con su propia lista
  (nota 22).

Para que el panel no repita información (nota 18), `datos/anuncios.php` tiene ahora **5 anuncios
completos**, uno por cada anuncio del listado de la portada. Si se pide un id que no existe, se sigue
aplicando la regla par/impar de la práctica 7. Además, «Mis anuncios» muestra solo los anuncios del
usuario de la sesión.

---

## 13. Cómo comprobar cada punto

| Qué probar | Qué hacer | Resultado esperado |
|---|---|---|
| Protección de rutas | Sin iniciar sesión, escribir `http://localhost/Nexocasa/mis-anuncios.php` | Redirige a la portada con «Tienes que iniciar sesión para ver esa página» |
| Volver a la página pedida | Después de lo anterior, iniciar sesión | Se abre `mis-anuncios.php` |
| Detalle restringido | Sin sesión, pulsar un anuncio de la portada | Pide iniciar sesión; después muestra el detalle |
| Flashdata de acceso | Entrar con `mlopez23` / `mala` y después recargar (F5) | Sale el error, la URL es `index.php` sin parámetros y al recargar el error desaparece |
| Flashdata de registro | Registro con el usuario vacío y contraseñas distintas, y después F5 | 2 errores y los campos rellenados; al recargar, el formulario aparece limpio |
| Saludo | Iniciar sesión | «Buenas noches, mlopez23» (según la hora) en el menú y en la cabecera |
| Estilo | Entrar como `paquito123` y navegar | Todo el sitio en modo noche; al salir se vuelve al principal |
| Recordarme | Entrar con la casilla marcada, **cerrar el navegador entero** y volver | Ha entrado sin pedir datos; la portada muestra «Tu última visita fue el ...», con Acceder y Salir |
| Recordarme en privada | Cerrar el navegador y abrir directamente `menu-usuario.php` | Acceso directo y el mensaje de última visita debajo de la cabecera |
| Cookie no renovada | Ver la cookie `nexocasa_recordar` en las herramientas de desarrollador (F12 → Aplicación → Cookies) | La caducidad no cambia en las visitas siguientes |
| HttpOnly | Escribir `document.cookie` en la consola | No aparece ninguna cookie del sitio |
| Últimos visitados | Visitar los anuncios 1, 2, 3, 5 y otra vez el 1 | Panel: Ático, Piso, Estudio, Chalet (el 1 pasa al final y no se repite) |
| Salir | Pulsar Salir | Se borran la sesión, «Recordarme» y el panel; las páginas privadas vuelven a pedir los datos |

Todas estas pruebas se han ejecutado con el servidor de PHP (`php -S`) y `curl`, guardando las cookies
como hace un navegador. Para simular el cierre del navegador se borró la cookie `PHPSESSID`.

---

## 14. Decisiones y limitaciones

- **Los tokens están en un fichero JSON** porque todavía no hay base de datos. Cuando la haya, irán en una
  tabla, con la misma idea: hash del token, usuario, caducidad y última visita.
- **No se usa `session_write_close()`** (apartado 4.3.3) porque ninguna página hace tareas largas ni
  peticiones AJAX simultáneas. Si las hubiera, se llamaría justo después de leer y escribir la sesión.
- El token **no se asocia al navegador ni al sistema operativo** (nota 15): queda fuera de la asignatura.
- Si un usuario entra **sin** marcar «Recordarme» en un equipo que recordaba a otro, se deja de recordar
  al anterior. Así nunca hay dos usuarios mezclados en el mismo equipo.
- La validación en el cliente sigue desactivada (`VALIDACION_CLIENTE = false`), como en la práctica 7.
