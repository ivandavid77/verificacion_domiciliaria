<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once('../queries.php');
    require_once('../db_utils.php');

    $config['db']['host'] = '172.16.202.15';
    $config['db']['user'] = 'test';
    $config['db']['password'] = '123456';
    $config['db']['database'] = 'expediente';

    echo 'Conectando<br><br>';
    $link = make_link($config);

    echo 'Inicializando<br><br>';
    make_query(borrar_documentos_clientes('T99999999', '11'));

    echo 'Inician consultas<br><br>';


    echo ' [x] insertar_documentos_clientes<br>';
    $sucess = make_query(insertar_documentos_clientes('T99999999', '11',
                                                      '1234'));
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] obtener_documentos_clientes<br>';
    $result = make_query(obtener_documentos_clientes('T99999999', '11'));
    $sucess = false;
    while ($row = get_dict($result))
        if ($row['archivo'] == '1234') $sucess = true;
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] actualizar_documentos_clientes<br>';
    $sucess = make_query(actualizar_documentos_clientes('T99999999', '11',
                                                        '5678'));
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] Comprobando actualizacion con "obtener_documentos_clientes"<br>';
    $result = make_query(obtener_documentos_clientes('T99999999', '11'));
    $sucess = false;
    while ($row = get_dict($result))
        if ($row['archivo'] == '5678') $sucess = true;
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';


    echo ' [x] borrar_documentos_clientes<br>';
    $sucess = make_query(borrar_documentos_clientes('T99999999', '11'));
    if ($sucess)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';

    make_close($link);
