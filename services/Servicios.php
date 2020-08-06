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
    function encontrarFuncionalidad($cod_funcionalidad,$cod_modulo)
    {
        $result = $this->conexion->query("SELECT * FROM seg_funcionalidad WHERE COD_FUNCIONALIDAD='".$cod_funcionalidad."' AND COD_MODULO='".$cod_modulo."'");
        if($result->num_rows>0)
        {
            return $result->fetch_assoc();
        }
        else
        {
            return null;
        }
    }
    function modificarFuncionalidad($cod_funcionalidad,$url,$nombre,$descripcion)
    {
        $stmt = $this->conexion->prepare("UPDATE seg_funcionalidad SET URL_PRINCIPAL=?,NOMBRE=?,DESCRIPCION=?
                                          WHERE COD_FUNCIONALIDAD=?");
        $stmt->bind_param('ssss' ,$url, $nombre, $descripcion, $cod_funcionalidad);
        $stmt->execute();
        $stmt->close();
    }
    function eliminarFuncionalidad($cod_funcionalidad)
    {
        $stmt = $this->conexion->prepare("DELETE FROM seg_funcionalidad WHERE COD_FUNCIONALIDAD=?");
        $stmt->bind_param('s',$cod_funcionalidad);
        $stmt->execute();
        $stmt->close();
    }

    //ROLES
    function mostrarRoles()
    {
        return $this->conexion->query("SELECT * FROM seg_rol");
    }
    function mostrarModulosPorRol($cod_rol)
    {
        return $this->conexion->query("SELECT seg_modulo.NOMBRE, seg_modulo.COD_MODULO, rol_modulo.COD_ROL
        FROM seg_modulo 
        INNER JOIN rol_modulo 
        ON seg_modulo.COD_MODULO = rol_modulo.COD_MODULO
        WHERE rol_modulo.COD_ROL = '".$cod_rol."'");
    }
    function insertarModuloPorRol($cod_rol,$cod_modulo)
    {
        $stmt = $this->conexion->prepare("INSERT INTO rol_modulo(COD_ROL,COD_MODULO) 
                                          VALUES (?,?)");
        $stmt->bind_param('ss',$cod_rol,$cod_modulo);
        $stmt->execute();
        $stmt->close();
    }
    function eliminarModuloPorRol($cod_rol,$cod_modulo)
    {
        $stmt = $this->conexion->prepare("DELETE FROM rol_modulo WHERE COD_ROL=? AND COD_MODULO=?");
        $stmt->bind_param('ss',$cod_rol,$cod_modulo);
        $stmt->execute();
        $stmt->close();
    }

}

?>