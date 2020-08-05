<?php

include 'conexion.php';

class MainService
{
    public $conexion;

    function __construct()
    {
        $conexion = new Conexion();
        $this->conexion = $conexion->obtenerConexion();
    }
}

?>