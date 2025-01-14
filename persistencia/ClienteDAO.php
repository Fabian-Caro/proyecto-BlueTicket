<?php


class ClienteDAO{
    private $idCliente;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;

    public function __construct($idCliente=0, $nombre="", $apellido="", $correo="", $clave=""){
        $this -> idCliente = $idCliente;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> correo = $correo;
        $this -> clave = $clave;
    }
    public function autenticar(){
        return "select idCliente
                from Cliente 
                where correo = '" . $this -> correo . "' and clave = '" . $this -> clave . "'";
    }
    
    public function consultar(){
        return "select nombre, apellido, correo
                from Cliente
                where idCliente = '" . $this -> idCliente . "'";
    }

    public function consultarBoletas(){
        return "SELECT b.idFactura, c.nombre, c.apellido, b.nombre_usuario, e.nombre, d.fecha, f.idCliente 
                FROM boleta b 
                JOIN factura f ON b.idFactura = f.idFactura 
                JOIN cliente c ON f.idCliente = c.idCliente
                JOIN detalle_evento d ON b.idDetalle = d.idDetalle 
                JOIN evento e ON d.idEvento = e.idEvento
                WHERE f.idCliente = ".$this->idCliente;

    }
}

?>