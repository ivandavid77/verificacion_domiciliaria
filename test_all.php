<?php
    // Conexion
    $config = require_once('config.php');
    require_once('db_utils.php');
    require_once('queries.php');

    $config['db']['host'] = '172.16.202.15';
    $config['db']['user'] = 'test';
    $config['db']['password'] = '123456';
    $config['db']['database'] = 'expediente';

    $link = link($config);
    query(
        'INSERT INTO documentos_clientes SET '.
        'clave_cuenta = "T99999999"', $link);
    close($link);

    // Redimensionado
    require_once('image_utils.php');
    $source = getcwd() + '/test_image_source.jpg';
    $target = getcwd() + '/test_image_target.jpg';

    resize_image($filename, 200, 150, $target);
