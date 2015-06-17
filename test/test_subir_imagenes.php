<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once('../subir_imagenes.php');
    require_once('../db_utils.php');
    require_once('../queries.php');

    $host = '172.16.202.15';
    $user = 'test';
    $password = '123456';
    $database = 'expediente';

    echo 'Conectando<br><br>';
    $link = make_link($host, $user, $password, $database);

    echo 'Inicializando<br><br>';
    $query = borrar_documentos_clientes('T99999999', '11');
    make_query($query, $link);


    echo ' [x] set_data   id: 11, data: 1234<br>';
    set_data('T99999999',11, '1234', $link);
    $query = obtener_documentos_clientes('T99999999', 11);
    $row = get_dict(make_query($query, $link));
    if ($row['archivo'] == '1234')
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] set_data   id: 11, data: 5678<br>';
    set_data('T99999999',11, '5678', $link);
    $query = obtener_documentos_clientes('T99999999', 11);
    $row = get_dict(make_query($query, $link));
    if ($row['archivo'] == '5678')
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    make_close($link);
