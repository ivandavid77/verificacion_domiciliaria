<?php
    $config = require('config.php');
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
        $saved = false;
        foreach ($uploads as $file) {
            if ($file['error'] != UPLOAD_ERR_OK ||
                @!is_uploaded_file($file['tmp_name']) ||
                @getimagesize($file['tmp_name']) === false) {
                continue; // Solo archivos sin errores
            }
            //$name = md5_file($file['tmp_name']);
            $data = base64_encode(resize_image(
                                            $file['tmp_name'],
                                            $config['resize']['max_width'],
                                            $config['resize']['max_height']));
            make_query(insert_documentos_clientes($clave_cuenta, $data), $link);
            $saved = true;
        }
        make_close($link);
        return $saved;
    }

    if (!array_key_exists($config['uploads']['varname'], $_FILES)) {
        $_SESSION['msg']['type'] = 'warn';
        $_SESSION['msg']['data'] = 'Debe subir imagenes';
        header('Location: index.php');
        Exit;
    }
    Exit;

    if (!array_key_exists($_POST['clave_cuenta']) ||
        trim($_POST['clave_cuenta']) == '') {
        $_SESSION['msg']['type'] = 'warn';
        $_SESSION['msg']['data'] = 'Indique la clave de cuenta';
        header('Location: index.php');
        Exit;
    }

    if (guardar_imagenes(sanitizar($_POST['clave_cuenta']),
                     $_FILES[$config['uploads']['varname']],
                     $config)) {
        $_SESSION['msg']['type'] = 'info';
        $_SESSION['msg']['data'] = 'Se han agregado las imagenes';
    } else {
        $_SESSION['msg']['type'] = 'error';
        $_SESSION['msg']['data'] = 'Error al guardar imagenes';
    }
    header('Location: index.php');
