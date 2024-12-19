<?php
require_once(__DIR__ . '/../persistencia/Conexion.php');
require_once(__DIR__ . '/../persistencia/ClienteDAO.php');

class Cliente
{
    private $idCliente;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;

    public function getIdCliente()
    {
        echo "en get: " . $this->idCliente;
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }
    public function __construct($idCliente = 0, $nombre = "", $apellido = "", $correo = "", $clave = "")
    {
        $this->idCliente = $idCliente;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
    }

    public function autenticar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO(null, null, null, $this->correo, $this->clave);
        $conexion->ejecutarConsulta($clienteDAO->autenticar());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        } else {
            $registro = $conexion->siguienteRegistro();
            $this->idCliente = $registro[0];
            $conexion->cerrarConexion();
            return true;
        }
    }

    public function consultar() {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $clienteDAO = new ClienteDAO($this->idCliente);

        $conexion->ejecutarConsulta($clienteDAO->consultar());

        $registro = $conexion->siguienteRegistro();

        if ($registro) {
            $this->idCliente = $registro[0];
            $this->nombre = $registro[1];
            $this->apellido = $registro[2];
            $this->correo = $registro[3];
        } else {
            throw new Exception("Cliente no encontrado.");
        }
        $conexion->cerrarConexion();
    }

    public function registrar($nombre, $apellido, $correo, $clave)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO();
        $conexion->ejecutarConsulta($clienteDAO->insertar($nombre, $apellido, $correo, $clave));
        $conexion->cerrarConexion();
        return true;
    }
}
