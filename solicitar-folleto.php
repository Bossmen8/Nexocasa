<?php
// Solicitar folleto (parte privada): tarifas, formulario y tabla de posibles costes calculada con PHP.
// También se deja la tabla de JavaScript de la práctica 6 para comprobar que salen los mismos costes.
$titulo = 'Solicitar folleto publicitario';
$zona = 'privada';
require 'includes/cabecera.php';
require 'includes/inicio.php';
require 'includes/tarifas.php';
?>
<main id="contenido" class="columnas">
<h1>Solicitud de impresión de folleto publicitario</h1>
<p>Rellena el formulario con tus datos de envío y las opciones de impresión que prefieras.</p>

<aside>
<h2>Tarifas</h2>
<table>
<tr><th scope="col">Concepto</th><th scope="col">Tarifa</th></tr>
<tr><th scope="row">Coste procesamiento y envío</th><td>10 €</td></tr>
<tr><th scope="row">&lt; 5 páginas</th><td>2 € por pág.</td></tr>
<tr><th scope="row">entre 5 y 10 páginas</th><td>1,8 € por pág.</td></tr>
<tr><th scope="row">&gt; 10 páginas</th><td>1,6 € por pág.</td></tr>
<tr><th scope="row">Blanco y negro</th><td>0 €</td></tr>
<tr><th scope="row">Color</th><td>0,5 € por foto</td></tr>
<tr><th scope="row">Resolución &lt;= 300 dpi</th><td>0 € por foto</td></tr>
<tr><th scope="row">Resolución &gt; 300 dpi</th><td>0,2 € por foto</td></tr>
</table>
</aside>

<form class="conBorde" action="respuesta-solicitar-folleto.php" method="post">
<h2>Formulario de solicitud</h2>
<p><label for="texto-adicional">Texto adicional</label><br><textarea id="texto-adicional" name="texto-adicional" rows="4" cols="50"></textarea></p>
<p><label for="nombre">Nombre *</label><br><input type="text" id="nombre" name="nombre" required></p>
<p><label for="email">Correo electrónico *</label><br><input type="email" id="email" name="email" required></p>
<fieldset>
<legend>Dirección de envío *</legend>
<p><label for="calle">Calle</label> <input type="text" id="calle" name="calle" required></p>
<p><label for="numero">Número</label> <input type="text" id="numero" name="numero" required></p>
<p><label for="piso">Piso</label> <input type="text" id="piso" name="piso"></p>
<p><label for="puerta">Puerta</label> <input type="text" id="puerta" name="puerta"></p>
<p><label for="cp">Código postal</label> <input type="text" id="cp" name="cp" required></p>
<p><label for="localidad">Localidad</label> <input type="text" id="localidad" name="localidad" required></p>
<p><label for="provincia">Provincia</label> <input type="text" id="provincia" name="provincia" required></p>
<p>
<label for="pais-envio">País</label>
<select id="pais-envio" name="pais-envio">
<option value="alemania">Alemania</option>
<option value="argentina">Argentina</option>
<option value="belgica">Bélgica</option>
<option value="colombia">Colombia</option>
<option value="espana" selected>España</option>
<option value="francia">Francia</option>
<option value="italia">Italia</option>
<option value="mexico">México</option>
<option value="portugal">Portugal</option>
<option value="reino-unido">Reino Unido</option>
</select>
</p>
</fieldset>
<p><label for="telefono">Teléfono</label><br><input type="tel" id="telefono" name="telefono"></p>
<p><label for="color-portada">Color de la portada *</label><br><input type="color" id="color-portada" name="color-portada" value="#000000"></p>
<p><label for="num-copias">Número de copias *</label><br><input type="number" id="num-copias" name="num-copias" min="1" max="99" value="1" required></p>
<p>
<label for="resolucion">Resolución de impresión *</label><br>
<select id="resolucion" name="resolucion">
<option>150</option><option>300</option><option>450</option><option>600</option><option>750</option><option>900</option>
</select> dpi
</p>
<p>
<label for="anuncio">Anuncio *</label><br>
<select id="anuncio" name="anuncio">
<option value="Chalet adosado de diseño (Madrid)">Chalet adosado de diseño (Madrid)</option>
<option value="Ático luminoso con terraza (Barcelona)">Ático luminoso con terraza (Barcelona)</option>
</select>
</p>
<p><label for="fecha-recepcion">Fecha de recepción</label><br><input type="date" id="fecha-recepcion" name="fecha-recepcion"></p>
<fieldset>
<legend>¿Impresión a color?</legend>
<label><input type="radio" name="impresion-color" value="color"> Color</label>
<label><input type="radio" name="impresion-color" value="blanco-negro" checked> Blanco y negro</label>
</fieldset>
<fieldset>
<legend>¿Impresión del precio?</legend>
<label><input type="radio" name="impresion-precio" value="Sí" checked> Sí</label>
<label><input type="radio" name="impresion-precio" value="No"> No</label>
</fieldset>
<p><button type="submit">Solicitar</button></p>
</form>

<section class="conBorde">
<h2>Posibles costes de un folleto (calculado con PHP)</h2>
<div class="tabla-desplazable">
<table class="tabla-costes">
<tr>
<th rowspan="2">Número de páginas</th>
<th rowspan="2">Número de fotos</th>
<th colspan="2">Blanco y negro</th>
<th colspan="2">Color</th>
</tr>
<tr>
<th>150-300 dpi</th><th>450-900 dpi</th>
<th>150-300 dpi</th><th>450-900 dpi</th>
</tr>
<?php for ($paginas = 1; $paginas <= 15; $paginas++):
    $fotos = $paginas * 3; ?>
<tr>
<td><?= $paginas ?></td>
<td><?= $fotos ?></td>
<td><?= euros(costeFolleto($paginas, $fotos, false, 150)) ?></td>
<td><?= euros(costeFolleto($paginas, $fotos, false, 450)) ?></td>
<td><?= euros(costeFolleto($paginas, $fotos, true, 150)) ?></td>
<td><?= euros(costeFolleto($paginas, $fotos, true, 450)) ?></td>
</tr>
<?php endfor; ?>
</table>
</div>
</section>

<section class="conBorde">
<h2 id="titulo-costes">Posibles costes de un folleto (calculado con JavaScript)</h2>
<p><button type="button" id="boton-costes" aria-expanded="false" aria-controls="contenedor-costes"><span id="texto-boton-costes">Mostrar tabla de costes</span></button></p>
<div id="contenedor-costes" class="tabla-desplazable" hidden></div>
</section>
</main>
<script src="js/folleto.js"></script>
<?php require 'includes/pie.php'; ?>
