<?php
    $config = require_once('config.php');
    include('inicio_sesion.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="iso-8859-1">
	<title>Carga de im�genes</title>
</head>
<body>
	<form action="subir_imagenes.php" method="post" enctype="multipart/form-data">
        <input name="clave_cuenta" type="text" placeholder="cuenta de cliente"><br>
        <input name="uploads[]" type="file" value="Im�gen 1"><br>
        <input name="uploads[]" type="file" value="Im�gen 2"><br>
        <input name="uploads[]" type="file" value="Im�gen 3"><br>
        <input name="uploads[]" type="file" value="Im�gen 4"><br>
        <input name="uploads[]" type="file" value="Im�gen 5"><br>
        <input name="cargar_foto" type="submit" value="Cargar foto">
    </form>
</body>
</html>
