<?php
    $config = require_once('config.php');
    require_once('db_utils.php');
    require_once('queries.php');

    $config['db']['host'] = '172.16.202.15';
    $config['db']['user'] = 'test';
    $config['db']['password'] = '123456';
    $config['db']['database'] = 'expediente';

    $link = make_link($config);
    $result = make_query(
        'SELECT clave_cuenta '.
        'FROM documentos_clientes '.
        'WHERE clave_cuenta = "T99999999" '.
        'LIMIT 1', $link);
    while ($row = get_dict($result)) {
        echo 'Encontrado previamente: '.$row['clave_cuenta'];
    }

    /*make_query(
        'INSERT INTO documentos_clientes SET '.
        'clave_cuenta = "T99999999"', $link);*/
    make_close($link);
