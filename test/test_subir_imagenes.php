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


    echo 'Inicializando<br><br>';
    @unlink(dirname(__file__).'/test_image_target.jpg');


    echo ' [x] resize_image   test_image_source.jpg<br>';
    $source = dirname(__FILE__).'/test_image_source.jpg';
    $target = dirname(__FILE__).'/test_image_target.jpg';
    resize_image($source, 200, 150, $target);
    echo 'Original <a href="test_image_source.jpg">test_image_source.jpg</a>';
    echo 'Resized  <a href="test_image_target.jpg">test_image_target.jpg</a>';


    $source = dirname(__FILE__).'/test_image_source.jpg';
    echo ' [x] valid_image   name: test_image_source.jpg, status: 4 <br>';
    list($valid, $msg) = valid_image('test_image_source', $source, 4);
    if ($valid == false && $msg == '')
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br><br>';

    echo ' [x] valid_image   name: test_image_source.jpg, status: 0, check_uploaded=false <br>';
    list($valid, $msg) = valid_image('test_image_source', $source, 0, false);
    if ($valid == true && $msg == '')
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';

    echo ' [x] valid_image   name: test_image_source.jpg, status: 0<br>';
    list($valid, $msg) = valid_image('test_image_source', $source, 0);
    if ($valid == false)
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br><br>';


    echo 'Inicializando<br><br>';
    $upload['upload']['name'] = array();
    $upload['upload']['name'][0] = 'file0.txt';
    $upload['upload']['name'][1] = 'file1.txt';

    $upload['upload']['type'] = array();
    $upload['upload']['type'][0] = 'text/plain';
    $upload['upload']['type'][1] = 'text/html';

    echo ' Original array: <br>';
    print_r($upload);

    echo ' [x] diverse_array<br>';
    $diversed = diverse_array($upload['upload']);
    print_r($diversed);
    if (isset($diversed[0]['name']) &&
        $diversed[0]['name'] == 'file0.txt' &&
        isset($diversed[0]['type']) &&
        $diversed[0]['type'] == 'text/plain' &&
        isset($diversed[1]['name']) &&
        $diversed[1]['name'] == 'file1.txt' &&
        isset($diversed[1]['type']) &&
        $diversed[1]['type'] == 'text/html')
        echo ' [x] sucess<br>';
    else
        echo ' [x] FAIL<br>';
