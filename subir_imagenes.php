<?php
require_once('db_utils.php');
require_once('queries.php');


function createMsg($where, $type, $msg)
{
    if (!array_key_exists($where, $_SESSION)) {
        $_SESSION[$where] = array();
    }
    $data['type'] = $type;
    $data['data'] = $msg;
    $_SESSION[$where][] = $data;
}


function err($msg)
{
    createMsg('messages', 'error', $msg);
}


function info($msg)
{
    createMsg('messages', 'info', $msg);
}


function warn($msg)
{
    createMsg('messages', 'warn', $msg);
}


function guardarImagen($cuenta, $claveUsuario, $idDoc, $datosB64, $link, &$err)
{
    $sql = sqlObtenerDocumento($cuenta, $idDoc, $link);
    $result = doQuery($sql, $link);
    if (getNumRows($result) == 0) {
        $sql = sqlInsertarDocumento($cuenta, $claveUsuario, $idDoc, $datosB64, $link);
    } else {
        $sql = sqlActualizarDocumento($cuenta, $claveUsuario, $idDoc, $datosB64, $link);
    }
    $err = '';
    $result = doQuery($sql, $link, $err);
    if ($err != '') {
        return false;
    }
    if ($result === false) {
        return false;
    }
    return true;
}


// http://php.net/manual/en/function.imagecopyresampled.php
function resizeImage($filename, $max_w, $max_h, $to_file = null)
{
    list($src_w, $src_h) = getimagesize($filename);
    if ($src_h > $src_w) { // La foto es vertical
        $tmp = $max_w;
        $max_w = $max_h;
        $max_h = $tmp;
    }

    $src_ratio = $src_w/$src_h;
    if ($max_w/$max_h > $src_ratio) {
        $max_h = $max_h*$src_ratio;
    } else {
        $max_h = $max_w/$src_ratio;
    }
    $img_p = imagecreatetruecolor($max_w, $max_h);
    $img = imagecreatefromjpeg($filename);
    imagecopyresampled($img_p, $img, 0, 0, 0, 0, $max_w, $max_h, $src_w, $src_h);
    if ($to_file === null) {
        ob_start();
        imagejpeg($img_p, null, 100);
        return ob_get_clean();
    } else {
        imagejpeg($img_p, $to_file, 100);
        return $to_file;
    }
}


function imagenValida($archivo, &$error)
{
    if ($archivo['error'] == 4) {
        $error = 'Error al subir la imagen';
        return false;
    }
    if (@getimagesize($archivo['tmp_name']) === false) {
        $error = 'El archivo no es una imagen';
        return false;
    }
    if (@!is_uploaded_file($archivo['tmp_name'])) {
        $error = 'Error en la imagen proporcionada';
        return false;
    }
    return true;
}

// main
if (basename(__file__) == basename($_SERVER['PHP_SELF'])) {
    require_once('inicio_sesion.php');

    $cfg = require('config.php');
    ini_set('file_uploads', 'On');
    set_time_limit(0);


    if (!isset($_FILES['imagen1']) && !isset($_FILES['imagen2'])) {
        err('Error en campos proporcionados');
        header('Location: index.php');
        exit;
    }

    if (!isset($_POST['clave_cuenta']) || trim($_POST['clave_cuenta']) == '') {
        warn('Indique la clave de cuenta');
        header('Location: index.php');
        exit;
    }

    $host = $cfg['db_corporativo']['host'];
    $user = $cfg['db_corporativo']['user'];
    $pass = $cfg['db_corporativo']['password'];
    $database = $cfg['db_corporativo']['database'];
    $linkCorporativo = createLink($host, $user, $pass, $database);
    $cuenta = strtoupper($_POST['clave_cuenta']);
    $result = doQuery(sqlCuenta($cuenta, $linkCorporativo), $linkCorporativo, $err);
    if (getNumRows($result) == 0) {
        err('La clave de cuenta no existe');
        header('Location: index.php');
        exit;
    }
    doClose($linkCorporativo);

    $host = $cfg['db_expediente']['host'];
    $user = $cfg['db_expediente']['user'];
    $pass = $cfg['db_expediente']['password'];
    $database = $cfg['db_expediente']['database'];
    $linkExpediente = createLink($host, $user, $pass, $database);

    $maxWidth = $cfg['resize']['max_width'];
    $maxHeight = $cfg['resize']['max_height'];

    $imagen1 = $_FILES['imagen1'];
    if ($imagen1['tmp_name'] != '') {
        if (!imagenValida($imagen1, $err)) {
            err($err);
            header('Location: index.php');
            exit;
        } else {
            $datosBin = resizeImage($imagen1['tmp_name'], $maxWidth, $maxHeight);
            if (guardarImagen($cuenta, $_SESSION['clave_usuario'], 16, base64_encode($datosBin), $linkExpediente, $err)) {
                info('Se agrego '.$imagen1['name']);
            } else {
                err('Error al agregar '.$imagen1['name'].' : '.$err);
            }
        }
    }

    $imagen2 = $_FILES['imagen2'];
    if ($imagen2['tmp_name'] != '') {
        if (!imagenValida($imagen2, $err)) {
            err($err);
            header('Location: index.php');
            exit;
        } else {
            $datosBin = resizeImage($imagen2['tmp_name'], $maxWidth, $maxHeight);
            if (guardarImagen($cuenta, $_SESSION['clave_usuario'], 17, base64_encode($datosBin), $linkExpediente, $err)) {
                info('Se agrego '.$imagen2['name']);
            } else {
                err('Error al agregar '.$imagen2['name'].' : '.$err);
            }
        }
    }

    doClose($linkExpediente);
    header('Location: index.php');
}
