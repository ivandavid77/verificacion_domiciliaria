<?php
    $config = require_once('config.php');
    require_once('inicio_sesion.php');
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

    function preparar_conexion($config) {
        $link = mysql_connect($config['db']['host'], $config['db']['user'],
                          $config['db']['password']);
        mysql_select_db($config['db']['database'], $link);
        if (mysql_errno($link)) {
            echo mysql_errno($link).':'.mysql_error($link);
            Exit;
        }
        return $link;
    }

    // http://php.net/manual/en/function.imagecopyresampled.php
    function obtener_contenido($filename, $max_w, $max_h) {
        list($src_w, $src_h) = getimagesize($filename);
        $src_ratio = $src_w/$src_h;

        if ($max_w/$max_h > $src_ratio) {
            $max_h = $max_h*$src_ratio;
        } else {
           $max_h = $max_w/$src_ratio;
        }
        $image_p = imagecreatetruecolor($max_w, $max_h);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $max_w, $max_h,
                           $src_w, $src_h);
        ob_start();
        imagejpeg($image_p, null, 100);
        return base64_encode(ob_get_clean());
    }

    function guardar_imagenes($clave_cuenta, $uploads, $config) {
        $link = preparar_conexion($config);
        $uploads = diverse_array($uploads);
        foreach ($uploads as $file) {
            if ($file['error'] != UPLOAD_ERR_OK ||
                @!is_uploaded_file($file['tmp_name']) ||
                @getimagesize($file['tmp_name']) === false) {
                continue; // Solo archivos sin errores
            }
            // Guardar
            //$name = md5_file($file['tmp_name']);
            $data = obtener_contenido($file['tmp_name'],
                                       $config['resize']['max_width'],
                                       $config['resize']['max_height']);
            echo 'INSERT INTO documentos_clientes SET '.
                "clave_cuenta = \"$clave_cuenta\",".
                "id_documento = \"11\",".
                "archivo = \"$data\"";
            /*mysql_query(
                'INSERT INTO documentos_clientes SET '.
                "clave_cuenta = \"$clave_cuenta\",".
                "id_documento = \"11\",".
                "archivo = \"$data\"",
                $link);*/

            if (mysql_errno($link)) {
                echo mysql_errno($link).':'.mysql_error($link);
            }
        }
        mysql_close($link);
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
