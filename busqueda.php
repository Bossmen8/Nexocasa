<?php
// Formulario de búsqueda: envía los datos por GET a resultado-busqueda.php
$titulo = 'Buscar inmuebles';
require 'includes/cabecera.php';
require 'includes/inicio.php';
?>
<main id="contenido">
<h1>Buscar inmuebles</h1>

<form class="conBorde" action="resultado-busqueda.php" method="get">

<fieldset>
<legend>Tipo de anuncio</legend>
<label><input type="radio" name="tipo-anuncio" value="alquiler"> Alquiler</label>
<label><input type="radio" name="tipo-anuncio" value="venta"> Venta</label>
</fieldset>

<p>
<label for="tipo-vivienda">Tipo de vivienda</label><br>
<select id="tipo-vivienda" name="tipo-vivienda">
<option value="">(Cualquiera)</option>
<option value="garaje">Garaje</option>
<option value="local">Local</option>
<option value="obra-nueva">Obra nueva</option>
<option value="oficina">Oficina</option>
<option value="vivienda">Vivienda</option>
</select>
</p>

<p>
<label for="ciudad">Ciudad</label><br>
<input type="text" id="ciudad" name="ciudad">
</p>

<p>
<label for="pais">País</label><br>
<select id="pais" name="pais">
<option value="">(Cualquiera)</option>
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

<fieldset>
<legend>Precio entre</legend>
<p><label for="precio-desde">Desde (€)</label>
<input type="number" id="precio-desde" name="precio-desde" min="0" step="1000"></p>
<p><label for="precio-hasta">Hasta (€)</label>
<input type="number" id="precio-hasta" name="precio-hasta" min="0" step="1000"></p>
</fieldset>


<fieldset>
<legend>Fecha de publicación entre</legend>
<p><label for="fecha-desde">Desde</label>
<input type="date" id="fecha-desde" name="fecha-desde"></p>
<p><label for="fecha-hasta">Hasta</label>
<input type="date" id="fecha-hasta" name="fecha-hasta"></p>
</fieldset>


<p><button type="submit"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>Buscar</button></p>

</form>

</main>
<?php require 'includes/pie.php'; ?>
