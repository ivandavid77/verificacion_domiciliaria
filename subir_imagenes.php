<?php
    $config = require_once('config.php');
    require_once('inicio_sesion.php');
    require_once('image_utils.php');
    require_once('db_utils.php');
    require_once('queries.php');

    ini_set('file_uploads','On');
    set_time_limit(0);

    function sanitizar($texto) {
        return $texto;
    }

    // sergio_ag.terra.com.br http://php.net/manual/es/reserved.variables.files.php
    function diverse_array($vector) {
        $result = array();
        foreach($vector as $key1 => $value1)
            foreach($value1 as $key2 => $value2)
                $result[$key2][$key1] = $value2;
        return $result;
    }

    function guardar_imagenes($clave_cuenta, $uploads, $config) {
        $link = make_link($config);
        $uploads = diverse_array($uploads);
        foreach ($uploads as $file) {
            if ($file['error'] != UPLOAD_ERR_OK ||
                @!is_uploaded_file($file['tmp_name']) ||
                @getimagesize($file['tmp_name']) === false) {
                continue; // Solo archivos sin errores
            }
            //$name = md5_file($file['tmp_name']);
            $data = base64_encode(resize_image($file['tmp_name'],
                                       $config['resize']['max_width'],
                                       $config['resize']['max_height']));
            query(insert_documentos_clientes($clave_cuenta, $data), $link);
        }
        close($link);
    }

    if (!isset($_FILES[$config['uploads']['varname']])) {
        header('Location: index.php');
        Exit;
    }

    if (!isset($_POST['clave_cuenta'])) {
        header('Location: index.php');
        Exit;
    }

    guardar_imagenes(sanitizar($_POST['clave_cuenta']),
                     $_FILES[$config['uploads']['varname']],
                     $config);

    header('Location : index.php');
