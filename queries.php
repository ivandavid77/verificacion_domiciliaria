<?php
    function insert_documentos_clientes($clave_cuenta, $data) {
        return
            'INSERT INTO documentos_clientes SET '.
            "clave_cuenta = \"$clave_cuenta\",".
            "id_documento = \"11\",".
            "archivo = \"$data\"";
    }
