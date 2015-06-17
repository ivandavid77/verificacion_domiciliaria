<?php
    $config = require('config.php');
    require_once('inicio_sesion.php');
    require_once('image_utils.php');
    require_once('db_utils.php');
    require_once('queries.php');

    // sergio_ag.terra.com.br http://php.net/manual/es/reserved.variables.files.php
    function diverse_array($vector) {
        $result = array();
        foreach($vector as $key1 => $value1)
            foreach($value1 as $key2 => $value2)
                $result[$key2][$key1] = $value2;
        return $result;
    }

    function guardar_imagenes($clave_cuenta, $id_documento, $uploads, $link,
                              $max_width, $max_height) {
        $sucess = false;
        foreach ($uploads as $file) {
            if ($file['error'] != UPLOAD_ERR_OK ||
                @!is_uploaded_file($file['tmp_name']) ||
                @getimagesize($file['tmp_name']) === false) {
                continue; // Solo archivos sin errores
            }
            $data = base64_encode(resize_image($file['tmp_name'], $max_width,
                                               $max_height));
            $query = obtener_documentos_clientes($clave_cuenta, $id_documento);
            if (make_query($query, $link) === false)
                $fun = 'insertar_documentos_clientes';
            else
                $fun = 'actualizar_documentos_clientes';
            $query = $$fun($clave_cuenta, $id_documento, $data);
            $sucess = make_query($query, $link);
        }
        return $sucess;
    }

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    ini_set('file_uploads','On');
    set_time_limit(0);

    if (!array_key_exists($config['uploads']['varname'], $_FILES)) {
        $_SESSION['msg']['type'] = 'warn';
        $_SESSION['msg']['data'] = 'Debe subir imagenes';
        header('Location: index.php');
        Exit;
    }

    if (!array_key_exists('clave_cuenta', $_POST) ||
        trim($_POST['clave_cuenta']) == '') {
        $_SESSION['msg']['type'] = 'warn';
        $_SESSION['msg']['data'] = 'Indique la clave de cuenta';
        header('Location: index.php');
        Exit;
    }

    $link = make_link($config['db']['host'], $config['db']['user'],
                      $config['db']['password'], $config['db']['database']);

    $clave_cuenta = sanitize_string($_POST['clave_cuenta']);
    $uploads = diverse_array($_FILES[$config['uploads']['varname']]);
    $sucess = guardar_imagenes($clave_cuenta,
                               $config['document']['begin_with_id'],
                               $uploads,
                               $config['resize']['max_width'],
                               $config['resize']['max_height']);
    if ($sucess) {
        $_SESSION['msg']['type'] = 'info';
        $_SESSION['msg']['data'] = 'Se han agregado las imagenes';
    } else {
        $_SESSION['msg']['type'] = 'error';
        $_SESSION['msg']['data'] = 'Error al guardar imagenes';
    }

    make_close($link);
    header('Location: index.php');
}
