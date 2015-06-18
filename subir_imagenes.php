<?php
    require_once('db_utils.php');
    require_once('queries.php');


    function set_data($cuenta, $id, $data, $link) {
        $query = obtener_documentos_clientes($cuenta, $id);
        $result = make_query($query, $link);
        if (mysql_num_rows($result) == 0)
            $query = insertar_documentos_clientes($cuenta, $id, $data);
        else
            $query = actualizar_documentos_clientes($cuenta, $id, $data);
        return make_query($query, $link);
    }


    // http://php.net/manual/en/function.imagecopyresampled.php
    function resize_image($filename, $max_w, $max_h, $to_file=null) {
        list($src_w, $src_h) = getimagesize($filename);
        $src_ratio = $src_w/$src_h;
        if ($max_w/$max_h > $src_ratio) {
            $max_h = $max_h*$src_ratio;
        } else {
           $max_h = $max_w/$src_ratio;
        }
        $img_p = imagecreatetruecolor($max_w, $max_h);
        $img = imagecreatefromjpeg($filename);
        imagecopyresampled($img_p, $img, 0, 0, 0, 0, $max_w, $max_h, $src_w,
                           $src_h);
        if ($to_file === null) {
            ob_start();
            imagejpeg($img_p, null, 100);
            return ob_get_clean();
        } else {
            imagejpeg($img_p, $to_file, 100);
            return $to_file;
        }
    }


    // sergio_ag.terra.com.br http://php.net/manual/es/reserved.variables.files.php
    function diverse_array($vector) {
        $result = array();
        foreach($vector as $key1 => $value1)
            foreach($value1 as $key2 => $value2)
                $result[$key2][$key1] = $value2;
        return $result;
    }


    function create_msg($type, $data) {
        $msg['type'] = $type;
        $msg['data'] = $data;
        return $msg;
    }


    function create_err($data) {
        return create_msg('error', $data);
    }


    function create_info($data) {
        return create_msg('info', $data);
    }


    function create_warn($data) {
        return create_msg('warn', $data);
    }


    function valid_image($name, $filepath, $status, $check_uploaded=true) {
        if ($status == 4)
            return array(false, '');
        if ($status != 0 ||
            @getimagesize($filepath) === false ||
            ($check_uploaded && @!is_uploaded_file($filepath)) {
            return array(false, create_err("Error al agregar $name"));
        }
        return array(true, '');
    }


if (basename(__file__) == basename($_SERVER['PHP_SELF'])) {
    require_once('inicio_sesion.php');

    $cfg = require('config.php');
    ini_set('file_uploads','On');
    set_time_limit(0);
    $_SESSION['messages'] = array();

    if (!array_key_exists($cfg['uploads']['varname'], $_FILES)) {
        $_SESSION['messages'][] = create_warn('Debe subir imagenes');
        header('Location: index.php');
        exit;
    }

    if (!array_key_exists('clave_cuenta', $_POST) || trim($_POST['clave_cuenta']) == '') {
        $_SESSION['messages'][] = create_warn('Indique la clave de cuenta');
        header('Location: index.php');
        exit;
    }

    $link = make_link($cfg['db']['host'], $cfg['db']['user'],
                      $cfg['db']['password'], $cfg['db']['database']);
    $cuenta = sanitize_string($_POST['clave_cuenta']);
    $id_doc = $cfg['document']['begin_with_id'];
    $uploads = diverse_array($_FILES[$cfg['uploads']['varname']]);

    foreach ($uploads as $f) {
        list($valid, $error) = valid_image($f['name'], $f['tmp_name'], $f['error']);
        if (!$valid) {
            $_SESSION['messages'][] = $error;
            continue;
        }
        $data = resize_image($f['tmp_name'], $cfg['resize']['max_width'],
                             $cfg['resize']['max_height']);
        if (set_data($cuenta, $id_doc, base64_encode($data), $link))
            $_SESSION['messages'][] = create_info('Se agrego '.$f['name']);
        else
            $_SESSION['messages'][] = create_error('Error al agregar '.$f['name']);
        $id_doc++;
    }

    make_close($link);
    header('Location: index.php');
}
