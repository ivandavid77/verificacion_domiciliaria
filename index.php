<?php
    $config = require_once('config.php');
    include('inicio_sesion.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="iso-8859-1">
	<title>Carga de imágenes</title>
</head>
<body>
	<form action="subir_imagenes.php" method="post" enctype="multipart/form-data">
        <input name="clave_cuenta" type="text" placeholder="cuenta de cliente"><br>
        <input name="uploads[]" type="file" value="Imágen 1"><br>
        <input name="uploads[]" type="file" value="Imágen 2"><br>
        <input name="uploads[]" type="file" value="Imágen 3"><br>
        <input name="uploads[]" type="file" value="Imágen 4"><br>
        <input name="uploads[]" type="file" value="Imágen 5"><br>
        <input name="cargar_foto" type="submit" value="Cargar foto">
    </form>
</body>
</html>
