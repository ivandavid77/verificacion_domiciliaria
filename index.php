<?php
    require('inicio_sesion.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="iso-8859-1">
  <title>Carga de imagenes</title>
  <style>
    html, body {height:100%;}
    html {display:table; width:100%;}
    body {display:table-cell; text-align:center; vertical-align:middle;}
    .fuente_aumentada {
      font-size: 200%;
    }
    .altura_aumentada {
      transform:scale(3,4); /* W3C */
      -webkit-transform:scale(3,4); /* Safari and Chrome */
      -moz-transform:scale(3,4); /* Firefox */
      -ms-transform:scale(3,4); /* IE 9 */
      -o-transform:scale(3,4);*/
    }
  </style>
</head>
<body>
	<form action="subir_imagenes.php" method="post" enctype="multipart/form-data">
    <br>
    <br>
    <input class="altura_aumentada" name="clave_cuenta" type="text" placeholder="cuenta de cliente">
    <br>
    <br>
    <br>
    <br>
    <label class="fuente_aumentada" for="imagen1">Foto 1</label>
    <input class="fuente_aumentada" name="imagen1" type="file">
    <br>
    <br>
    <label class="fuente_aumentada" for="imagen2">Foto 2</label>
    <input class="fuente_aumentada" name="imagen2" type="file">
    <br>
    <br>
    <br>
    <br>
    <input class="fuente_aumentada" type="submit" value="Cargar fotos">
  </form>
  <br>
  <br>
  <br>
<?php
if (isset($_SESSION['messages'])) {
    foreach ($_SESSION['messages'] as $msg) {
        if ($msg['data'] != '') {
	          echo '<p class="'.$msg['type'].' fuente_aumentada">'.$msg['data'].'</p>';
        }
    }
    unset($_SESSION['messages']);
}
?>
</body>
</html>
