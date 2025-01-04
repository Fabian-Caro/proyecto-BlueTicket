<?php
require_once (__DIR__ . '/../Cliente.php');
require_once (__DIR__ . '/../Proveedor.php');

class Autentificacion {
    public static function autentificar ($correo, $clave) {
        $proveedor = new Proveedor(null, null, null, $correo, $clave);

        if ($proveedor -> autenticar()) {
            return ['rol' => 'proveedor', 'id' => $proveedor -> getIdProveedor()];
        }

        $cliente = new Cliente(null, null, null, $correo, $clave);

        if ($cliente -> autenticar()) {
            return ['rol' => 'cliente', 'id' => $cliente -> getIdCliente()];
        }

        return null;
    }
}

?>