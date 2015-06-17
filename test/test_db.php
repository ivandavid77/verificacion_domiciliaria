<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once('../db_utils.php');

    echo 'Conectando<br><br>';
    $link = make_link('172.16.202.15', 'test', '123456', 'expediente');
    echo 'Realizando consulta<br><br>';
    $result = make_query(
        'SELECT 1 AS resultado '.
        'FROM dual ', $link);
    $row = get_dict($result);
    echo 'Resultado de la consulta es: '.$row['resultado'];
    make_close($link);
