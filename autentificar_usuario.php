<?php
session_start();
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
    createMsg('login_messages', 'error', $msg);
}


function info($msg)
{
    createMsg('login_messages', 'info', $msg);
}


function warn($msg)
{
    createMsg('login_messages', 'warn', $msg);
}

// main
if (basename(__file__) == basename($_SERVER['PHP_SELF'])) {
    $cfg = require('config.php');
    set_time_limit(0);

    if (!isset($_POST['user']) && !isset($_POST['password'])) {
        err('Error en campos proporcionados');
        header('Location: login.php');
        exit;
    }

    if (trim($_POST['user']) == '') {
        warn('Indique el usuario');
        header('Location: login.php');
        exit;
    }

    if (trim($_POST['password']) == '') {
        warn('Indique la contraseña');
        header('Location: login.php');
        exit;
    }

    $host = $cfg['db_corporativo']['host'];
    $user = $cfg['db_corporativo']['user'];
    $pass = $cfg['db_corporativo']['password'];
    $database = $cfg['db_corporativo']['database'];
    $linkCorporativo = createLink($host, $user, $pass, $database);
    $user = strtoupper($_POST['user']);
    $pass = $_POST['password'];
    $result = doQuery(sqlUsuario($user, $pass, $linkCorporativo), $linkCorporativo, $err);
    if (getNumRows($result) == 0) {
        err('Datos incorrectos, verifique');
        header('Location: login.php');
        exit;
    } else {
        $usuario = getDict($result);
        $_SESSION['clave_usuario'] = $usuario['clave_usuario'];
        $_SESSION['autentificado'] = true;
        $_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];
        header('Location: index.php');
    }
    doClose($linkCorporativo);
}
