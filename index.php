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
		if (isset($_SESSION['msg'])) {
			echo '<p class="'.$_SESSION['msg']['type'].'">'.$_SESSION['msg']['data'].'</p>';
			unset($_SESSION['msg']);
		}
	?>
</body>
</html>
