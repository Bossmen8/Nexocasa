# Práctica 7 — PHP: plantilla y formularios

Este documento explica dónde está cada cosa que pide el enunciado y cómo funciona.

## Cómo probarlo

1. Copia la carpeta en `C:\xampp\htdocs\`. Si ya había una versión anterior, **bórrala antes**.
2. Arranca Apache en XAMPP.
3. Abre `http://localhost:8080/NOMBRE_DE_LA_CARPETA/`. Usa el puerto que muestre XAMPP; sin puerto, si es el 80.

**Usuarios para iniciar sesión** (`datos/usuarios.php`): `mlopez23`, `paquito123`, `jgarcia10` y `amartinez`. Todos tienen la contraseña **`1234`**.

## Ficheros

| Fichero | Para qué sirve |
|---|---|
| `includes/cabecera.php` | Plantilla 1/3: `<!DOCTYPE>`, `<head>` y estilos. Usa la variable `$titulo`. |
| `includes/inicio.php` | Plantilla 2/3: `<body>` y la barra de navegación. Con `$zona = 'privada'` muestra el menú privado. |
| `includes/pie.php` | Plantilla 3/3: `<footer>` y `</body></html>`. |
| `includes/funciones.php` | `e()` muestra texto de forma segura, porque usa `htmlspecialchars` y evita XSS. `redirigir()` hace la redirección con `header('Location: ...')`. |
| `includes/acceso.php` | Formulario de login y mensaje de error. |
| `includes/lista-anuncios.php` | Listado de anuncios de ejemplo; cada enlace lleva `?id=N`. |
| `includes/ficha-anuncio.php` | Muestra toda la información de un anuncio. |
| `includes/tarifas.php` | Función `costeFolleto()`, que calcula el precio de un folleto. |
| `datos/usuarios.php` | Solo los 4 usuarios permitidos. |
| `datos/anuncios.php` | Solo los 2 anuncios de ejemplo: `par` e `impar`. |

**Todas las páginas tienen la misma estructura:**

```php
<?php
$titulo = 'Título de la página';
$zona = 'privada';              // solo en las páginas de la parte privada
require 'includes/cabecera.php';
require 'includes/inicio.php';
?>
<main> ...contenido de la página... </main>
<?php require 'includes/pie.php'; ?>
```

Los ficheros incluidos tienen extensión `.php` y no `.inc`. Así, si alguien abre `datos/usuarios.php` en el navegador, el servidor lo ejecuta y no muestra las contraseñas.

## Páginas modificadas

**Solicitar folleto** (`solicitar-folleto.php`)
- Además de las tarifas y el formulario, tiene la tabla de posibles costes **calculada con PHP**. Es un bucle `for` de 1 a 15 páginas, con 3 fotos por página, que llama a `costeFolleto()`.
- La tabla de JavaScript de la práctica 6 se mantiene debajo para comprobar que salen los mismos importes.

**Respuesta solicitar folleto** (`respuesta-solicitar-folleto.php`)
- Muestra los datos recibidos por POST.
- Calcula el coste con valores ficticios: 5 páginas y 15 fotos.
- Usa el color y la resolución que elige el usuario.
- **Coste total = coste de un folleto × número de copias.**

**Resultado de búsqueda** (`resultado-busqueda.php`)
- Recibe los datos por GET, tanto desde la búsqueda rápida como desde `busqueda.php`.
- Con un `foreach` muestra solo los campos que el usuario ha rellenado.
- Debajo aparece el listado de ejemplo.

**Detalle anuncio** (`detalle-anuncio.php?id=N`)
- Si `N` es par muestra el anuncio `par`; si es impar, el anuncio `impar`. Lo decide `$id % 2 == 0`.
- Si el id no es un número, muestra «Anuncio no encontrado».

**Respuesta enviar mensaje** (`respuesta-enviar-mensaje.php`)
- Comprueba que el tipo de mensaje es uno de los 3 permitidos y que el texto no está vacío.
- Si hay algún error, lo muestra con un enlace para volver al formulario. Si no, muestra los datos.

## Páginas nuevas

**Control de acceso** (`control-acceso.php`). No muestra nada, solo redirige:
1. Con `trim()` quita los espacios y tabuladores. Si el usuario o la contraseña quedan vacíos, redirige a `index.php?error=vacio`.
2. Comprueba el usuario y la contraseña en `datos/usuarios.php`.
   - Si son correctos, redirige a `menu-usuario.php?usuario=...`, y en la cabecera aparece «Hola, usuario».
   - Si no, redirige a `index.php?error=incorrecto`.
3. `includes/acceso.php` lee `$_GET['error']` y muestra el mensaje.

**Mis anuncios** (`mis-anuncios.php`)
- Tabla con la foto, el título, la ciudad, el país y el precio de cada anuncio, generada con un `foreach` sobre `datos/anuncios.php`.
- Cada fila tiene un enlace a «Ver anuncio» y otro a «Añadir foto».

**Ver anuncio** (`ver-anuncio.php?id=N`)
- Muestra la misma ficha que el detalle (`includes/ficha-anuncio.php`).
- Añade el enlace «Añadir una foto a este anuncio», que lleva a `anadir-foto.php?anuncio=N`.

**Añadir foto a anuncio** (`anadir-foto.php`)
- Tiene los campos foto, texto alternativo (mínimo 10 caracteres), título y anuncio.
- **Sin `?anuncio=` (desde el menú):** la lista desplegable aparece sin ningún anuncio elegido.
- **Con `?anuncio=N` (desde «Mis anuncios» o «Ver anuncio»):** el anuncio sale seleccionado y la lista está `disabled`. Como un `select` desactivado no se envía, el valor va también en un `<input type="hidden">`.
- La subida de la foto se hará en otra práctica.

**Crear anuncio** (`crear-anuncio.php`)
- Formulario con todos los datos del anuncio y sus características.
- La respuesta se hará en otra práctica.

**Respuesta del registro** (`respuesta-registro.php`)
- Comprueba que el usuario, la contraseña y repetir contraseña no estén vacíos, y que las dos contraseñas coincidan.
- **Si hay errores,** vuelve a `registro.php` pasando los errores y los datos por la URL. Por ejemplo: `registro.php?errores=usuario,no-coinciden&email=...`
- `registro.php` muestra los errores arriba y rellena los campos con lo que se había escrito.
- Las contraseñas no se ponen en la URL, por seguridad.
- **Si todo es correcto,** muestra los datos. No muestra la foto.

## Validación HTML y JavaScript desactivada

El enunciado pide desactivarla para poder comprobar la de PHP:
- Los formularios de login, registro y enviar mensaje llevan `novalidate`.
- Ya no se cargan `login.js` ni `registro.js`. Los ficheros siguen en `js/` por si hacen falta.

## Cambios del compañero (después de la práctica 6)

- **`js/folleto.js`:** la tabla de JavaScript se muestra y oculta con el atributo `hidden`.
- **`js/interfaz.js`:** se ha corregido que se perdiera el clic en el botón cuando aparecía un aviso de error.

## Para prácticas posteriores

- **Sesiones** (práctica 8): ahora el nombre del usuario solo llega al menú por la URL.
- **Base de datos:** sustituirá a los ficheros de `datos/`.
- **Subida de fotos.**
