<?php
    session_start();
    $config = require_once('config.php');
    if (!isset($_SESSION['autenticado']) ||
        !$_SESSION['autenticado']) {
        // Iniciar proceso de autentificación
        $_SESSION['autenticado'] = true;
        header('Location: index.php');
        Exit;
    }
