<?php
    require_once('db_utils.php');

    function insertar_documentos_clientes($clave_cuenta, $documento, $data) {
        $clave_cuenta = escape($clave_cuenta);
        $documento = escape($documento);
        $data = escape($data);
        return
            'INSERT INTO documentos_clientes SET '.
            "clave_cuenta = \"$clave_cuenta\",".
            "id_documento = \"$documento\",".
            "archivo = \"$data\"";
    }

    function obtener_documentos_clientes($clave_cuenta, $documento) {
        $clave_cuenta = escape($clave_cuenta);
        $documento = escape($documento);
        return
            'SELECT archivo '.
            'FROM documentos_clientes '.
            'WHERE '.
                    "clave_cuenta = \"$clave_cuenta\" AND ".
                    "id_documento = \"$documento\"";
    }

    function borrar_documentos_clientes($clave_cuenta, $documento) {
        $clave_cuenta = escape($clave_cuenta);
        $documento = escape($documento);
        return
            'DELETE FROM documentos_clientes '.
            'WHERE '.
                    "clave_cuenta = \"$clave_cuenta\" AND ".
                    "id_documento = \"$documento\"";
    }

    function actualizar_documentos_clientes($clave_cuenta, $documento, $data) {
        $clave_cuenta = escape($clave_cuenta);
        $documento = escape($documento);
        $data = escape($data);
        return
            'UPDATE documentos_clientes SET '.
            "archivo = \"$data\" ".
            'WHERE '.
                    "clave_cuenta = \"$clave_cuenta\" AND ".
                    "id_documento = \"$documento\"";
    }
