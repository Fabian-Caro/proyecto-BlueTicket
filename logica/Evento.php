<?php
require_once (__DIR__ . '/../persistencia/Conexion.php');
require (__DIR__ . '/../persistencia/EventoDAO.php');
require_once(__DIR__ . '/../logica/Categoria.php');
require_once(__DIR__ . '/../logica/Artista.php');
class Evento{
    private $idEvento;
    private $nombreEvento;
    private $proveedor;
    private $categoria;
    private $artista;

    public function getIdEvento()
    {
        return $this->idEvento;
    }

    public function setIdEvento($idEvento)
    {
        $this->idEvento = $idEvento;

        return $this;
    }

    public function getNombreEvento()
    {
        return $this->nombreEvento;
    }

    public function setNombreEvento($nombreEvento)
    {
        $this->nombreEvento = $nombreEvento;

        return $this;
    }

    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getArtista()
    {
        return $this->artista;
    }

    public function setArtista($artista) {
        $this->artista = $artista;
    }

    public function __construct($idEvento=0, $nombreEvento="", $categoria=null, $artista=null) {
        $this -> idEvento = $idEvento;
        $this -> nombreEvento = $nombreEvento;
        $this -> categoria = $categoria;
        $this -> artista = $artista;
    }
    public function consultarTodos(){
        $categorias = array();
        $artistas = array();
        $eventos = array();
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $eventoDAO = new EventoDAO();
        $conexion -> ejecutarConsulta($eventoDAO -> consultarTodos());
        while($registro = $conexion -> siguienteRegistro()){
            $categoria = null;
            $artista = null;
            if(array_key_exists($registro[2], $categorias)){
                $categoria = $categorias[$registro[2]];
            }else{
                $categoria = new Categoria($registro[2]);
                $categoria -> consultar();
                $categorias[$registro[2]] = $categoria;
            }
            if(array_key_exists($registro[3], $artistas)){
                $artista = $artistas[$registro[3]];
            }else{
                $artista = new Artista($registro[3]);
                $artista -> consultar();
                $artistas[$registro[3]] = $artista;
            }
            $evento = new Evento($registro[0], $registro[1], $categoria, $artista);
            array_push($eventos, $evento);
        }
        $conexion -> cerrarConexion();
        return $eventos;        
    }
    public function consultarIdEvento($idEvento) {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $eventoDAO = new EventoDAO();
        
        $conexion->ejecutarConsulta($eventoDAO->consultarIdEvento($idEvento));
        
        $registro = $conexion->siguienteRegistro();
        if (!$registro) {
            return null;
        }

        $categoria = new Categoria($registro[3]);
        $categoria->consultar();
        $artista = new Artista($registro[4]);
        $artista->consultar();
    
        $evento = new Evento($registro[0], $registro[1], $categoria, $artista);
        
        $conexion->cerrarConexion();
        return $evento;
    }

    public function consultar(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $eventoDAO = new EventoDAO($this->idEvento);
        $conexion->ejecutarConsulta($eventoDAO->consultar());
        $registro = $conexion->siguienteRegistro();
        $this->nombreEvento = $registro[0];
        $conexion -> cerrarConexion();
    }
    public function insertar($nombre="",$idProveedor=0,$idCategoria=0,$idArtista=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $eventoDAO = new EventoDAO();
        
        try {
            $query = $eventoDAO->insert($nombre, $idProveedor,$idCategoria,$idArtista);
            $conexion->ejecutarConsulta($query);
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        $conexion -> cerrarConexion();
    }
}
?>