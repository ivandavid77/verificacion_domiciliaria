<?php
session_start();
$config = require('config.php');

if (isset($_SESSION['autentificado']) && $_SESSION['autentificado'] === true) {
    $time = $_SERVER['REQUEST_TIME'];
    $timeoutDuration = $config['session_timeout_duration'];

    $iniciarSesion = false;
    if (isset($_SESSION['last_activity']) && ($time - $_SESSION['last_activity']) > $timeoutDuration) {
        session_unset();
        session_destroy();
        session_start();
        $iniciarSesion = true;
    }
    $_SESSION['last_activity'] = $time;
    if ($iniciarSesion) {
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
