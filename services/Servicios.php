<?php

include 'MainService.php';

class Servicios extends MainService
{
    //MODULOS
    function mostrarModulos()
    {
        return $this->conexion->query("SELECT * FROM seg_modulo WHERE ESTADO='ACT'");
    }
    function insertarModulo($cod_modulo,$nombre,$estado)
    {
        $stmt = $this->conexion->prepare("INSERT INTO seg_modulo(COD_MODULO,NOMBRE,ESTADO) 
                                          VALUES (?,?,?)");
        $stmt->bind_param('sss',$cod_modulo,$nombre,$estado);
        $stmt->execute();
        $stmt->close();
    }
    function encontrarModulo($cod_modulo)
    {
        $result = $this->conexion->query("SELECT * FROM seg_modulo WHERE COD_MODULO='".$cod_modulo."'");
        if($result->num_rows>0)
        {
            return $result->fetch_assoc();
        }
        else
        {
            return null;
        }
    }
    function modificarModulo($cod_modulo, $nombre, $estado, $cod_modulo_comparar)
    {
        $stmt = $this->conexion->prepare("UPDATE seg_modulo SET COD_MODULO=?,NOMBRE=?,ESTADO=?
                                          WHERE COD_MODULO=?");
        $stmt->bind_param('ssss' ,$cod_modulo, $nombre, $estado, $cod_modulo_comparar);
        $stmt->execute();
        $stmt->close();
    }
    function eliminarLogicoModulo($cod_modulo)
    {
        $stmt = $this->conexion->prepare("UPDATE seg_modulo SET ESTADO='INA' WHERE COD_MODULO=?");
        $stmt->bind_param('s',$cod_modulo);
        $stmt->execute();
        $stmt->close();
    }

    //FUNCIONALIDADES
    function mostrarFuncionalidades($cod_modulo)
    {
        return $this->conexion->query("SELECT * FROM seg_funcionalidad WHERE COD_MODULO='".$cod_modulo."'");
    }
    function insertarFuncionalidad ($url_principal,$nombre,$descripcion,$cod_modulo)
    {
        $stmt = $this->conexion->prepare("INSERT INTO seg_funcionalidad(COD_MODULO,URL_PRINCIPAL,NOMBRE,DESCRIPCION) 
                                          VALUES (?,?,?,?)");
        $stmt->bind_param('ssss',$cod_modulo,$url_principal,$nombre,$descripcion);
        $stmt->execute();
        $stmt->close();
    }
    function encontrarFuncionalidad($cod_funcionalidad)
    {
        $result = $this->conexion->query("SELECT * FROM seg_funcionalidad WHERE COD_FUNCIONALIDAD='".$cod_funcionalidad."'");
        if($result->num_rows>0)
        {
            return $result->fetch_assoc();
        }
        else
        {
            return null;
        }
    }

    //ROLES
    function mostrarRoles()
    {
        return $this->conexion->query("SELECT * FROM seg_rol");
    }
    function mostrarModulosPorRol($cod_rol)
    {
        return $this->conexion->query("SELECT * FROM rol_modulo WHERE COD_ROL='".$cod_rol."'");
    }

}

?>