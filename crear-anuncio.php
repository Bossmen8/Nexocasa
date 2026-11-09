<?php
// Crear anuncio (parte privada): solo el formulario. La respuesta se hará en otra práctica.
$titulo = 'Crear anuncio';
$zona = 'privada';
require 'includes/cabecera.php';
require 'includes/inicio.php';
?>
<main id="contenido">
<h1>Crear un anuncio nuevo</h1>
<form class="conBorde" action="error-404.php" method="post">
<fieldset>
<legend>Tipo de anuncio *</legend>
<label><input type="radio" name="tipo-anuncio" value="alquiler"> Alquiler</label>
<label><input type="radio" name="tipo-anuncio" value="venta"> Venta</label>
</fieldset>
<p>
<label for="tipo-vivienda">Tipo de vivienda *</label><br>
<select id="tipo-vivienda" name="tipo-vivienda">
<option value="garaje">Garaje</option>
<option value="local">Local</option>
<option value="obra-nueva">Obra nueva</option>
<option value="oficina">Oficina</option>
<option value="vivienda" selected>Vivienda</option>
</select>
</p>
<p><label for="titulo-anuncio">Título *</label><br><input type="text" id="titulo-anuncio" name="titulo"></p>
<p><label for="precio">Precio (€) *</label><br><input type="number" id="precio" name="precio" min="0"></p>
<p><label for="texto">Texto *</label><br><textarea id="texto" name="texto" rows="6" cols="50"></textarea></p>
<p><label for="ciudad">Ciudad *</label><br><input type="text" id="ciudad" name="ciudad"></p>
<p>
<label for="pais">País *</label><br>
<select id="pais" name="pais">
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
<legend>Características</legend>
<p><label for="superficie">Superficie (m²)</label> <input type="number" id="superficie" name="superficie" min="1"></p>
<p><label for="habitaciones">Habitaciones</label> <input type="number" id="habitaciones" name="habitaciones" min="0"></p>
<p><label for="banos">Baños</label> <input type="number" id="banos" name="banos" min="0"></p>
<p><label for="planta">Planta</label> <input type="number" id="planta" name="planta"></p>
<p><label for="anio">Año de construcción</label> <input type="number" id="anio" name="anio"></p>
</fieldset>
<p><button type="submit">Crear anuncio</button></p>
</form>
</main>
<?php require 'includes/pie.php'; ?>
