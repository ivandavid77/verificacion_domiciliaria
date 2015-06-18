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




if (basename(__file__) == basename($_SERVER['PHP_SELF'])) {
    require_once('inicio_sesion.php');

    $config = require('config.php');
    ini_set('file_uploads','On');
    set_time_limit(0);

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
            // Descartar
            if ($file['error'] != 4) {
                // informar
                $msg['type'] = 'error';
                $msg['data'] = 'Error al agregar '.$file['name'];
                $_SESSION['messages'][] = $msg;
            }
            continue;
        }
        $data = resize_image($file['tmp_name'],
                             $config['resize']['max_width'],
                             $config['resize']['max_height']);
        $sucess = set_data($cuenta, $id++, base64_encode($data), $link);
        if ($sucess) {
            $msg['type'] = 'info';
            $msg['data'] = 'Se agrego '.$file['name'];
        } else {
            $msg['type'] = 'error';
            $msg['data'] = 'Error al agregar '.$file['name'];
        }
        $_SESSION['messages'][] = $msg;
    }

    make_close($link);
    header('Location: index.php');
}
