<?php
require_once('db_utils.php');


function sqlUsuario($user, $password, $link)
{
    $user = escape(strval($user), $link);
    $password = escape(strval($password), $link);
    return
        "SELECT clave_usuario
        FROM corporativo.usuarios
        WHERE
            usuario = \"$user\" AND
            contrasenna = OLD_PASSWORD(\"$password\")
        LIMIT 1";
}

function sqlCuenta($claveCuenta, $link)
{
    $claveCuenta = escape(strval($claveCuenta), $link);
    return
        "SELECT 1
        FROM corporativo.cuentas
        WHERE clave_cuenta = \"$claveCuenta\"";
}


function sqlInsertarDocumento($claveCuenta, $claveUsuario, $idDoc, $datosB64, $link)
{
    $claveCuenta = escape(strval($claveCuenta), $link);
    $claveUsuario = strval($claveUsuario);
    $idDoc = escape(strval($idDoc), $link);
    $datosB64 = escape(strval($datosB64), $link);
    return
        "INSERT INTO expediente.documentos_clientes SET
        clave_cuenta = \"$claveCuenta\",
        id_documento = \"$idDoc\",
        archivo = \"$datosB64\",
        fecha_actualizacion = CURDATE(),
        usuario_actualiza = \"$claveUsuario\"";
}

function sqlActualizarDocumento($claveCuenta, $claveUsuario, $idDoc, $datosB64, $link)
{
    $claveCuenta = escape(strval($claveCuenta), $link);
    $claveUsuario = strval($claveUsuario);
    $idDoc = escape(strval($idDoc), $link);
    return
        "UPDATE expediente.documentos_clientes SET
        archivo = \"$datosB64\",
        fecha_actualizacion = CURDATE(),
        usuario_actualiza = \"$claveUsuario\"
        WHERE
            clave_cuenta = \"$claveCuenta\" AND
            id_documento = \"$idDoc\"";
}

function sqlObtenerDocumento($claveCuenta, $idDoc, $link)
{
    $claveCuenta = escape(strval($claveCuenta), $link);
    $idDoc = escape(strval($idDoc), $link);
    return
        "SELECT 1
        FROM expediente.documentos_clientes
        WHERE
            clave_cuenta = \"$claveCuenta\" AND
            id_documento = \"$idDoc\"";
}

function sqlBorrarDocumento($claveCuenta, $idDoc, $link)
{
    $claveCuenta = escape(strval($claveCuenta), $link);
    $idDoc = escape(strval($idDoc));
    return
        "DELETE FROM expediente.documentos_clientes
        WHERE
            clave_cuenta = \"$claveCuenta\" AND
            id_documento = \"$idDoc\"";
}
