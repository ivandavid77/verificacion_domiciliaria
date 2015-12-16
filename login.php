<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="iso-8859-1">
  <title>Inicio de sesion</title>
  <style>
    html, body {height:100%;}
    html {display:table; width:100%;}
    body {display:table-cell; text-align:center; vertical-align:middle;}
    .fuente_aumentada {
      font-size: 300%;
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
  <h1 class="fuente_aumentada">Iniciar Sesion</h1>

	<form action="autentificar_usuario.php" method="post">
    <br>
    <br>
    <input class="altura_aumentada" name="user" type="text" placeholder="usuario">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <input class="altura_aumentada" name="password" type="password" placeholder="contraseña">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <input class="fuente_aumentada" type="submit" value="Enviar">
  </form>
  <br>
  <br>
  <br>
<?php
if (isset($_SESSION['login_messages'])) {
    foreach ($_SESSION['login_messages'] as $msg) {
        if ($msg['data'] != '') {
	          echo '<p class="'.$msg['type'].' fuente_aumentada">'.$msg['data'].'</p>';
        }
    }
    unset($_SESSION['login_messages']);
}
?>
</body>
</html>
