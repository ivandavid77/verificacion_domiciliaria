<?php
    require_once('db_utils.php');
    require_once('queries.php');

    function set_data($cuenta, $id, $data, $link) {
        $query = obtener_documentos_clientes($cuenta, $id);
        if (make_query($query, $link) === false)
            $query = insertar_documentos_clientes($cuenta, $id, $data);
        else
            $query = actualizar_documentos_clientes($cuenta, $id, $data);
        return make_query($query, $link);
    }

if (basename(__file__) == basename($_SERVER['PHP_SELF'])) {
    require_once('inicio_sesion.php');

    $config = require('config.php');
    require_once('image_utils.php');
    ini_set('file_uploads','On');
    set_time_limit(0);

    // sergio_ag.terra.com.br http://php.net/manual/es/reserved.variables.files.php
    function diverse_array($vector) {
        $result = array();
        foreach($vector as $key1 => $value1)
            foreach($value1 as $key2 => $value2)
                $result[$key2][$key1] = $value2;
        return $result;
    }

    if (!array_key_exists($config['uploads']['varname'], $_FILES)) {
        $_SESSION['msg']['type'] = 'warn';
        $_SESSION['msg']['data'] = 'Debe subir imagenes';
        header('Location: index.php');
        exit;
    }

    if (!array_key_exists('clave_cuenta', $_POST) ||
        trim($_POST['clave_cuenta']) == '') {
        $_SESSION['msg']['type'] = 'warn';
        $_SESSION['msg']['data'] = 'Indique la clave de cuenta';
        header('Location: index.php');
        exit;
    }

    $link = make_link($config['db']['host'], $config['db']['user'],
                      $config['db']['password'], $config['db']['database']);
    $cuenta = sanitize_string($_POST['clave_cuenta']);
    $id = $config['document']['begin_with_id'];
    $uploads = diverse_array($_FILES[$config['uploads']['varname']]);
    $_SESSION['messages'] = array();

    foreach ($uploads as $file) {
        if ($file['error'] != 0 ||
            @getimagesize($file['tmp_name']) === false ||
            @!is_uploaded_file($file['tmp_name'])) {
            // Imagen con error, descartar e informar
            $msg['type'] = 'error';
            $msg['data'] = 'Error al agregar '.$file['name'];
            $_SESSION['messages'][] = $msg;
            continue;
        }
        $data = resize_image($file['tmp_name'],
                             $config['resize']['max_width'],
                             $config['resize']['max_height']);
        $sucess = set_data($cuenta, $id++, base64_encode($data), $link);
        if ($sucess) {
            $msg['type'] = 'info';
            $msg['data'] = 'Se ha agrego '.$file['name'];
        } else {
            $msg['type'] = 'error';
            $msg['data'] = 'Error al agregar '.$file['name'];
        }
        $_SESSION['messages'][] = $msg;
    }

    make_close($link);
    header('Location: index.php');
}
