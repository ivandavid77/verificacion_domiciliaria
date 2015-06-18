<?php
    require('inicio_sesion.php');
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
        <input name="uploads[]" type="file"><br>
        <input name="uploads[]" type="file"><br>
        <input name="uploads[]" type="file"><br>
        <input type="submit" value="Cargar fotos">
    </form>
	<?php
		if (isset($_SESSION['messages'])) {
			foreach ($_SESSION['messages'] as $msg)
				if ($msg['data'] != '')
					echo '<p class="'.$msg['type'].'">'.$msg['data'].'</p>';

		}
		unset($_SESSION['messages']);
	?>
</body>
</html>
