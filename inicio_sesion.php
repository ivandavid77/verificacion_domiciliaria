<?php
    session_start();
    $config = require_once('config.php');
    if (!isset($_SESSION['autenticado']) ||
        !$_SESSION['autenticado']) {
        // Iniciar proceso de autentificaci�n
        $_SESSION['autenticado'] = true;
        header('Location: index.php');
        Exit;
    }
