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
    $sucess = make_query($query, $link);
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] obtener_documentos_clientes<br>';
    $query = obtener_documentos_clientes('T99999999', '11');
    $result = make_query($query, $link);
    $sucess = false;
    while ($row = get_dict($result))
        if ($row['archivo'] == '1234') $sucess = true;
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] actualizar_documentos_clientes<br>';
    $query = actualizar_documentos_clientes('T99999999', '11', '5678');
    $sucess = make_query($query, $link);
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] Comprobando actualizacion con "obtener_documentos_clientes"<br>';
    $query = obtener_documentos_clientes('T99999999', '11');
    $result = make_query($query, $link);
    $sucess = false;
    while ($row = get_dict($result))
        if ($row['archivo'] == '5678') $sucess = true;
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] borrar_documentos_clientes<br>';
    $query = borrar_documentos_clientes('T99999999', '11');
    $sucess = make_query($query, $link);
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';

    make_close($link);
