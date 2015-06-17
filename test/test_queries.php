<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once('../queries.php');
    require_once('../db_utils.php');

    $host = '172.16.202.15';
    $user = 'test';
    $password = '123456';
    $database = 'expediente';


    echo 'Conectando<br><br>';
    $link = make_link($host, $user, $password, $database);


    echo 'Inicializando<br><br>';
    $query = borrar_documentos_clientes('T99999999', '11');
    make_query($query, $link);


    echo 'Inician consultas<br><br>';

    echo ' [x] insertar_documentos_clientes<br>';
    $query = insertar_documentos_clientes('T99999999', '11', '1234');
    if (make_query($query, $link))
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] obtener_documentos_clientes<br>';
    $query = obtener_documentos_clientes('T99999999', '11');
    $row = get_dict(make_query($query, $link));
    if ($row['archivo'] == '1234')
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] actualizar_documentos_clientes<br>';
    $query = actualizar_documentos_clientes('T99999999', '11', '5678');
    if (make_query($query, $link));
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] Comprobando actualizacion con "obtener_documentos_clientes"<br>';
    $query = obtener_documentos_clientes('T99999999', '11');
    $row = get_dict(make_query($query, $link));
    if ($row['archivo'] == '5678')
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] borrar_documentos_clientes<br>';
    $query = borrar_documentos_clientes('T99999999', '11');
    if (make_query($query, $link))
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';

    make_close($link);
